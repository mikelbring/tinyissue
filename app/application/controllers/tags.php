<?php

class Tags_Controller extends Base_Controller {

	public function __construct() {
		parent::__construct();

		$this->filter('before', 'permission:administration');
	}

	/**
	 * Show tag list
	 *
	 * @return View
	 */
	public function get_index() {
		return $this->layout->with('active', 'dashboard')->nest('content', 'tags.index', array(
			'tags' => Tag::order_by('tag', 'ASC')->get()
		));
	}
	
	/**
	 * Create new issue
	 *
	 * @return View
	 */
	public function get_new() {
		Asset::add('spectrum-js', '/app/assets/js/spectrum.js', array('jquery'));
		Asset::add('spectrum-css', '/app/assets/css/spectrum.css');
				
		return $this->layout->with('active', 'dashboard')->nest('content', 'tags.new');
	}
	
	public function post_new() {
		$rules = array(
			'tag' => 'unique:tags|required|max:255',
			'bgcolor' => array('max:50', 'match:/^#(?:[0-9a-f]+)$/i')
		);

		$input = Input::all();
		$validator = \Validator::make($input, $rules);
		
		if ($validator->passes()) {
			$tag = new Tag;
			$tag->tag = $input['tag'];
			$tag->bgcolor = $input['bgcolor'];
			$tag->save();
			
			return Redirect::to('tags')
				->with('notice', __('tinyissue.tag_has_been_created'));
		}
		
		return Redirect::to('tag/new')
			->with_input()
			->with_errors($validator)
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}
	
	/**
	 * Edit an issue
	 *
	 * @return View
	 */
	public function get_edit($tag_id) {
		Asset::add('spectrum-js', '/app/assets/js/spectrum.js', array('jquery'));
		Asset::add('spectrum-css', '/app/assets/css/spectrum.css');
				
		$tag = Tag::find($tag_id);

		return $this->layout->with('active', 'dashboard')->nest('content', 'tags.edit', array(
			'tag' => $tag
		));
	}
	
	public function post_edit($tag_id) {
		$tag = Tag::find($tag_id);

		$rules = array(
			'tag' => 'unique:tags,tag,' . $tag_id . '|required|max:255',
			'bgcolor' => array('max:50', 'match:/^#(?:[0-9a-f]+)$/i')
		);

		$input = Input::all();

		$validator = \Validator::make($input, $rules);
		
		if ($validator->passes()) {
			$tag->tag = $input['tag'];
			$tag->bgcolor = $input['bgcolor'];
			$tag->save();
			
			return Redirect::to('tags')
				->with('notice', __('tinyissue.tag_has_been_updated'));
		}
		
		return Redirect::to('tag/' . $tag_id . '/edit')
			->with_input()
			->with_errors($validator)
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}

}