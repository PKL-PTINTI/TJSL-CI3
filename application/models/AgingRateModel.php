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

	public function getAgingRateHitung(){
		$this->db->select('*');
		$this->db->from('transposeagingrate');
		$this->db->where('bulan >=', date('Y-01-t', strtotime('-1 year')));
		$this->db->where('bulan <=', date('Y-01-t', strtotime('+1 year')));
		$query = $this->db->get();
		return $query->result_array();
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

	public function getTotalMacetBulanLalu(){
		$this->db->select('macet');
		$this->db->from('transposeagingrate');
		$this->db->where('bulan', date('Y-m-d', strtotime("last day of -2 month")));
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getProdef(){
		$this->db->select('prodeflancar');		
		$this->db->select('prodefkuranglancar');
		$this->db->from('transposeagingrate');
		$this->db->where('bulan', date('Y-m-d', strtotime("last day of -1 month")));
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
}
