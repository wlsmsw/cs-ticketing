<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {
    
    function __construct() {
		parent::__construct();
		$this->load->library(['campapi', 'crypt']);
		$this->load->model('mticket');

		$this->_access_token = (isset($_SESSION['access_token'])) ? $_SESSION['access_token'] : '';
	}
    
    
    public function submitWebformTicket(){
        
        $status = FALSE;
		$response = "Something went wrong upon submission of your ticket. Please try again.";
		
		//check form data
		if(isset($_POST)){
		    $data['uname']          =   $_POST['uname'];
		    $data['lname']          =   $_POST['lname'];
		    $data['mname']          =   $_POST['mname'];
		    $data['fname']          =   $_POST['fname'];
		    $data['category']       =   $_POST['category'];
		    $data['channel']        =   $_POST['channel'];
		    $data['email']          =   $_POST['email'];
		    $data['description']    =   $_POST['description'];
		    $data['date_submitted'] =   date('Y-m-d H:i:s');
		}else{
		    echo json_encode(array(
				'status' => FALSE,
				'response' => "Error in retrieving form data. Please try again."
			));
			exit;
		}
		
		//check files
		$uploadedID = '';
		$sourcePath = '';
		$imgPath = '';
		$imgLink = '';
		$attachments = array();
		$dbattachment = array();
		
		$allowed_types = array('image/jpeg','image/jpg','image/png','application/pdf','text/csv','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword');
		
		if(isset($_FILES['upload_file']) && !empty($_FILES['upload_file'])) {
			
			$type = $_FILES['upload_file']['type'];

			if($_FILES['upload_file']['size'] > 10100000) {
				echo json_encode(array(
					'status' => FALSE,
					'response' => "Uploaded file size should be 10MB or less."
				));
				exit;
			}

            if(in_array($type,$allowed_types)){
                
                $ext = explode('/', $type);
    			$extension = (isset($ext[1])) ? $ext[1] : 'jpg';
    			$uploadedFile = $data['lname'] . "_" . $data['fname'] . "_" . $data['mname'] . "_" . date('ymd') . "." . $extension;
    			$sourcePath = $_FILES['upload_file']['tmp_name'];
    			$imgPath = FCPATH;
    			$imgLink = 'assets/img/uploads/' . $uploadedFile;
    			
    			
    			
    			$attachments[] = array(
    			    'content' => base64_encode(file_get_contents($sourcePath)),
    			    'name' => $uploadedFile
    			);
    			
    			array_push($dbattachment,$uploadedFile);
    			
    			move_uploaded_file($sourcePath, $imgLink);
            
                
            }else{
                echo json_encode(array(
					'status' => FALSE,
					'response' => "The file selected cannot be uploaded in the system."
				));
				exit;
            }
			

		}
		
		$data['attachments'] = json_encode($dbattachment);
		
		$save = $this->mticket->saveWebformTicket($data);
		
		if($save){
		    $status = TRUE;
		    $response = 'Ticket sent. Our team will reach out to you shortly. Thank you.';
		    
		    //send email
			$subject = "[CS Ticketing] (MSWCS-" . sprintf('%05d', $save) . ") - " . $data['uname'];
			$content = $this->load->view('layouts/email-confirmation', $data, TRUE);
			
			//set receivers (static for now)
			if($_SERVER['SERVER_NAME'] == 'localhost') {
				// Skip email on localhost - log to custom file
				$logMessage = date('Y-m-d H:i:s') . " - Email would be sent to: " . $data['email'] . " for ticket: MSWCS-" . sprintf('%05d', $save) . " (Subject: " . $subject . ")\n";
				file_put_contents(FCPATH . 'ticket_logs.txt', $logMessage, FILE_APPEND | LOCK_EX);
			} elseif($_SERVER['SERVER_NAME'] == 'mswlive.com' || $_SERVER['SERVER_NAME'] == 'affiliate.mswlive.com') {
					$recipient = array(
						array(
							'name' => $data['fname'].' '.$data['lname'],
							'email' => $data['email']
						),
						array(
							'name' => 'Sherwin Macalintal',
							'email' => 'sherwinnino.macalintal@megasportsworld.com'
						),
						array(
							'name' => 'MSW ITPD',
							'email' => 'itprojectsdevelopment@megasportsworld.com'
						)
					);
				} else {
					$recipient = array(
						array(
							'name' => $data['fname'].' '.$data['lname'],
							'email' => $data['email']
						),
						array(
							'name' => 'Sherwin Macalintal',
							'email' => 'sherwinnino.macalintal@megasportsworld.com'
						),
						array(
							'name' => 'MSW ITPD',
							'email' => 'itprojectsdevelopment@megasportsworld.com'
						)
					);
				}
				
				if($_SERVER['SERVER_NAME'] != 'localhost') {
					$send = $this->sendTransactionMail($recipient, $subject, $content, [], []);
				}
		}
		
		echo json_encode(array(
			'status' => $status,
			'response' => $response
		));

		session_write_close();
		
    }
    
    
	/**
	 * send transactional email
	 *
	 * @param 
	 */
	public function sendTransactionMail($recipient, $subject, $content, $cc = array(), $attachment = array()) {
		$sendinblue = TRUE;
		if($sendinblue) :
			$this->load->library('sendinblue');
			return $this->sendinblue->sendMail($recipient, $subject, $content, $cc, $attachment);
		else :
		    $config = Array(
                'mailtype' => 'html',
                'charset' => 'utf-8'
            );
		    $this->load->library('email', $config);
			$senderemail = 'no-reply@mswlive.com';
			$sendername = (isset($sender[1])) ? $sender[1] : '';
			$this->email->from($senderemail, $sendername);
			$this->email->reply_to($senderemail);

			$recipientemail = (key($recipient)) ? key($recipient) : '';
			$this->email->to($recipientemail);

			if(!empty($cc)) $this->email->cc($cc);

			$this->email->subject($subject);
			$this->email->message($content);

			$attach = (isset($attachment[0])) ? $attachment[0] : '';
			if(!empty($attach)) $this->email->attach($attach);

			if($_SERVER['SERVER_NAME'] != 'localhost') return $this->email->send();
		endif;
	}
    
}

?>