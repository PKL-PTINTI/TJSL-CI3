<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PermissionModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAllPermission()
	{
		$this->db->from("permissions");
		return $this->db->get();
	}

	public function getPermission($id)
	{
		$this->db->where('permission_id', $id);
		$this->db->select("*");
		$this->db->from("permissions");
		$query = $this->db->get();
		$res = $query->result();
		return $res[0];
	}

	public function addPermission($data)
	{
		$this->db->insert('permissions', $data);
	}

	public function updatePermission($data, $condition)
	{
		$this->db->where($condition);
		$this->db->update('permissions', $data);
	}

	public function deletePermission($condition)
	{
		$this->db->where($condition);
		$this->db->delete('permissions');
	}
}
