<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parser extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('parser_model');
		$this->load->model('curl_functions');
		$this->load->helper(array('url','form'));
	}
	public function index()
	{
		if(isset($_GET['table_name'])){
			$page_number=0;
			$allowed_columns=array();
			$loop=0;
			while(true){
				if(isset($_GET[$loop])){
					array_push($allowed_columns, $_GET[$loop]);
				}
				else{
					break;
				}
				$loop++;
			}
			while(true){
				$url_with_pagination=$_GET['url'].$page_number;
				$response=$this->parser_model->get_data_from_page($this->curl_functions->curl_get_html($url_with_pagination), $_GET['table_name'], $allowed_columns);
				if($response==0) break;
				$page_number++;
			}
		}
		$this->load->view('parser');
	}
}
