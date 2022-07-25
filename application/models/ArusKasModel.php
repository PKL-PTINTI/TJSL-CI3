<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ArusKasModel extends CI_Model {

    public function getArusKas()
    {
        $this->db->select('*');
        $this->db->from('transposeagingrate');
        $query = $this->db->get();
        return $query->result();
    }

	public function storeArus($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
}
