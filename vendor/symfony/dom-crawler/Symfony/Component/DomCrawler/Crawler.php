<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DomCrawler;

use Symfony\Component\CssSelector\CssSelector;

/**
 * Crawler eases navigation of a list of \DOMNode objects.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @api
 */
class Crawler extends \SplObjectStorage
{
    /**
     * @var string The current URI or the base href value
     */
    protected $uri;

    /**
     * @var string The default namespace prefix to be used with XPath and CSS expressions
     */
    private $defaultNamespacePrefix = 'default';

    /**
     * @var array A map of manually registered namespaces
     */
    private $namespaces = array();

    /**
     * Constructor.
     *
     * @param mixed  $node A Node to use as the base for the crawling
     * @param string $uri  The current URI or the base href value
     *
     * @api
     */
    public function __construct($node = null, $uri = null)
    {
        $this->uri = $uri;

        $this->add($node);
    }

    /**
     * Removes all the nodes.
     *
     * @api
     */
    public function clear()
    {
        $this->removeAll($this);
    }

    /**
     * Adds a node to the current list of nodes.
     *
     * This method uses the appropriate specialized add*() method based
     * on the type of the argument.
     *
     * @param \DOMNodeList|\DOMNode|array|string|null $node A node
     *
     * @throws \InvalidArgumentException When node is not the expected type.
     *
     * @api
     */
    public function add($node)
    {
        if ($node instanceof \DOMNodeList) {
            $this->addNodeList($node);
        } elseif ($node instanceof \DOMNode) {
            $this->addNode($node);
        } elseif (is_array($node)) {
            $this->addNodes($node);
        } elseif (is_string($node)) {
            $this->addContent($node);
        } elseif (null !== $node) {
            throw new \InvalidArgumentException(sprintf('Expecting a DOMNodeList or DOMNode instance, an array, a string, or null, but got "%s".', is_object($node) ? get_class($node) : gettype($node)));
        }
    }

    /**
     * Adds HTML/XML content.
     *
     * If the charset is not set via the content type, it is assumed
     * to be ISO-8859-1, which is the default charset defined by the
     * HTTP 1.1 specification.
     *
     * @param string      $content A string to parse as HTML/XML
     * @param null|string $type    The content type of the string
     */
    public function addContent($content, $type = null)
    {
        if (empty($type)) {
            $type = 0 === strpos($content, '<?xml') ? 'application/xml' : 'text/html';
        }

        // DOM only for HTML/XML content
        if (!preg_match('/(x|ht)ml/i', $type, $xmlMatches)) {
            return null;
        }

        $charset = null;
        if (false !== $pos = stripos($type, 'charset=')) {
            $charset = substr($type, $pos + 8);
            if (false !== $pos = strpos($charset, ';')) {
                $charset = substr($charset, 0, $pos);
            }
        }

        if (null === $charset &&
            preg_match('/\<meta[^\>]+charset *= *["\']?([a-zA-Z\-0-9]+)/i', $content, $matches)) {
            $charset = $matches[1];
        }

        if (null === $charset) {
            $charset = 'ISO-8859-1';
        }

        if ('x' === $xmlMatches[1]) {
            $this->addXmlContent($content, $charset);
        } else {
            $this->addHtmlContent($content, $charset);
        }
    }

    /**
     * Adds an HTML content to the list of nodes.
     *
     * The libxml errors are disabled when the content is parsed.
     *
     * If you want to get parsing errors, be sure to enable
     * internal errors via libxml_use_internal_errors(true)
     * and then, get the errors via libxml_get_errors(). Be
     * sure to clear errors with libxml_clear_errors() afterward.
     *
     * @param string $content The HTML content
     * @param string $charset The charset
     *
     * @api
     */
    public function addHtmlContent($content, $charset = 'UTF-8')
    {
        $current = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);

        $dom = new \DOMDocument('1.0', $charset);
        $dom->validateOnParse = true;

        if (function_exists('mb_convert_encoding')) {
            $hasError = false;
            set_error_handler(function () use (&$hasError) {
                $hasError = true;
            });
            $tmpContent = @mb_convert_encoding($content, 'HTML-ENTITIES', $charset);

            restore_error_handler();

            if (!$hasError) {
                $content = $tmpContent;
            }
        }

