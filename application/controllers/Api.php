<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    private $_access_token;
    private $_sitekey = '66RXwbUrtDgnQOP5yLYAA9gtKsfHy01B';

    function __construct() {
        parent::__construct();
        $this->load->library(['campapi', 'crypt']);
        $this->load->model('mmain');
        
        $this->_access_token = (isset($_SESSION['access_token'])) ? $_SESSION['access_token'] : '';
        
        // Enable CORS
        $this->enableCORS();
        
        // Set JSON response header
        $this->output->set_content_type('application/json');
    }

    private function enableCORS() {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            exit(0);
        }
    }

    private function checkApiAuth() {
        $check = $this->campapi->checkCAMPSession($this->_access_token, $this->_sitekey);

        if(!$check || empty($this->session->userdata('access_token'))) {
            $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ]));
            return false;
        }
        return true;
    }

    public function stats() {
        if (!$this->checkApiAuth()) return;

        $open = $this->mmain->count_ticket(1);
        $onhold = $this->mmain->count_ticket(2); 
        $cancelled = $this->mmain->count_ticket(3);
        $resolved = $this->mmain->count_ticket(4);

        $response = [
            'success' => true,
            'data' => [
                'open' => (int)$open,
                'onhold' => (int)$onhold,
                'cancelled' => (int)$cancelled,
                'resolved' => (int)$resolved
            ]
        ];

        $this->output->set_output(json_encode($response));
    }

    public function tickets() {
        if (!$this->checkApiAuth()) return;

        $status = $this->input->get('status') ?: 0;
        $search = $this->input->get('search') ?: '';
        $page = $this->input->get('page') ?: '';
        $limit = $this->input->get('limit') ?: 10;
        $offset = $this->input->get('offset') ?: 0;

        // Get total count
        $totalCount = $this->mmain->get_issues_data($status, $search, TRUE, $page);
        $total = isset($totalCount[0]['total']) ? (int)$totalCount[0]['total'] : 0;

        // Get tickets
        $issues = $this->mmain->get_issues_data($status, $search, FALSE, $page, 'date_added', 'DESC', $limit, $offset);
        
        $tickets = [];
        if(!empty($issues)) {
            foreach($issues as $row) {
                $ticket = 'MSWCS-' . sprintf('%05d', $row['CS_ID']);
                
                switch($row['status']){
                    case 1:
                        $cs_status = 'Waiting for support';
                        break;
                    case 2:
                        $cs_status = 'On Hold';
                        break;
                    case 3:
                        $cs_status = 'Cancelled';
                        break;
                    case 4:
                        $cs_status = 'Resolved';
                        break;
                    default:
                        $cs_status = 'Pending';
                }
                
                $customerName = trim($row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']);
                $customerName = preg_replace('/\s+/', ' ', $customerName); // Clean up multiple spaces
                
                $tickets[] = [
                    'id' => $row['CS_ID'],
                    'ticketNo' => $ticket,
                    'username' => $row['username'],
                    'customerName' => $customerName,
                    'customerEmail' => $row['email'],
                    'category' => $row['category'],
                    'assignedTo' => 'MSW CS',
                    'status' => $cs_status,
                    'dateReported' => $row['date_added'],
                    'lastUpdate' => isset($row['last_update']) ? $row['last_update'] : $row['date_added'],
                ];
            }
        }

        $response = [
            'success' => true,
            'data' => [
                'tickets' => $tickets,
                'total' => $total,
                'limit' => (int)$limit,
                'offset' => (int)$offset
            ]
        ];

        $this->output->set_output(json_encode($response));
    }

    public function user() {
        if (!$this->checkApiAuth()) return;

        $userData = [
            'uname' => $this->session->userdata('uname'),
            'name' => $this->session->userdata('name'),
            'email' => $this->session->userdata('email'),
            'department' => $this->session->userdata('department'),
            'role' => $this->session->userdata('role'),
            'img' => $this->session->userdata('img')
        ];

        $response = [
            'success' => true,
            'data' => $userData
        ];

        $this->output->set_output(json_encode($response));
    }
}

?>