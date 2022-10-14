<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NeracaSaldoModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $this->bulansekarang = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))));
		$this->bulansebelumnya = $this->_tanggal(date('y-m', mktime(0, 0, 0, date("m")-2, date("d"), date("Y"))));
        $this->desTahunLalu = 'des' . date('y', strtotime('-1 year'));
    }

    public function getNeracaSaldo()
    {
        $this->db->select('*');
        $this->db->from('neracasaldo');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDesTahunLaluNeracaSaldo(){
        $this->db->select('id');
        $this->db->select($this->desTahunLalu);
        $this->db->from('neracasaldo');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateNeracaSaldo($data, $id){
        $this->db->set('saldo' . $this->bulansekarang, $data);
        $this->db->where('id', $id);
        $this->db->update('neracasaldo');
    }

    public function updateNeracaSaldoKredit($data, $id){
        $this->db->set('kredit' . $this->bulansekarang, $data);
        $this->db->where('id', $id);
        $this->db->update('neracasaldo');
    }

    public function updateNeracaSaldoDebet($data, $id){
        $this->db->set('debet' . $this->bulansekarang, $data);
        $this->db->where('id', $id);
        $this->db->update('neracasaldo');
    }

    public function updateNeracaSaldoDesTahunLalu($data, $id){
        $this->db->set($this->desTahunLalu, $data);
        $this->db->where('id', $id);
        $this->db->update('neracasaldo');
    }

    public function getCatatanAtasLapKeu(){
        $this->db->select('id');
        $this->db->select($this->desTahunLalu);
        $this->db->from('catatanataslapkeu');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCatatanAtasLapKeuBulan   (){
        $this->db->select('id');
        $this->db->select($this->bulansekarang);
        $this->db->from('catatanataslapkeu');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function updateNeracaSaldoSelisih($data, $id){
        $this->db->set('selisih', $data);
        $this->db->where('id', $id);
        $this->db->update('neracasaldo');
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