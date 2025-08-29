<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MTicket extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->library('conn');
	}
	
	public function saveWebformTicket($data){
	    
	    $query = "INSERT INTO `cs_ticket`(`username`, `lastname`, `firstname`, `middlename`, `category`, `channel`, `email`, `attachment`, `description`, `date_added`) VALUES (:uname,:lname,:fname,:mname,:category,:channel,:email,:attachment,:description,:date_added)";
	    
	    $param = array(
			':uname'        =>      $data['uname'],
			':lname'        =>      $data['lname'],
			':fname'        =>      $data['fname'],
			':mname'        =>      $data['mname'],
			':category'     =>      $data['category'],
			':channel'      =>      $data['channel'],
			':email'        =>      $data['email'],
			':attachment'   =>      $data['attachments'],
			':description'  =>      $data['description'],
			':date_added'   =>      $data['date_submitted']
			
		);
		
		$result = $this->conn->query($query, $param);

		return $result;
	    
	}
	
}
	
	
?>