<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganModel extends CI_Model {
    
    public function getSaldoPokokBermasalah($sektor = '') {
        $this->db->select_sum('saldopokok');
        $this->db->from('mitra');
        $this->db->where('saldopokok >', '0');
        $this->db->where('tdkbermasalah', 'masalah');
        $this->db->where('tdkbermasalah', 'Masalah');
        $this->db->where('tdkbermasalah', 'MASALAH');
        if ($sektor != '') {
            $this->db->where('sektorUsaha', $sektor);
        }

        $query = $this->db->get();
        return $query->result()[0]->saldopokok;
    }

    public function getSaldoPokokTdkBermasalah($kolektibilitas = '') {
        $this->db->select_sum('saldopokok');
        $this->db->from('mitra');
        $this->db->where('saldopokok >', '0');
        if ($kolektibilitas) {
            $this->db->where('kolektibilitas', $kolektibilitas, ucfirst($kolektibilitas), strtoupper($kolektibilitas));
        }
        $this->db->where('tdkbermasalah', 'normal');
        $this->db->where('tdkbermasalah', 'Normal');
        $this->db->where('tdkbermasalah', 'NORMAL');
        $query = $this->db->get();
        return $query->result()[0]->saldopokok;
    }

    public function getSaldoOpexAkun($query = '') {	
        $tanggalawal = date('Y-m-01', mktime(0, 0, 0, date('m')-1, date('d'), date('y')));
		$tanggalakhir = date('Y-m-01');

        $this->db->select_sum('pengeluaran');
        $this->db->select_sum('pemasukan');
        $this->db->from('opex');
        $this->db->where('tanggal >=', $tanggalawal);
        $this->db->where('tanggal <=', $tanggalakhir);
        $this->db->where($query);
        $query = $this->db->get();
        return ($query->result()[0]->pengeluaran - $query->result()[0]->pemasukan);
    }

}


