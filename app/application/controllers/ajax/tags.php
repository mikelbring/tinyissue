<?php

class Ajax_Tags_Controller extends Base_Controller {

	public function get_suggestions($type = 'edit') {
		$retval = array();

		$term = Input::get('term', '');
		if ($term) {
			$tags = Tag::where('tag', 'LIKE', '%' . $term . '%')->get();
			foreach ($tags as $tag) {
				if ($type == 'filter' && strpos($tag->tag, ':') !== false) {
					$tag_prefix = substr($tag->tag, 0, strpos($tag->tag, ':'));
					$tag_asterisk = $tag_prefix . ':*';
					if (!in_array($tag_asterisk, $retval)) {
						$retval[] = $tag_asterisk;
					}
				}
				$retval[] = $tag->tag;
			}
		}

		return json_encode($retval);
	}

}