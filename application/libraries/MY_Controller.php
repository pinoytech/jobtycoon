<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends Controller {

	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */