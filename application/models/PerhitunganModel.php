<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganModel extends CI_Model {
    
    public function getSaldoPokokBermasalah($sektor = '') {
        $this->db->select('*');
        $this->db->from('mitra');
        $this->db->where('saldopokok >', '0');
        $this->db->where('tdkbermasalah', 'masalah');
        $this->db->where('tdkbermasalah', 'Masalah');
        $this->db->where('tdkbermasalah', 'MASALAH');

        $query = $this->db->get();

        $saldopokok = [];
        foreach ($query->result_array() as $value) {
            $row = [
                'jumlahsaldo' => 0, 
                'saldoindustri' => 0,
                'saldoperdagangan' => 0,
                'saldopertanian' => 0,
                'saldoperkebunan' => 0,
                'saldoperikanan' => 0,
                'saldopeternakan' => 0,
                'saldojasa' => 0,
                'saldolainlain' => 0,
            ];
            $row['jumlahsaldo'] += $value['saldopokok'];
            // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';

            if($value['sektorUsaha'] == "Sektor Industri"){
                // $row['saldoindustri'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Perdagangan"){
                // $row['saldoperdagangan'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Pertanian"){
                // $row['saldopertanian'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Perkebunan"){
                // $row['saldoperkebunan'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Perikanan"){
                // $row['saldoperikanan'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Peternakan"){
                // $row['saldopeternakan'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Jasa"){
                $row['saldojasa'] += $value['saldopokok'];
                echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }
            
            if($value['sektorUsaha'] == "Sektor Lain-Lain"){
                // $row['saldolainlain'] += $value['saldopokok'];
                // echo $value['sektorUsaha'] . '=>' . $value['saldopokok'] . '<br>';
            }

            $saldopokok = $row;
        }

        return $saldopokok;
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


