<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoaModel extends CI_Model {
    public function getCoa()
    {
        $this->db->select('*');
        $this->db->from('akun');
        $query = $this->db->get();
        return $query->result();
    }
}

