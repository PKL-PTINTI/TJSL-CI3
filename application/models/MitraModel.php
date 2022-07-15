<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MitraModel extends CI_Model {

	public function getData()
	{
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraMasalah($status){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('tdkbermasalah', $status, ucfirst($status), strtoupper($status));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

    public function getMitraKolektibilitas($kolektibilitas){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', $kolektibilitas, ucfirst($kolektibilitas), strtoupper($kolektibilitas));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraKurangLancar(){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'kurang lancar', 'Kurang Lancar', 'KURANG LANCAR');
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorLancar($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'lancar', 'Lancar', 'LANCAR');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorKurangLancar($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'kurang lancar', 'Kurang Lancar', 'KURANG LANCAR');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorDiragukan($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'diragukan', 'Diragukan', 'DIRAGUKAN');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorMacet($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'macet', 'Macet', 'MACET');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}
	
}