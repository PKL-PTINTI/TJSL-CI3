<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->bulansekarang = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$this->bulansebelumnya = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-2, date("d"), date("Y"))));
		$this->desTahunLalu = 'des' . strval(date('y') - 1);
    }

    public function updateCatatanAtasLapKeu($data, $id){
        $this->db->set($this->bulansekarang, $data);
        $this->db->where('id', $id);
        $this->db->update('catatanataslapkeu');
    }

    public function updatePerubahanAsetNetoTidakTerikat($data, $id){
        $this->db->set($this->bulansekarang, $data);
        $this->db->where('id', $id);
        $this->db->update('perubahanasetnetotidakterikat');
    }

    public function updatePerubahanAsetNetoTidakTerikatSD($data, $id){
        $this->db->set('sd' . $this->bulansekarang, $data);
        $this->db->where('id', $id);
        $this->db->update('perubahanasetnetotidakterikat');
    }

    private function _tanggal($tanggal){
		$bulan = array (
			1 =>   'jan',
			'feb',
			'mar',
			'apr',
			'mei',
			'jun',
			'jul',
			'ags',
			'sep',
			'okt',
			'nov',
			'des'
		);
		$pecahkan = explode('-', $tanggal);
	 
		return $bulan[(int)$pecahkan[1]] . $pecahkan[0];

	}

}


