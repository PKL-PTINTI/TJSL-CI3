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

	public function storeAging($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function getTransposeAgingRate(){
		$this->db->select('*');
		$this->db->from('transposeagingrate');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->result();
	}

	public function getMitraKontrak($no_kontrak){
		$this->db->select('*');
		$this->db->from('piutangmitra');
		$this->db->where('nokontrak', $no_kontrak);
		$this->db->order_by('id', 'desc');
		
		$query = $this->db->get();
		return $query->result();
	}
}
