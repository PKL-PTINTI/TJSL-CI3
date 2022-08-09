<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KinerjaModel extends CI_Model {

    public function getData() {
        $this->db->select('*');
        $this->db->from('tingkatpengembalianhasil');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDanaYangDisalurkan(){
        $this->db->select('*');
        $this->db->from('danayangdisalurkan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDanaTersedia(){
        $this->db->select('*');
        $this->db->from('danatersedia');
        $query = $this->db->get();
        return $query->result_array();
    }
}

