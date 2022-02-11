<?php
    class parser_model extends CI_Model{
        public function __construct()
        {
            $this->load->database();
            $this->load->library('simple_html_dom');
        }
        public function get_record_if_exist($data, $table_name, $primary_key)
        {
            $this->db
                ->from($table_name)
                ->where($primary_key, $data[$primary_key])
                ->select('*');
            $query=$this->db->get();
            return $query->row_array();
        }
        public function check_if_data_is_diffrent($database_record, $page_record)
        {
            foreach($database_record as $key => $val) {
                if(isset($page_record[$key]) && $page_record[$key] != $val) {
                    return true;
                }
            }
            return false;
        }
        public function get_data_from_page($response, $table_name, $allowed_columns)
        {
            $html = new simple_html_dom();
            $html->load($response);
            $table=$html->getElementByTagName('table');

            $data = array();
            $th_array=array();
            $tr_array=array();

            if($table!=null){
                foreach($table->find('th') as $th){
                    array_push($th_array,$th->id);
                }
                foreach($table->find('tr') as $tr){
                    $loop=0;
                    foreach($tr->find('td') as $td){
                        if(in_array($th_array[$loop], $allowed_columns)){
                            if($td->find('span.tag-no')){
                                $tr_array[$th_array[$loop]]=0;
                            }
                            else if($td->find('span.tag-yes')){
                                $tr_array[$th_array[$loop]]=1;
                            }
                            else{
                                $tr_array[$th_array[$loop]]=$td->plaintext;
                            }
                        }
                        $loop++;
                    }
                    array_push($data, $tr_array);
                }
                foreach($data as $record){
                    if($record!=null){
                        $existing_record=$this->parser_model->get_record_if_exist($record, $table_name, $allowed_columns[0]);
                        if($existing_record==null){
                            $this->db->insert($table_name, $record);
                        }
                        else if($this->parser_model->check_if_data_is_diffrent($existing_record, $record)==true){
                            $this->db->where($allowed_columns[0], $record[$allowed_columns[0]])->update($table_name, $record);
                        }
                    }
                }
                return 1;
            }
            else
                return 0;
        }
    }
?>