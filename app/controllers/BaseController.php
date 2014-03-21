<?php

class BaseController extends Controller {

    /**
     * @var string
     */
    protected $layout_name = 'layouts.wrapper';

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (Request::path() !== 'ajax/project/issueUploadAttachment')
        {
            $this->beforeFilter('auth');
        }
    }

    /**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout_name))
		{
			$this->layout = View::make($this->layout_name);
		}
	}
}
