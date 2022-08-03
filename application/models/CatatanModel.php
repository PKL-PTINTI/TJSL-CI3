<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatatanModel extends CI_Model {

    public function getCatatan()
    {
        $this->db->select('*');
        $this->db->from('neraca');
        $query = $this->db->get();
        return $query->result();
    }
}