<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PosisiKeuanganModel extends CI_Model {
    
    public function _getData() {
        $this->db->select('*');
        $this->db->from('neraca');
        $query = $this->db->get();
        $neraca =  $query->result_array();

        $no = 0;
        $dataNeraca = array();

        // foreach ($neraca as $key => $value) {
        //     foreach ($value as $k => $v) {
        //         $no++;
        //         $deskripsi = $this->_getDeskripsi($k);
        //         $dataNeraca[$no] = array(
        //             'deskripsi' => $deskripsi,
        //             'nilai'  => $v
        //         );
        //     }
        // }

        foreach ($neraca as $key => $value) {
            // $no++;
            // $deskripsi = $this->_getDeskripsi($value['kode_akun']);
            // $dataNeraca[$no] = array(
            //     'deskripsi' => $deskripsi,
            //     'nilai'  => $value['nilai']
            // );
            var_dump($value);
            echo "<br><hr>";
        }

        echo '<pre>';
        var_dump($dataNeraca);
    }

    public function getData(){
        $this->db->select('*');
        $this->db->from('neraca');
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


