<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Data extends REST_Controller {

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
	 

	 function Data_get()
    {
       	//$now = date('Y-m-d');
       	$now = '2015-01-01';

        $data = $this->db->query("SELECT DISTINCT ON (kd_pasien) pasien.kd_pasien, pasien.nama,kamar.nama_kamar
            FROM pasien INNER JOIN
            kunjungan ON pasien.kd_pasien = kunjungan.kd_pasien inner join
            unit ON kunjungan.kd_unit = unit.kd_unit inner join
	   		nginap ON nginap.tgl_masuk = kunjungan.tgl_masuk AND nginap.kd_unit=kunjungan.kd_unit 
	   		AND nginap.urut_masuk = kunjungan.urut_masuk AND nginap.kd_pasien = kunjungan.kd_pasien
            INNER JOIN kamar ON kamar.kd_unit = nginap.kd_unit_kamar AND nginap.no_kamar = kamar.no_kamar
            where nginap.tgl_masuk = '$now' and kd_bagian = 1 and akhir = 't'")->result();

        //simplexml_load_string($this->response($data));
        $this->output
    		 ->set_content_type('application/json')
    		 ->set_output(json_encode(array('data' => $data)));	
    }

    public function world_get() {
    $data = array();
    $data['name'] = "TESTNAME";
    $this->simplexml_load_string($data); 
  }



  public function login_post()
  {
  	$username = $this->input->post('username');
  	$password = $this->input->post('password');
  	$hashed_password = md5($password);
  	$json_array = $this->loginUsers($username, $hashed_password);
	echo json_encode($json_array);
  }


	function isLoginExist($username, $password){
	$query = $this->db->query("select * from zusers where user_names = '$username' AND password = '$password'");
	if($query->num_rows() > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
	
	}

	
	function loginUsers($username, $password){

	$json = array();

	$canUserLogin = $this->isLoginExist($username, $password);

	if($canUserLogin){

	$json['success'] = 1;

	}else{
	$json['success'] = 0;
	}
	return $json;
	}

	// public function tindakan_get()
	// { 
	// 		//$now = date('Y-m-d');
	// 	$term = $this->input->get('term');

 //       	$data = $this->db->query("SELECT kd_icd9,deskripsi
 //            FROM icd_9 where kd_icd9 ilike '%$term%' OR deskripsi ilike '%$term%'")->result();

 //        //simplexml_load_string($this->response($data));
 //        $this->output
 //    		 ->set_content_type('application/json')
 //    		 ->set_output(json_encode(array('data' => $data)));		
	// }

	public function obat_get()
	{ 
			//$now = date('Y-m-d');
		$term = $this->input->get('term');

       	$data = $this->db->query("select nama_obat,kd_satuan from apt_obat where nama_obat ilike '%$term%'")->result();

        //simplexml_load_string($this->response($data));
        $this->output
    		 ->set_content_type('application/json')
    		 ->set_output(json_encode(array('data' => $data)));		
	}

	public function tindakan_get()
	{ 
			//$now = date('Y-m-d');
		$term = $this->input->get('term');

       	$data = $this->db->query("select deskripsi,kd_produk from produk where deskripsi ilike '%$term%'")->result();

        //simplexml_load_string($this->response($data));
        $this->output
    		 ->set_content_type('application/json')
    		 ->set_output(json_encode(array('data' => $data)));		
	}

}
