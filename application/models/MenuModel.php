<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MenuModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}

	public function getAllMenu()
	{
		$this->db->from("menu");
		return $this->db->get();
	}

	public function getAllMenuwithjoin()
	{
		$this->db->select("menu_utama.*,sub_menu.nama_menu as nama_menu_parent");
		$this->db->from("menu as menu_utama");
		$this->db->join("menu as sub_menu", 'menu_utama.id_menu_parent = sub_menu.id_menu', 'left');
		return $this->db->get();
	}

	public function getMenu($id)
	{
		$this->db->where('id_menu', $id);
		$this->db->select("*");
		$this->db->from("menu");
		$query = $this->db->get();
		$res = $query->result();
		return $res[0];
	}

	public function addMenu($data)
	{
		$this->db->insert('menu', $data);
	}

	public function updateMenu($data, $condition)
	{
		$this->db->where($condition);
		$this->db->update('menu', $data);
	}

	public function deleteMenu($condition)
	{
		$this->db->where($condition);
		$this->db->delete('menu');
	}
}

?>
