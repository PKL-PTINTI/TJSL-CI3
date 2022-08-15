<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ArusKasModel extends CI_Model {

    public function getArusKas()
    {
        $this->db->select('*');
        $this->db->from('aktivitasoperasikasditerima');
        $query = $this->db->get();
        return $query->result_array();
    }
	
}
