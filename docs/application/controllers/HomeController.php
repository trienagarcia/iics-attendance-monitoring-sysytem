<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

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

	public function __construct() {
		parent::__construct();

		$this->checkSession();
	}

	function checkSession() {

		// echo $this->uri->segment(1) . "<br>";

		if($this->uri->segment(1)!='login'){
				if ($this->session->userdata('person_id')=='') {
					header('Location: '.base_url("login"));
				}
		} else {
			if($this->session->userdata('person_id')!=''){
				header('Location: '.base_url("home"));
			}
		}
	}

	public function index()
	{
		$this->load->view('pages/index');

	}

	public function login()
	{
		$this->load->view('pages/index');

	}

	public function home()
	{
		$data['view'] =  "home";
		$data['head'] = array(
			"title"         =>  "Home | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function roomSchedule()
	{
		$data['view'] =  "room-schedule";
		$data['head'] = array(
			"title"         =>  "Room Attendance | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function submittedRequests()
	{
		$data['view'] =  "submitted-requests";
		$data['head'] = array(
			"title"         =>  "My Requests | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function addRequests()
	{
		$data['view'] =  "add-request";
		$data['head'] = array(
			"title"         =>  "Add Make Up Requests | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function timeLogs()
	{
		$data['view'] =  "time-logs";
		$data['head'] = array(
			"title"         =>  "Time Logs | Attendance Monitoring System",
			);
		$data['faculty'] = json_decode(json_encode($this->Custom_model->get_all_users()), true);
		$this->load->view('layouts/template', $data);
	}

	public function timeLogsUser()
	{
		$data['view'] =  "time-logs-user";
		$data['head'] = array(
			"title"         =>  "My Time Logs | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function changePassword()
	{
		$data['view'] =  'change-password';
		$data['head'] = array(
			"title"         =>  "Change Password | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function accountManagement()
	{
		$data['view'] =  'account-management';
		$data['head'] = array(
			"title"         =>  "Account Management | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function logout() {
		$this->session->sess_destroy();
		header('Location: '.base_url());
	}


}
