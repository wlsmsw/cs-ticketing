<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mmain extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->library('conn');
	}
	
	public function count_ticket($status){
	    
	    $query = "SELECT COUNT(CS_ID) as cnttix FROM cs_ticket WHERE status = :status";
		$param = [':status' => $status];

		$result = $this->conn->query($query, $param);
		return ($result) ? $result[0]['cnttix'] : '';
    }
    
    public function get_issues_data($status, $search = null, $count = FALSE, $page = '', $columnName = NULL, $columnSortOrder = NULL, $limit = NULL, $rowperpage = NULL) {
        
        if($status == 0){
            if($page == ''){
                $ticstat = '(1,2)';
            }else{
                $ticstat = '(3,4)';
            }
        }else{
            $ticstat = '('.$status.')';
        }
        
        

        if($count) {
			$query = "SELECT COUNT(*) as total FROM cs_ticket WHERE CS_ID > :id AND status IN ".$ticstat;
		} else {
			$query = "SELECT * FROM cs_ticket WHERE CS_ID > :id AND status IN ".$ticstat;
		}

		$param[':id'] = 0;

		/*if(!empty($search)) {
			$query .= " AND (amgt_ticket LIKE :search OR outlet_name LIKE :search)";
			$param[':search'] = '%' .$search . '%';
		}*/


		// for fetching records
		if(!$count) {
			$query .= " ORDER BY FIELD(status, 1,2,4,3), date_added DESC";
            
			if($rowperpage != NULL && $limit != NULL) {
				$query .= ($limit != -1) ? " LIMIT {$rowperpage}, {$limit}" : "";
			}
		}

		$result = $this->conn->query($query, $param);
		return $result;

    }
	
}
	
	
?>