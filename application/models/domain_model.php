<?php
    class domain_model extends CI_Model{
        public function __construct()
        {
            $this->load->database();
            $this->load->library('simple_html_dom');
        }
    }
?>