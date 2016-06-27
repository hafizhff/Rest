<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Welcome extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


		public function index()
	{
	    $this->load->view('welcome_message');
	}
	 

	 function Welcome_get()
    {
        $data = $this->db->query("select * from unit")->result();
        //simplexml_load_string($this->response($data));
        json_encode($this->response($data));
    }

    public function world_get() {
    $data = array();
    $data['name'] = "TESTNAME";
    $this->simplexml_load_string($data); 
  }

}
