<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JurnalModel extends CI_Model {

	var $table = 'opex';
    var $column_order = array('id_opex', 'id_akun', 'tanggal', 'pemasukan', 'pengeluaran', 'deskripsi', 'keterangan', 'updated', 'tglUpdate', 'nobukti', 'tot_pemasukan', 'tot_pengeluaran', 'tampil', null); 
    var $column_search = array('id_opex', 'id_akun', 'tanggal', 'pemasukan', 'pengeluaran', 'deskripsi', 'keterangan', 'updated', 'tglUpdate', 'nobukti', 'tot_pemasukan', 'tot_pengeluaran', 'tampil'); 
    var $order = array('tanggal' => 'desc');
	
	public function get_jurnal(){
		$this->db->select('*');
		$this->db->from('opex');
		$query = $this->db->get();
		
		return $query->result();
	}

	private function _get_datatables_query(){
		$this->db->from($this->table);
        $i = 0;
		
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

	function get_datatables()
    {
		$this->_get_datatables_query();
        if ($this->input->post('length') != -1){
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		}
		
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	private function _get_datatables_bank($bank){
		$this->db->from($this->table);

		if($bank == 'kas'){
			$this->db->where('id_akun', '101010101');
		} elseif ($bank == 'bri') {
			$this->db->where('id_akun', '101010204');
		} elseif ($bank == 'mandiri') {
			$this->db->where('id_akun', '101010201');
		} elseif ($bank == 'bank') {
			$this->db->where('id_akun', '101010204');
			$this->db->or_where('id_akun', '101010201');
		}

        $i = 0;
		
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

	function get_datatables_bank($bank)
    {
		$this->_get_datatables_bank($bank);
        if ($this->input->post('length') != -1){
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		}
		
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_bank($bank)
    {
        $this->_get_datatables_bank($bank);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bank()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getKodeRekening(){
		$this->db->select('*');
		$this->db->from('akun');
		$query = $this->db->get();
		
		return $query->result();
	}

	public function getKodeRekeningPasangan(){
		$this->db->select('*');
		$this->db->from('akun');
		$query = $this->db->get();
		
		return $query->result();
	}

    public function getDeskripsiAkun($korek){
        $this->db->select('*');
        $this->db->from('akun');
        $this->db->where('korek', $korek);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function insert($data){
		$this->db->insert('opex', $data);
	}

    public function getKasBri(){
        $this->db->select('*');
        $this->db->from('kasbri');
        $this->db->order_by('id_bri', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function insertKasBri($data){
        $this->db->insert('kasbri', $data);
    }

    public function getKasMandiri(){
        $this->db->select('*');
        $this->db->from('kasmandiri');
        $this->db->order_by('id_mandiri', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function insertKasMandiri($data){
        $this->db->insert('kasmandiri', $data);
    }
}

	