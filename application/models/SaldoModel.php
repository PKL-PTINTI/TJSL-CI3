<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaldoModel extends CI_Model {

    public function getSaldo()
    {
        $this->db->select('*');
        $this->db->from('saldokasbank');
        $this->db->where('perioda', date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))));
        $query = $this->db->get();
        return $query->result();
    }

    public function getJurnalByAkun($id_akun){
        $this->db->select('sum(pemasukan - pengeluaran) as saldo');
        $this->db->from('opex');
        $this->db->where('id_akun', $id_akun);
        $this->db->where('tanggal >=', date('Y') . '-01-01');
        $this->db->where('tampil', '0');
        $query = $this->db->get();
        return $query->result();
    }

    public function getKas()
    {
        $this->db->select('*');
        $this->db->from('opex');
        $tahun = date('Y') . '-01-01';

		$this->db->where('tanggal >=', $tahun);
        $this->db->where('id_akun', '101010101');
        $this->db->where('tampil', '0');    
        $query = $this->db->get();
        return $query->result();
    }

    public function getMandiri()
    {
        $this->db->select('*');
        $this->db->from('opex');
        $tahun = date('Y') . '-01-01';

		$this->db->where('tanggal >=', $tahun);
        $this->db->where('id_akun', '101010201');
        $this->db->where('tampil', '0');

        $query = $this->db->get();
        return $query->result();
    }

    public function getBri()
    {
        $this->db->select('*');
        $this->db->from('opex');
		$tahun = date('Y') . '-01-01';

		$this->db->where('tanggal >=', $tahun);
        $this->db->where('id_akun', '101010204');
        $this->db->where('tampil', '0');
        $query = $this->db->get();
        return $query->result();
    }

    public function getKartuPerkiraan(){
        $this->db->select('*');
        $this->db->from('opex');
        $this->db->order_by('id_opex', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result(); 
    }
}

