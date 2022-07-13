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

	public function getMitraTidakBermasalah(){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('tdkbermasalah', 'normal', 'Normal', 'NORMAL');
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraBermasalah(){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('tdkbermasalah', 'masalah', 'Masalah', 'MASALAH');
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

    public function getMitraWipeOut(){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('tdkbermasalah', 'WO', 'Wo', 'wo');
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}
	
}