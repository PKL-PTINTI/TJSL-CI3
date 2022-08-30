<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NeracaSaldoModel extends CI_Model {

    public function getNeracaSaldo()
    {
        $this->db->select('*');
        $this->db->from('neracasaldo');
        $query = $this->db->get();
        return $query->result_array();
    }
}