<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RKAModel extends CI_Model {
    
    public function getData() {
        $this->db->select('*');
        $this->db->from('neraca');
        $query = $this->db->get();
        return $query->result_array();
    }
            
}


