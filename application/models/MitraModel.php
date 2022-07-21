<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MitraModel extends CI_Model {

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
		$this->db->where('id_akun','403010100');
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