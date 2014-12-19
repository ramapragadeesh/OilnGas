<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class general extends CI_Controller {

	/**
	 * Index Page for this controller.
	**/

	public function __construct()
	{
		parent::__construct();

	}

	public function country_list()
	{

		$this->load->model("generalinfo");
		$this->generalinfo->country_list();
	}
}
?>