<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MitraModel extends CI_Model {

	var $table = 'mitra';
    var $column_order = array('nama_peminjam', 'nokontrak', 'lokasiUsaha', 'startcicil', 'kolektibilitas', 'pinjpokok', 'pinjjasa', 'angpokok', 'angjasa', 'angjumlah', 'saldopokok', 'saldojasa', 'saldojumlah', 'namaPerusahaan', 'provinsi', 'lokasiUsaha', 'sektorUsaha', 'skalaUsaha', 'ktp', 'pelaksanaanProgram', 'sumberDana', 'nilaiAset', 'nilaiOmset', 'rekondisi', 'tgl_rekondisi', 'selisihHari', 'kelebihanAngsuran', 'tglkontrak', 'tgljatuhtempo', 'pinjpokok', 'saldopokok', 'saldojasa', 'angpokok', 'angjasa', 'tglcicilanterakhir', 'tdkbermasalah', 'kondisiPinjaman', 'jenisPembayaran', 'bankAccount', 'jumlahSDM', 'kelebihanAngsuran', 'subSektor', 'tambahanDana',null); 
    var $column_search = array('nama_peminjam', 'nokontrak', 'lokasiUsaha', 'startcicil', 'kolektibilitas', 'pinjpokok', 'pinjjasa', 'angpokok', 'angjasa', 'angjumlah', 'saldopokok', 'saldojasa', 'saldojumlah', 'namaPerusahaan', 'provinsi', 'lokasiUsaha', 'sektorUsaha', 'skalaUsaha', 'ktp', 'pelaksanaanProgram', 'sumberDana', 'nilaiAset', 'nilaiOmset', 'rekondisi', 'tgl_rekondisi', 'selisihHari', 'kelebihanAngsuran', 'tglkontrak', 'tgljatuhtempo', 'pinjpokok', 'saldopokok', 'saldojasa', 'angpokok', 'angjasa', 'tglcicilanterakhir', 'tdkbermasalah', 'kondisiPinjaman', 'jenisPembayaran', 'bankAccount', 'jumlahSDM', 'kelebihanAngsuran', 'subSektor', 'tambahanDana'); 
    var $order = array('startcicil' => 'desc');

	public function getMitra($id = null)
	{
		if ($id === null) {
			$this->db->select('*');
			$this->db->from('mitra');
			$this->db->order_by('startcicil', 'DESC');
			$query = $this->db->get();
			
			return $query->result();
		} else {
			$this->db->select('*');
			$this->db->from('mitra');
			$this->db->where('id', $id);
			$query = $this->db->get();
			
			return $query->row();
		}
	}

	private function _get_data_mitra_query($param1, $param2){
		$this->db->from($this->table);
		$i = 0;
		
		// Kolektibilitas
		if($param1 == 'lancar' || $param1 == 'diragukan' || $param1 == 'macet'){
			$this->db->where('kolektibilitas', $param1, ucfirst($param1), strtoupper($param1));
			if ($param2) {
				$this->db->where('sektorUsaha', 'sektor ' . $param2, 'Sektor ' . ucfirst($param2), 'SEKTOR ' . strtoupper($param2));
			}
		}

		if($param1 == 'kuranglancar'){
			$this->db->where('kolektibilitas', 'kurang lancar', 'Kurang Lancar', 'KURANG LANCAR');
			if ($param2) {
				$this->db->where('sektorUsaha', 'sektor ' . $param2, 'Sektor ' . ucfirst($param2), 'SEKTOR ' . strtoupper($param2));
			}
		}

		// TDK Bermasalah
		if($param1 == 'normal' || $param1 == 'masalah' || $param1 == 'khusus' || $param1 == 'wo'){
			$this->db->where('tdkbermasalah', $param1, ucfirst($param1), strtoupper($param1));
			if ($param2) {
				$this->db->where('sektorUsaha', 'sektor ' . $param2, 'Sektor ' . ucfirst($param2), 'SEKTOR ' . strtoupper($param2));
			}
		}

        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	function get_data_mitra($param1, $param2)
    {
		$this->_get_data_mitra_query($param1, $param2);
        if ($this->input->post('length') != -1){
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		}
		
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_mitra($param1, $param2)
    {
        $this->_get_data_mitra_query($param1, $param2);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_mitra($param1, $param2)
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	public function getMitraKontrak($no_kontrak)
	{
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('nokontrak', $no_kontrak);
		$query = $this->db->get();
		
		return $query->row();
	}

	public function getMitraCicilan($id)
	{
		$this->db->select('*');
		$this->db->from('angsuranpinjaman');
		$this->db->where('id_peminjam', $id);
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getLokasi(){
		$this->db->select('*');
		$this->db->from('lokasiusaha');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getStatusMitra(){
		$this->db->select('*');
		$this->db->from('statusmitra');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getKodeBank(){
		$this->db->select('*');
		$this->db->from('kodebank');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getHasilEvaluasi(){
		$this->db->select('*');
		$this->db->from('hasilevaluasi');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getKasBank(){
		$this->db->select('*');
		$this->db->from('kasbrimandiri');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getKasBankCicilan(){
		$this->db->select('*');
		$this->db->from('cicilanmitra');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getPelaksanaanProgram(){
		$this->db->select('*');
		$this->db->from('pelaksanaanprogram');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getKondisiPinjaman(){
		$this->db->select('*');
		$this->db->from('kondisipinjaman');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getJenisPembayaran(){
		$this->db->select('*');
		$this->db->from('jenispembayaran');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getSkalaUsaha(){
		$this->db->select('*');
		$this->db->from('skalausaha');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getSektorUsaha(){
		$this->db->select('*');
		$this->db->from('sektorusaha');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getAkunKorek($kode_rekening){
		$this->db->select('*');
		$this->db->from('akun');
		$this->db->where('korek', $kode_rekening);
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getOpexCicilan(){
		$this->db->select('*');
		$this->db->from('opex');
		$this->db->where('id_akun', '403010100');
		$this->db->or_where('id_akun', '101060201');
		$this->db->or_where('id_akun', '101060202');
		$this->db->or_where('id_akun', '101060203');
		$this->db->or_where('id_akun', '101060204');
		$this->db->or_where('id_akun', '101060205');
		$this->db->or_where('id_akun', '101060206');
		$this->db->or_where('id_akun', '101060207');
		$this->db->or_where('id_akun', '101060208');
		$this->db->order_by('tanggal', 'ASC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraMasalah($status){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('tdkbermasalah', $status, ucfirst($status), strtoupper($status));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraStatusSektor($status, $sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('tdkbermasalah', $status, ucfirst($status), strtoupper($status));
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getMitraMasalahKolektibilitas($masalah, $kolektibilitas){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', $kolektibilitas, ucfirst($kolektibilitas), strtoupper($kolektibilitas));
		$this->db->where('tdkbermasalah', $masalah, ucfirst($masalah), strtoupper($masalah));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

    public function getMitraKolektibilitas($kolektibilitas){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', $kolektibilitas, ucfirst($kolektibilitas), strtoupper($kolektibilitas));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraKurangLancar(){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'kurang lancar', 'Kurang Lancar', 'KURANG LANCAR');
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorLancar($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'lancar', 'Lancar', 'LANCAR');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorKurangLancar($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'kurang lancar', 'Kurang Lancar', 'KURANG LANCAR');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorDiragukan($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'diragukan', 'Diragukan', 'DIRAGUKAN');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getMitraSektorMacet($sektor){
		$this->db->select('*');
		$this->db->from('mitra');
		$this->db->where('kolektibilitas', 'macet', 'Macet', 'MACET');
		$this->db->where('sektorUsaha', 'sektor ' . $sektor, 'Sektor ' . ucfirst($sektor), 'SEKTOR ' . strtoupper($sektor));
		$this->db->order_by('startcicil', 'DESC');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getKasBRI(){
		$this->db->select('*');
		$this->db->from('kasbri');
		$this->db->order_by('id_bri', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->result();
	}

	public function getKasMandiri(){
		$this->db->select('*');
		$this->db->from('kasmandiri');
		$this->db->order_by('id_mandiri', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->result();
	}

	public function insert($data){
		$this->db->insert('mitra', $data);
	}

	public function insertOpex($data){
		$this->db->insert('opex', $data);
	}

	public function insertKasBRI($data){
		$this->db->insert('kasbri', $data);
	}

	public function insertKasMandiri($data){
		$this->db->insert('kasmandiri', $data);
	}

	public function destroy($id){
		$this->db->where('id', $id);
		$this->db->delete('mitra');
	}

	public function updatePinjamanJumlah($no_kontrak, $jumlah){
		$this->db->set('pinjjumlah', $jumlah);
		$this->db->where('nokontrak', $no_kontrak);
		$this->db->update('mitra');
	}

	public function updateKolektibilitas($no_kontrak, $kolektibilitas){
		$this->db->set('kolektibilitas', $kolektibilitas);
		$this->db->where('nokontrak', $no_kontrak);
		$this->db->update('mitra');
	}
	
}