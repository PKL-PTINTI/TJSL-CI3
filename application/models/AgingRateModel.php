<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgingRateModel extends CI_Model {

    public function getAgingRate()
    {
        $this->db->select('*');
        $this->db->from('transposeagingrate');
        $query = $this->db->get();
        return $query->result();
    }
	
}
