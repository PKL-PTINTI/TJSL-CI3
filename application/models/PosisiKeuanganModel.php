<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PosisiKeuanganModel extends CI_Model {
    
    public function _getData() {
        $this->db->select('*');
        $this->db->from('neraca');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getData($perioda){
        $this->db->select('kas');
        $this->db->select('bank');
        $this->db->select('piutang_mb');
        $this->db->select('alokasi_piutang');
        $this->db->select('jumlah_aset_lancar');
        $this->db->select('inventaris_peralatan');
        $this->db->select('akumulasi');
        $this->db->select('jumlah_aset_bersih');
        $this->db->select('piutang_bermasalah');
        $this->db->select('alokasi_piutang_bermasalah');
        $this->db->select('jumlah_aset_lain');
        $this->db->select('jumlah_aset');
        $this->db->select('kelebihan_pembayaran');
        $this->db->select('angsuran_tak_teridentifikasi');
        $this->db->select('kewajiban_jangka_panjang');
        $this->db->select('jumlah_liabilitas');
        $this->db->select('aset_neto_terikat');
        $this->db->select('aset_neto_tak_terikat');
        $this->db->select('jumlah_aset_neto');
        $this->db->select('jumlah_liabilitas_dan_neto');
        $this->db->from('neraca_ref');  
        $this->db->where('jenis_nilai', 'nilai');
        $this->db->where('periode', $perioda);
        $query = $this->db->get();

        return $query->result_array()[0];
    }

    public function getDataDes(){
        $this->db->select('kas');
        $this->db->select('bank');
        $this->db->select('piutang_mb');
        $this->db->select('alokasi_piutang');
        $this->db->select('jumlah_aset_lancar');
        $this->db->select('inventaris_peralatan');
        $this->db->select('akumulasi');
        $this->db->select('jumlah_aset_bersih');
        $this->db->select('piutang_bermasalah');
        $this->db->select('alokasi_piutang_bermasalah');
        $this->db->select('jumlah_aset_lain');
        $this->db->select('jumlah_aset');
        $this->db->select('kelebihan_pembayaran');
        $this->db->select('angsuran_tak_teridentifikasi');
        $this->db->select('kewajiban_jangka_panjang');
        $this->db->select('jumlah_liabilitas');
        $this->db->select('aset_neto_terikat');
        $this->db->select('aset_neto_tak_terikat');
        $this->db->select('jumlah_aset_neto');
        $this->db->select('jumlah_liabilitas_dan_neto');
        $this->db->from('neraca_ref'); 
        $this->db->or_where('periode', 'des' . strval(date('y') - 1));
        $query = $this->db->get();

        return $query->result_array()[0];
    }

    public function getDataDeskripsi(){
        $this->db->select('*');
        $this->db->from('deskripsi_laporan');  
        $this->db->where('laporan', 'neraca');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    private function _getDeskripsi($k){
        $this->db->select('*');
        $this->db->from('deskripsi_laporan');
        $this->db->where('nama_field', $k);
        $query = $this->db->get();
        return $query->result_array()[0]['nama'] ?? '';
    }
            
}


