<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AktivitasModel extends CI_Model {

    public function getAktivitas()
    {
        $this->db->select('*');
        $this->db->from('perubahanasetnetotidakterikat');
        $query = $this->db->get();
        return $query->result_array();
    }
	
}