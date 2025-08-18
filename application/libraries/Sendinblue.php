<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/sendinblue/vendor/autoload.php');

class Sendinblue {

	private $_apiInstance;
	private $_sendSmtpEmail;

	function __construct() {
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

		$this->_apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
		    new GuzzleHttp\Client(),
		    $config
		);
		$this->_sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
	}

	/**
	 * Send mail using sendinblue api
	 * @param array recipient 			nested array [[email=>, name=>]]
	 * @param string subject
	 * @param string content 			email content can be both text and html format
	 * @param array sender 				array [[name=>, email=>]]
	 *									and 2nd value is the name of the sender
	 * @param array cc 					nested array [[email=>, name=>]]
	 * @param array bcc 				nested array [[email=>, name=>]]
	 * @param array attachment 			nested array [[url=>, name=>],[content=>base64, name=>]]
	 * @return
	 */
	public function sendMail($recipient, $subject, $content, $cc = array(), $attachment = array(), $sender = array('name' => 'MSW Affiliate System', 'email' => 'no-reply@mail.mswlive.com'), $bcc = array()) {

		if($_SERVER['SERVER_NAME'] == 'mswlive.com' || $_SERVER['SERVER_NAME'] == 'affiliate.mswlive.com') {
			$mailTag = "Affiliate";
		} else {
			$mailTag = "Affiliate - STG";
		}

		if($_SERVER['SERVER_NAME'] == 'mswsites.com')
			$sender = array('name' => 'MSW Affiliate System', 'email' => 'no-reply@mswsites.com');

		$sendSmtpEmail['subject'] = $subject;
		$sendSmtpEmail['htmlContent'] = $content;
		$sendSmtpEmail['sender'] = $sender;
		$sendSmtpEmail['to'] = $recipient;
		
		if(!empty($cc)) $sendSmtpEmail['cc'] = $cc;

		if(!empty($bcc)) $sendSmtpEmail['bcc'] = $bcc;

		if(!empty($attachment)) $sendSmtpEmail['attachment'] = $attachment;
		
		$sendSmtpEmail['headers'] = array(
			'sender.ip' => '77.32.157.163'
		);
		$sendSmtpEmail['tags'] = [$mailTag];
		
		//if(!empty($reference)) $sendSmtpEmail['headers']['In-Reply-To'] = $reference;

		//$sendSmtpEmail['params'] = array('parameter' => 'My param value', 'subject' => 'New Subject');

		try {
		    if($_SERVER['SERVER_NAME'] != 'localhost') return $result = $this->_apiInstance->sendTransacEmail($sendSmtpEmail);
		    return TRUE;
		} catch (Exception $e) {
			return FALSE;
		    //echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
		}
	}

}