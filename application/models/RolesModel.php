<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RolesModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getAllRoles()
	{
		$this->db->from("roles");

		return $this->db->get();
	}

	function getRole($id)
	{
		$this->db->where('role_id', $id);
		$this->db->select("*");
		$this->db->from("roles");
		$query = $this->db->get();
		$res = $query->result();
		return $res[0];
	}

	function addRole($data)
	{
		$this->db->insert('roles', $data);
	}

	function updateRole($data, $condition)
	{
		$this->db->where($condition);
		$this->db->update('roles', $data);
	}

	function deleteRole($condition)
	{
		$this->db->where($condition);
		$this->db->delete('roles');
	}

	public function deleteRolePermission($condition)
	{
		$this->db->where($condition);
		$this->db->delete('role_permissions');
	}

	public function addRolePermission($data)
	{
		$this->db->insert('role_permissions', $data);
	}

	public function getAllPermission()
	{
		$this->db->from("permissions");
		return $this->db->get();
	}

	public function getAllPermissionByRoles($id)
	{
		$this->db->where('role_id', $id);
		$this->db->select("permission_id");
		$this->db->from("role_permissions");

		$query = $this->db->get();
		$id_permission = array();

		foreach ($query->result() as $data) {
			$id_permission[] = $data->permission_id;
		}
		
		return $id_permission;
	}
}
