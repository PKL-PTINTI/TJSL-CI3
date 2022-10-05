<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function updateCatatanAtasLapKeu($nilaiLaporan, $perioda, $id){
        $this->db->set($perioda, $nilaiLaporan);
        $this->db->where('id', $id);
        $this->db->update('catatanataslapkeu');
    }

    public function selectCatatanAtasLapKeu($fieldPerioda, $id){
        $this->db->select($fieldPerioda);
        $this->db->from('catatanataslapkeu');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array()[0][$fieldPerioda];
    }

    public function updatePerubahanAsetNetoTidakTerikat($perioda, $nilaiLaporan, $id){
        $this->db->set($perioda, $nilaiLaporan);
        $this->db->where('id', $id);
        $this->db->update('perubahanasetnetotidakterikat');
    }

    public function updatePerubahanAsetNetoTidakTerikatSD($perioda, $nilaiLaporan, $id){
        $this->db->set('sd' . $perioda, $nilaiLaporan);
        $this->db->where('id', $id);
        $this->db->update('perubahanasetnetotidakterikat');
    }

    public function selectPerubahanAsetNetoTidakTerikat($fieldPerioda, $id){
        $this->db->select($fieldPerioda);
        $this->db->from('perubahanasetnetotidakterikat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array()[0][$fieldPerioda];
    }

    public function selectPerubahanAsetNetoTidakTerikatSD($fieldPerioda, $id){
        $this->db->select('sd' . $fieldPerioda);
        $this->db->from('perubahanasetnetotidakterikat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array()[0]['sd' . $fieldPerioda];
    }

}


