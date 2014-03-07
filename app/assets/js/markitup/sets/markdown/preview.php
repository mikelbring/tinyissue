<?php
$markdown = '../../../../../bundles/sparkdown/parser.php';
if (file_exists($markdown)) {
    include_once($markdown);
    echo Sparkdown\Markdown($_POST['data']);
} else {
    echo "Unable to locate the markdown parser!";
}
?>