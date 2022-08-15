<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatatanModel extends CI_Model {

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('catatanataslapkeu');
        $query = $this->db->get();
        return $query->result_array();
    }
}