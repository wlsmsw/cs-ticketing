<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	private $_access_token;

	private $_sitekey = '66RXwbUrtDgnQOP5yLYAA9gtKsfHy01B';


	function __construct() {
		parent::__construct();
		$this->load->library(['campapi', 'crypt']);
		//$this->load->model('madmin');
		//$this->load->model('mmain');

		$this->_access_token = (isset($_SESSION['access_token'])) ? $_SESSION['access_token'] : '';
	}


	public function access() {
	    
		if(isset($_GET['auth'])) {
			$auth = htmlspecialchars(strip_tags($_GET['auth']), ENT_QUOTES, 'UTF-8');
			$camp = $this->campapi->getCAMPInfo($auth, $this->_sitekey);

			if(isset($camp['status']) && $camp['status'] != 200) {
				$data['message'] = $camp['msg'];

				$this->load->view('camp/page-error', $data);
			} else {

				$this->load->view('camp/page-loading');

				$session = array(
					'access_token' => $auth,
					'uname' => $camp['uname'],
					'email' => $camp['email'],
					'dept_slug' => $camp['department_slug'],
					'department' => $camp['department'],
					'role' => $camp['role_slug'],
					'name' => $camp['fname'] . ' ' . $camp['lname'],
					'img' => $camp['image']
				);

				$this->session->set_userdata($session);
				redirect(base_url('issues'));
			}
		} else {
			$data['message'] = "CAMP access token not found.";
			$this->load->view('camp/page-error', $data);
		}
	}


	private function checkIfLoggedIn() {
		$check = $this->campapi->checkCAMPSession($this->_access_token, $this->_sitekey);

		if(!$check || empty($this->session->userdata('access_token'))) {
			$this->session->unset_userdata(array('access_token', 'uname', 'email', 'dept_slug', 'department', 'role', 'name', 'img'));
			$this->session->sess_destroy();
			redirect(base_url('error'));
		}
	}


	public function error($msg = NULL) {
		$data['message'] = (!empty($msg)) ? $msg : "Looks like your session has ended.";

		$this->load->view('camp/page-error', $data);
	}
	
	public function issues() {
	    
	    $this->checkIfLoggedIn();

		$data['page'] = 'Issues';

		$this->load->view('issues');

	}
	
}
	
	
?>