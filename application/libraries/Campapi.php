<?php

/**
 * MSW User API Call
 *
 * Copyright (c) 2018, Megasportsworld
 *
 * This class is intended for MSW User API call only.
 * THE SOFTWARE IS PROVIDED "AS IS". Updates in code must contain comments for future
 * reference along with the author of the update.
 *
 * @author Resty Alejo
 * @version 2.0.0
 */

class CAMPAPI {

	/**
	 * Get response from API
	 *
	 * @param mixed $data
	 *
	 * @return mixed API Response 	json encode response
	 */
	public static function curl($link, $token = null, $data = null, $method = "GET") 
	{
		if($_SERVER['SERVER_NAME'] == 'mswlive.com') {

			$_url = 'https://api.mswlive.com/aim/';

		} elseif($_SERVER['SERVER_NAME'] == 'mswsites.com') {

			$_url = 'https://api.mswsites.com/aim/';

		} else {
			
			$_url = 'http://localhost:8080/';

		}

		$_url .= $link;

		$curl = curl_init();

		switch($method) {
			case "POST":
				$data = json_encode($data);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				break;
			default:
				if(!empty($data)) $_url = sprintf("%s?%s", $_url, http_build_query($data));
		}

		if($method == "PUT") {
			$header = array(
				'Content-Type: application/x-www-form-urlencoded'
			);
		} else {
			$header = array(
				'Content-Type: application/json'
			);
		}

		if(!empty($token)) $header[] = 'X-Aim-Token: ' . $token;

		curl_setopt($curl, CURLOPT_URL, $_url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERAGENT, 'mswapi');

		$result = curl_exec($curl);
		if(!$result) { die("Connection failed."); }
		curl_close($curl);

		return $result;
	}


	/**
	 * Get user info from API
	 *
	 * @param string 			access token from CAMP
	 *
	 * @param string 			site key of the app from AIM
	 *
	 * @return array 			uname
	 *							lname
	 *							fname
	 *							mname
	 *							email
	 *							contact_number
	 *							birthdate
	 *							civil_status
	 *							gender
	 *							nationality
	 *							employee_id
	 *							gel_id
	 *							image
	 *							address
	 *							employee_status
	 *							department_slug
	 *							department
	 *							position
	 *							level
	 *							island_group 			(optional)
	 *							city 					(optional)
	 *							operator_code 			(optional)
	 *							operator_description 	(optional)
	 *							operator_company 		(optional)
	 *							outlet_code 			(optional)
	 *							outlet_name 			(optional)
	 *							approving_officer
	 *							approving_officer_id
	 *							role
	 *							role_slug
	 */
	public static function getCAMPInfo($accessToken, $sitekey) 
	{
		$data = array(
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('getuserdetails', $accessToken, $data, "POST"), TRUE);

		return $curl;
	}


	/**
	 * Check CAMP session if ended
	 *
	 * @param string 			generated access token from CAMP
	 *
	 * @return boolean
	 */
	public static function checkCAMPSession($accessToken, $sitekey = NULL) 
	{
		$data = array(
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('checkcampsession', $accessToken, $data, "POST"), TRUE);

		$status = ($curl['status'] == 'inactive') ? FALSE : TRUE;

		return $status;
	}


	/**
	 * Check access token if expired
	 *
	 * @param string 			generated access token from CAMP
	 *
	 * @return array
	 */
	public static function checkAccessToken($accessToken) 
	{
		$curl = json_decode(self::curl('checkaccesstoken', $accessToken), TRUE);

		return $curl;
	}


	/**
	 * log action into AIM database
	 *
	 * @param string 			generated access token from CAMP
	 *
	 * @param string 			type of action e.g. (login, logout)
	 *
	 * @param string 			action done by the user
	 *
	 * @param string 			ip address of the user
	 *
	 * @return array
	 */
	public static function logAction($accessToken, $type, $action, $ip, $sitekey) 
	{
		$data = array(
			'type' => $type,
			'action' => $action,
			'ip' => $ip,
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('logaction', $accessToken, $data, "PUT"), TRUE);

		return $curl;
	}


	/**
	 * get current logged in users
	 *
	 * @param string 		generated access token from CAMP
	 *
	 * @param string 		site key of the app
	 *
	 * @return array
	 */
	public function getLoggedinUsers($accessToken, $sitekey) 
	{
		$data = array(
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('getloggedinusers', $accessToken, $data, "POST"), TRUE);

		return $curl;
	}