        @$dom->loadHTML($content);

        libxml_use_internal_errors($current);
        libxml_disable_entity_loader($disableEntities);

        $this->addDocument($dom);

        $base = $this->filterXPath('descendant-or-self::base')->extract(array('href'));

        $baseHref = current($base);
        if (count($base) && !empty($baseHref)) {
            if ($this->uri) {
                $linkNode = $dom->createElement('a');
                $linkNode->setAttribute('href', $baseHref);
                $link = new Link($linkNode, $this->uri);
                $this->uri = $link->getUri();
            } else {
                $this->uri = $baseHref;
            }
        }
    }

    /**
     * Adds an XML content to the list of nodes.
     *
     * The libxml errors are disabled when the content is parsed.
     *
     * If you want to get parsing errors, be sure to enable
     * internal errors via libxml_use_internal_errors(true)
     * and then, get the errors via libxml_get_errors(). Be
     * sure to clear errors with libxml_clear_errors() afterward.
     *
     * @param string $content The XML content
     * @param string $charset The charset
     *
     * @api
     */
    public function addXmlContent($content, $charset = 'UTF-8')
    {
        // remove the default namespace if it's the only namespace to make XPath expressions simpler
        if (!preg_match('/xmlns:/', $content)) {
            $content = str_replace('xmlns', 'ns', $content);
        }

        $current = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);

        $dom = new \DOMDocument('1.0', $charset);
        $dom->validateOnParse = true;
        @$dom->loadXML($content, LIBXML_NONET);

        libxml_use_internal_errors($current);
        libxml_disable_entity_loader($disableEntities);

        $this->addDocument($dom);
    }

    /**
     * Adds a \DOMDocument to the list of nodes.
     *
     * @param \DOMDocument $dom A \DOMDocument instance
     *
     * @api
     */
    public function addDocument(\DOMDocument $dom)
    {
        if ($dom->documentElement) {
            $this->addNode($dom->documentElement);
        }
    }

    /**
     * Adds a \DOMNodeList to the list of nodes.
     *
     * @param \DOMNodeList $nodes A \DOMNodeList instance
     *
     * @api
     */
    public function addNodeList(\DOMNodeList $nodes)
    {
        foreach ($nodes as $node) {
            $this->addNode($node);
        }
    }

    /**
     * Adds an array of \DOMNode instances to the list of nodes.
     *
     * @param \DOMNode[] $nodes An array of \DOMNode instances
     *
     * @api
     */
    public function addNodes(array $nodes)
    {
        foreach ($nodes as $node) {
            $this->add($node);
        }
    }

    /**
     * Adds a \DOMNode instance to the list of nodes.
     *
     * @param \DOMNode $node A \DOMNode instance
     *
     * @api
     */
    public function addNode(\DOMNode $node)
    {
        if ($node instanceof \DOMDocument) {
            $this->attach($node->documentElement);
        } else {
            $this->attach($node);
        }
    }

    /**
     * Returns a node given its position in the node list.
     *
     * @param integer $position The position
     *
     * @return Crawler A new instance of the Crawler with the selected node, or an empty Crawler if it does not exist.
     *
     * @api
     */
    public function eq($position)
    {
        foreach ($this as $i => $node) {
            if ($i == $position) {
                return new static($node, $this->uri);
            }
        }

        return new static(null, $this->uri);
    }

    /**
     * Calls an anonymous function on each node of the list.
     *
     * The anonymous function receives the position and the node wrapped
     * in a Crawler instance as arguments.
     *
     * Example:
     *
     *     $crawler->filter('h1')->each(function ($node, $i) {
     *         return $node->text();
     *     });
     *
     * @param \Closure $closure An anonymous function
     *
     * @return array An array of values returned by the anonymous function
     *
     * @api
     */
    public function each(\Closure $closure)
    {
        $data = array();
        foreach ($this as $i => $node) {
            $data[] = $closure(new static($node, $this->uri), $i);
        }

        return $data;
    }

    /**
     * Reduces the list of nodes by calling an anonymous function.
     *
     * To remove a node from the list, the anonymous function must return false.
     *
     * @param \Closure $closure An anonymous function
     *
     * @return Crawler A Crawler instance with the selected nodes.
     *
     * @api
     */
    public function reduce(\Closure $closure)
    {
        $nodes = array();
        foreach ($this as $i => $node) {
            if (false !== $closure(new static($node, $this->uri), $i)) {
                $nodes[] = $node;
            }
        }

        return new static($nodes, $this->uri);
    }

    /**
     * Returns the first node of the current selection
     *
     * @return Crawler A Crawler instance with the first selected node
     *
     * @api
     */
    public function first()
    {
        return $this->eq(0);
    }

    /**
     * Returns the last node of the current selection
     *
     * @return Crawler A Crawler instance with the last selected node
     *
     * @api
     */
    public function last()
    {
        return $this->eq(count($this) - 1);
    }

    /**
     * Returns the siblings nodes of the current selection
     *
     * @return Crawler A Crawler instance with the sibling nodes
     *
     * @throws \InvalidArgumentException When current node is empty
     *
     * @api
     */
    public function siblings()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        return new static($this->sibling($this->getNode(0)->parentNode->firstChild), $this->uri);
    }

    /**
     * Returns the next siblings nodes of the current selection
     *
     * @return Crawler A Crawler instance with the next sibling nodes
     *
     * @throws \InvalidArgumentException When current node is empty
     *
     * @api
     */
    public function nextAll()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        return new static($this->sibling($this->getNode(0)), $this->uri);
    }

    /**
     * Returns the previous sibling nodes of the current selection
     *
     * @return Crawler A Crawler instance with the previous sibling nodes
     *
     * @throws \InvalidArgumentException
     *
     * @api
     */
    public function previousAll()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        return new static($this->sibling($this->getNode(0), 'previousSibling'), $this->uri);
    }

    /**
     * Returns the parents nodes of the current selection
     *
     * @return Crawler A Crawler instance with the parents nodes of the current selection
     *
     * @throws \InvalidArgumentException When current node is empty
     *
     * @api
     */
    public function parents()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $node = $this->getNode(0);
        $nodes = array();

        while ($node = $node->parentNode) {
            if (1 === $node->nodeType) {
                $nodes[] = $node;
            }
        }

        return new static($nodes, $this->uri);
    }

    /**
     * Returns the children nodes of the current selection
     *
     * @return Crawler A Crawler instance with the children nodes
     *
     * @throws \InvalidArgumentException When current node is empty
     *
     * @api
     */
    public function children()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $node = $this->getNode(0)->firstChild;

        return new static($node ? $this->sibling($node) : array(), $this->uri);
    }

    /**
     * Returns the attribute value of the first node of the list.
     *
     * @param string $attribute The attribute name
     *
     * @return string|null The attribute value or null if the attribute does not exist
     *
     * @throws \InvalidArgumentException When current node is empty
     *
     * @api
     */
    public function attr($attribute)
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $node = $this->getNode(0);

        return $node->hasAttribute($attribute) ? $node->getAttribute($attribute) : null;
    }

    /**
     * Returns the node value of the first node of the list.
     *
     * @return string The node value
     *
     * @throws \InvalidArgumentException When current node is empty
     *
     * @api
     */
    public function text()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        return $this->getNode(0)->nodeValue;
    }

    /**
     * Returns the first node of the list as HTML.
     *
     * @return string The node html
     *
     * @throws \InvalidArgumentException When current node is empty
     */
    public function html()
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $html = '';
        foreach ($this->getNode(0)->childNodes as $child) {
            if (version_compare(PHP_VERSION, '5.3.6', '>=')) {
                // node parameter was added to the saveHTML() method in PHP 5.3.6
                // @see http://php.net/manual/en/domdocument.savehtml.php
                $html .= $child->ownerDocument->saveHTML($child);
            } else {
                $document = new \DOMDocument('1.0', 'UTF-8');
                $document->appendChild($document->importNode($child, true));
                $html .= rtrim($document->saveHTML());
            }
        }

        return $html;
    }

    /**
     * Extracts information from the list of nodes.
     *
     * You can extract attributes or/and the node value (_text).
     *
     * Example:
     *
     * $crawler->filter('h1 a')->extract(array('_text', 'href'));
     *
     * @param array $attributes An array of attributes
     *
     * @return array An array of extracted values
     *
     * @api
     */
    public function extract($attributes)
    {
        $attributes = (array) $attributes;
        $count = count($attributes);

        $data = array();
        foreach ($this as $node) {
            $elements = array();
            foreach ($attributes as $attribute) {
                if ('_text' === $attribute) {
                    $elements[] = $node->nodeValue;
                } else {
                    $elements[] = $node->getAttribute($attribute);
                }
            }

            $data[] = $count > 1 ? $elements : $elements[0];
        }

        return $data;
    }

    /**
     * Filters the list of nodes with an XPath expression.
     *
     * @param string $xpath An XPath expression
     *
     * @return Crawler A new instance of Crawler with the filtered list of nodes
     *
     * @api
     */
    public function filterXPath($xpath)
    {
        $crawler = new static(null, $this->uri);
        $prefixes = $this->findNamespacePrefixes($xpath);
        foreach ($this as $node) {
            $domxpath = $this->createDOMXPath($node->ownerDocument, $prefixes);
            $crawler->add($domxpath->query($xpath, $node));
        }

        return $crawler;
    }

    /**
     * Filters the list of nodes with a CSS selector.
     *
     * This method only works if you have installed the CssSelector Symfony Component.
     *
     * @param string $selector A CSS selector
     *
     * @return Crawler A new instance of Crawler with the filtered list of nodes
     *
     * @throws \RuntimeException if the CssSelector Component is not available
     *
     * @api
     */
    public function filter($selector)
    {
        if (!class_exists('Symfony\\Component\\CssSelector\\CssSelector')) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException('Unable to filter with a CSS selector as the Symfony CssSelector is not installed (you can use filterXPath instead).');
            // @codeCoverageIgnoreEnd
        }

        return $this->filterXPath(CssSelector::toXPath($selector));
    }

    /**
     * Selects links by name or alt value for clickable images.
     *
     * @param string $value The link text
     *
     * @return Crawler A new instance of Crawler with the filtered list of nodes
     *
     * @api
     */
    public function selectLink($value)
    {
        $xpath = sprintf('//a[contains(concat(\' \', normalize-space(string(.)), \' \'), %s)] ', static::xpathLiteral(' '.$value.' ')).
                            sprintf('| //a/img[contains(concat(\' \', normalize-space(string(@alt)), \' \'), %s)]/ancestor::a', static::xpathLiteral(' '.$value.' '));

        return $this->filterXPath($xpath);
    }

    /**
     * Selects a button by name or alt value for images.
     *
     * @param string $value The button text
     *
     * @return Crawler A new instance of Crawler with the filtered list of nodes
     *
     * @api
     */
    public function selectButton($value)
    {
        $xpath = sprintf('//input[((@type="submit" or @type="button") and contains(concat(\' \', normalize-space(string(@value)), \' \'), %s)) ', static::xpathLiteral(' '.$value.' ')).
                         sprintf('or (@type="image" and contains(concat(\' \', normalize-space(string(@alt)), \' \'), %s)) or @id="%s" or @name="%s"] ', static::xpathLiteral(' '.$value.' '), $value, $value).
                         sprintf('| //button[contains(concat(\' \', normalize-space(string(.)), \' \'), %s) or @id="%s" or @name="%s"]', static::xpathLiteral(' '.$value.' '), $value, $value);

        return $this->filterXPath($xpath);
    }

    /**
     * Returns a Link object for the first node in the list.
     *
     * @param string $method The method for the link (get by default)
     *
     * @return Link A Link instance
     *
     * @throws \InvalidArgumentException If the current node list is empty
     *
     * @api
     */
    public function link($method = 'get')
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $node = $this->getNode(0);

        return new Link($node, $this->uri, $method);
    }

    /**
     * Returns an array of Link objects for the nodes in the list.
     *
     * @return Link[] An array of Link instances
     *
     * @api
     */
    public function links()
    {
        $links = array();
        foreach ($this as $node) {
            $links[] = new Link($node, $this->uri, 'get');
        }

        return $links;
    }

    /**
     * Returns a Form object for the first node in the list.
     *
     * @param array  $values An array of values for the form fields
     * @param string $method The method for the form
     *
     * @return Form A Form instance
     *
     * @throws \InvalidArgumentException If the current node list is empty
     *
     * @api
     */
    public function form(array $values = null, $method = null)
    {
        if (!count($this)) {
            throw new \InvalidArgumentException('The current node list is empty.');
        }

        $form = new Form($this->getNode(0), $this->uri, $method);

        if (null !== $values) {
            $form->setValues($values);
        }

        return $form;
    }

    /**
     * Overloads a default namespace prefix to be used with XPath and CSS expressions.
     *
     * @param string $prefix
     */
    public function setDefaultNamespacePrefix($prefix)
    {
        $this->defaultNamespacePrefix = $prefix;
    }

    /**
     * @param string $prefix
     * @param string $namespace
     */
    public function registerNamespace($prefix, $namespace)
    {
        $this->namespaces[$prefix] = $namespace;
    }

    /**
     * Converts string for XPath expressions.
     *
     * Escaped characters are: quotes (") and apostrophe (').
     *
     *  Examples:
     *  <code>
     *     echo Crawler::xpathLiteral('foo " bar');
     *     //prints 'foo " bar'
     *
     *     echo Crawler::xpathLiteral("foo ' bar");
     *     //prints "foo ' bar"
     *
     *     echo Crawler::xpathLiteral('a\'b"c');
     *     //prints concat('a', "'", 'b"c')
     *  </code>
     *
     * @param string $s String to be escaped
     *
     * @return string Converted string
     */
    public static function xpathLiteral($s)
    {
        if (false === strpos($s, "'")) {
            return sprintf("'%s'", $s);
        }

        if (false === strpos($s, '"')) {
            return sprintf('"%s"', $s);
        }

        $string = $s;
        $parts = array();
        while (true) {
            if (false !== $pos = strpos($string, "'")) {
                $parts[] = sprintf("'%s'", substr($string, 0, $pos));
                $parts[] = "\"'\"";
                $string = substr($string, $pos + 1);
            } else {
                $parts[] = "'$string'";
                break;
            }
        }

        return sprintf("concat(%s)", implode($parts, ', '));
    }

    /**
     * @param integer $position
     *
     * @return \DOMElement|null
     */
    public function getNode($position)
    {
        foreach ($this as $i => $node) {
            if ($i == $position) {
                return $node;
            }
        // @codeCoverageIgnoreStart
        }

        return null;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param \DOMElement $node
     * @param string      $siblingDir
     *
     * @return array
     */
    protected function sibling($node, $siblingDir = 'nextSibling')
    {
        $nodes = array();

        do {
            if ($node !== $this->getNode(0) && $node->nodeType === 1) {
                $nodes[] = $node;
            }
        } while ($node = $node->$siblingDir);

        return $nodes;
    }

    /**
     * @param \DOMDocument $document
     * @param array        $prefixes
     *
     * @return \DOMXPath
     *
     * @throws \InvalidArgumentException
     */
    private function createDOMXPath(\DOMDocument $document, array $prefixes = array())
    {
        $domxpath = new \DOMXPath($document);

        foreach ($prefixes as $prefix) {
            $namespace = $this->discoverNamespace($domxpath, $prefix);
            if (null !== $namespace) {
                $domxpath->registerNamespace($prefix, $namespace);
            }
        }

        return $domxpath;
    }

    /**
     * @param \DOMXPath $domxpath
     * @param string    $prefix
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    private function discoverNamespace(\DOMXPath $domxpath, $prefix)
    {
        if (isset($this->namespaces[$prefix])) {
            return $this->namespaces[$prefix];
        }

        // ask for one namespace, otherwise we'd get a collection with an item for each node
        $namespaces = $domxpath->query(sprintf('(//namespace::*[name()="%s"])[last()]', $this->defaultNamespacePrefix === $prefix ? '' : $prefix));

        if ($node = $namespaces->item(0)) {
            return $node->nodeValue;
        }
    }

    /**
     * @param $xpath
     *
     * @return array
     */
    private function findNamespacePrefixes($xpath)
    {
        if (preg_match_all('/(?P<prefix>[a-z_][a-z_0-9\-\.]*):[^"\/]/i', $xpath, $matches)) {
            return array_unique($matches['prefix']);
        }

        return array();
    }
}
