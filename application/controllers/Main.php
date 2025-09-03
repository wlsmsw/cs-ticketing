<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	private $_access_token;

	private $_sitekey = '66RXwbUrtDgnQOP5yLYAA9gtKsfHy01B';


	function __construct() {
		parent::__construct();
		$this->load->library(['campapi', 'crypt']);
		//$this->load->model('madmin');
		$this->load->model('mmain');

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
				
				// Direct redirect to React frontend (skip issues route)
				if($_SERVER['SERVER_NAME'] == 'localhost') {
					redirect('http://localhost:3002/dashboard');
				} elseif($_SERVER['SERVER_NAME'] == 'mswsites.com') {
					redirect('https://mswsites.com/cs-ticketing/dashboard');
				} else {
					// Production - flexible for any domain
					redirect('https://' . $_SERVER['SERVER_NAME'] . '/cs-ticketing/dashboard');
				}
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


	/* webform functions */

	public function displayWebForm(){

		$this->load->view('webform');

	}


	
	public function issues() {
	    
	    $this->checkIfLoggedIn();

		// Environment-based redirect to React frontend dashboard
		if($_SERVER['SERVER_NAME'] == 'localhost') {
			redirect('http://localhost:3002/dashboard');
		} elseif($_SERVER['SERVER_NAME'] == 'mswsites.com') {
			redirect('https://mswsites.com/cs-ticketing/dashboard');
		} else {
			// Production - to be determined based on actual server structure
			redirect('https://' . $_SERVER['SERVER_NAME'] . '/cs-ticketing/dashboard');
		}

	}
	
	public function get_issues_DT() {
	    
	    $draw = (isset($_POST['draw'])) ? $_POST['draw'] : 0;
		$limit = (isset($_POST['start'])) ? $_POST['start'] : 0;
		$rowperpage = (isset($_POST['length'])) ? $_POST['length'] : 0;
		$columnIndex = (isset($_POST['order'][0]['column'])) ? $_POST['order'][0]['column'] : 0;
		$columnName = (isset($_POST['columns'][$columnIndex]['data'])) ? $_POST['columns'][$columnIndex]['data'] : "";
		$columnSortOrder = (isset($_POST['order'][0]['dir'])) ? $_POST['order'][0]['dir'] : "DESC";
		$searchValue = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : "";	
		
		$status = (isset($_POST['status_filter'])) ? $_POST['status_filter'] : 0;

		// data
		$page = '';
		if($this->uri->segment(3) == "reports"){
		    $page = 'r';
		}
		$data = array();
		$totalRecords = $this->mmain->get_issues_data($status, $searchValue, TRUE, $page);
		$issues = $this->mmain->get_issues_data($status, $searchValue, FALSE, $page, $columnName, $columnSortOrder, $rowperpage, $limit);
		
	    $cnt = 0;
		if(!empty($issues)) {
		    foreach($issues as $row) {
               
                $ticket = 'MSWCS-' . sprintf('%05d', $row['CS_ID']);
                
                switch($status){
                    case 1:
                        $cs_status = 'Waiting for support';
                        break;
                    default:
                        $cs_status = 'Pending';
                }
                
    	        
    	        $data[] = array(
    	            'ticket' => $ticket,
    	            'category' => $row['category'],
    	            'username' => $row['username'],
    	            'lastname' => $row['lastname'],
    	            'firstname' => $row['firstname'],
    	            'middlename' => $row['middlename'],
    	            'channel' => $row['channel'],
    	            'email' => $row['email'],
    	            'assignedto' => 'MSW CS',
    	            'status'=> $cs_status,
    	            'datereported' => date('M j, Y h:i:s A', strtotime($row['date_added'])),
    	        );

		    }
		}
       
		session_write_close();

		echo json_encode(array(
			'draw' => intval($draw),
			'iTotalRecords' => $totalRecords[0]['total'],
			'iTotalDisplayRecords' => $totalRecords[0]['total'],
			'aaData' => $data
		));
	}
	
}
	
	
?>