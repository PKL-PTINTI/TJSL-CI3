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
}