	/**
	 * get table list data
	 * 
	 * @param string 		generated access token from CAMP
	 *
	 * @param string 		table api id
	 *						t101 - city
	 *						t102 - departments
	 *						t103 - employee status
	 *						t104 - island group
	 *						t105 - level
	 *						t106 - operators
	 *						t107 - outlets
	 *						t108 - position title
	 *
	 * @return array
	 */
	public function getTableData($accessToken, $table) 
	{
		$data = array(
			'dt' => $table
		);

		$curl = json_decode(self::curl('gettabledata', $accessToken, $data), TRUE);

		return $curl;
	}


	/**
	 * get site app roles
	 * 
	 * @param string 		generated access token from CAMP
	 *
	 * @param string 		site key of the app
	 *
	 * @return array
	 */
	public function getSiteRoles($accessToken, $sitekey) 
	{
		$data = array(
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('getsiteroles', $accessToken, $data, "POST"), TRUE);

		return $curl;
	}


	/**
	 * get user list per department
	 * 
	 * @param string 		generated access token from CAMP
	 * 
	 * @param string 		department name slugs 
	 *						(e.g. it-projects, it-support)
	 *
	 * @return array 
	 */
	public function getUserList($accessToken, $dept) 
	{
		$data = array(
			'd' => $dept
		);

		$curl = json_decode(self::curl('getuserlistsperdepartment', $accessToken, $data), TRUE);

		return $curl;
	}


	/**
	 * get position list per department
	 * 
	 * @param string 		generated access token from CAMP
	 * 
	 * @param string 		department name slugs 
	 *						(e.g. it-projects, it-support)
	 *
	 * @return array 
	 */
	public function getPositionList($accessToken, $dept) 
	{
		$data = array(
			'd' => $dept
		);

		$curl = json_decode(self::curl('getpositionlistsperdepartment', $accessToken, $data), TRUE);

		return $curl;
	}


	/**
	 * get details of approving officer
	 *
	 * @param string 		generated access token from CAMP
	 *
	 * @return array
	 */
	public function getApprovingOfficerInfo($accessToken, $sitekey = NULL, $empid = NULL) 
	{
		$data = array(
			'empid' => $empid,
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('getapprovingofficerinfo', $accessToken, $data, "POST"), TRUE);

		return $curl;
	}


	/**
	 * get supervisor outlets
	 *
	 * @param string 		generated access token from CAMP
	 *
	 * @return array
	 */
	public function getSupervisorOutlets($accessToken) 
	{

		$curl = json_decode(self::curl('getsupervisoroutlets', $accessToken), TRUE);

		return $curl;
	}
	
	

	/**
	 * get access token from pass user details
	 *
	 * @param string 		username from input
	 * @param string 		password from input
	 * @param string 		target site key connection
	 * @param string 		ip address for logging
	 *
	 * @return array
	 */
	public function getAccessToken($uname, $pword, $sitekey, $ip) 
	{
		$data = array(
			'uname' => $uname,
			'pword' => $pword,
			'sitekey' => $sitekey,
			'ip' => $ip
		);

		$curl = json_decode(self::curl('getaccesstoken', NULL, $data, "POST"), TRUE);

		return $curl;
	}



	/**
	 * get user details
	 *
	 * @param string 		generated access token from CAMP
	 * @param string 		target site key connection
	 *
	 * @return array
	 */
    public function getUserInfo($accessToken, $sitekey) 
    {
		$data = array(
			'sitekey' => $sitekey
		);

		$curl = json_decode(self::curl('getuserdetails', $accessToken, $data, "GET"), TRUE);

		return $curl;
	}



	/**
	 * get manager details
	 *
	 * @param string 		generated access token from CAMP
	 * @param string 		department name slugs 
	 *						(e.g. it-projects, it-support)
	 *
	 * @return array
	 */
	public function getManagerInfo($accessToken, $dept)
	{
		$data = array(
			'd' => $dept
		);

		$curl = json_decode(self::curl('getmanagerinfo', $accessToken, $data, "GET"), TRUE);

		return $curl;
	}



	/**
	 * get site user per role
	 *
	 * @param string 		generated access token from CAMP
	 * @param string 		target site key connection
	 * @param string		target site role
	 *
	 * @return array
	 */
	public function getSiteUsersPerRole($accessToken, $sitekey, $role)
	{
		$data = array(
			'sitekey' => $sitekey,
			'role' => $role
		);

		$curl = json_decode(self::curl('getsiteuserperrole', $accessToken, $data, "POST"), TRUE);

		return $curl;		
	}

}