<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('tank_auth');

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$this->data['user_id'] = $this->tank_auth->get_user_id();
			$this->data['username'] = $this->tank_auth->get_username();
			$this->data['email'] = $this->tank_auth->get_email();

			$profile = $this->tank_auth->get_user_profile($this->data['user_id']);

			$this->data['profile_name'] = $profile['name'];
			$this->data['profile_foto'] = $profile['foto'];

			foreach ($this->tank_auth->get_roles($this->data['user_id']) as $val) {
				$this->data['role_id'] = $val['role_id'];
				$this->data['role'] = $val['role'];
				$this->data['full_name_role'] = $val['full'];
			}

			$this->data['link_active'] = 'Dashboard';

			if (!$this->tank_auth->permit($this->data['link_active'])) {
				redirect('Home');
			}

			$this->load->model("ShowmenuModel", "showmenu_model");	
			$this->data['ShowMenu'] = $this->showmenu_model->getShowMenu();

			$OpenShowMenu = $this->showmenu_model->getOpenShowMenu($this->data);

			$this->data['openMenu'] = $this->showmenu_model->getDataOpenMenu($OpenShowMenu->id_menu_parent);

			$this->load->model("RolesModel", "roles_model");	
		}
	}

	function index()
	{
		$this->data['title'] = "Pengaturan Hak Akses";
		$this->data['header'] = "Pengaturan Hak Akses";

		$this->data['listRoles'] = $this->roles_model->getAllRoles();
		$this->template->load('roles/index', $this->data);
	}

	function add()
	{
		$this->form_validation->set_rules('role', 'Hak Akses', 'required');
		$this->form_validation->set_rules('full', 'Nama Lengkap Hak Akses', 'required');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'role' => $this->input->post('role'),
				'full' => $this->input->post('full')
			);

			$this->roles_model->addRole($data);
			$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Role Baru Berhasil Di Tambahkan\',position: \'bottomRight\'});</script>');
			redirect('Roles');
		} else {
			$this->data['role'] = $this->input->post('role');
			$this->data['full'] = $this->input->post('full');

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('Roles/add');
			$this->data['url'] = site_url('Roles');
			$this->data['title'] = "Pengaturan Hak Akses";
			$this->data['header'] = "Pengaturan Hak Akses";

			$this->template->load('roles/create', $this->data);
		}
	}

	function update($id)
	{
		$this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('full', 'Full Name Role', 'required');

		if ($this->form_validation->run() == TRUE) {

			$data = array(
				'role' => $this->input->post('role'),
				'full' => $this->input->post('full')
			);
			$condition['role_id'] = $id;
			$this->roles_model->updateRole($data, $condition);
			$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Role Berhasil Di Update\',position: \'bottomRight\'});</script>');
			redirect('Roles');
		} else {
			$roles = $this->roles_model->getRole($id);

			$this->data['role'] = $roles->role;
			$this->data['full'] = $roles->full;

			if ($this->input->post()) {
				$this->data['role'] = $this->input->post('role');
				$this->data['full'] = $this->input->post('full');
			}

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('Roles/update/' . $id);
			$this->data['url'] = site_url('Roles');
			$this->data['title'] = "Pengaturan Hak Akses";
			$this->data['header'] = "Pengaturan Hak Akses";

			$this->template->load('roles/create', $this->data);
		}
	}

	function delete($id)
	{
		$condition['role_id'] = $id;
		$this->roles_model->deleteRole($condition);
		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Data Role Berhasil Di Hapus\',position: \'bottomRight\'});</script>');
		redirect('Roles');
	}

	function change_default($id)
	{
		$condition['default'] = '1';
		$data = array(
			'default' => '0'
		);
		$this->roles_model->updateRole($data, $condition);

		$condition2['role_id'] = $id;
		$data = array(
			'default' => '1'
		);
		$this->roles_model->updateRole($data, $condition2);
		$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Role Default Berhasil Di Update\',position: \'bottomRight\'});</script>');
		redirect('Roles');
	}

	function role_permission($id)
	{
		$this->form_validation->set_rules('permission_id', 'Permission', 'xss_clean');

		if ($this->input->post()) {
			$condition['role_id'] = $id;

			$this->roles_model->deleteRolePermission($condition);

			$permission_id = $_POST['permission_id'];

			for ($x = 0; count($_POST['permission_id']) > $x; $x++) {
				$data = array(
					'role_id' => $id,
					'permission_id' => $permission_id[$x]
				);

				$this->roles_model->addRolePermission($data);
			}
			$this->session->set_flashdata('message', '<script>iziToast.success({title: \'Success\',message: \'Permission Berhasil Di Assign\',position: \'bottomRight\'});</script>');
			redirect('Roles');
		} else {
			$this->data['listPermission'] = $this->roles_model->getAllPermission();
			$this->data['listPermissionByRoles'] = $this->roles_model->getAllPermissionByRoles($id);

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('Roles/role_permission/' . $id);
			$this->data['url'] = site_url('Roles');
			$this->data['title'] = "Pengaturan Hak Akses";
			$this->data['header'] = "Pengaturan Hak Akses";

			$this->template->load('roles/permission', $this->data);
		}
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
