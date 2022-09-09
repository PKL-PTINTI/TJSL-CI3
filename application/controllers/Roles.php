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

			$this->data['link_active'] = 'Roles';

			if (!$this->tank_auth->permit($this->data['link_active'])) {
				redirect('Home');
			}

			$this->load->model("Showmenu_model");
			$this->data['ShowMenu'] = $this->Showmenu_model->getShowMenu();

			$OpenShowMenu = $this->Showmenu_model->getOpenShowMenu($this->data);

			$this->data['openMenu'] = $this->Showmenu_model->getDataOpenMenu($OpenShowMenu->id_menu_parent);

			$this->load->model("Roles_model");
		}
	}

	function index()
	{
		$this->data['title'] = "Pengaturan Hak Akses";

		$this->data['breadcrumbs'] = [];

		$this->data['breadcrumbs'][] = [
			'active' => FALSE,
			'text' => 'Pengaturan',
			'class' => 'breadcrumb-item pe-3 text-white',
			'href' => ''
		];

		$this->data['breadcrumbs'][] = [
			'active' => FALSE,
			'text' => 'Pengaturan Penguna',
			'class' => 'breadcrumb-item pe-3 text-white',
			'href' => ''
		];

		$this->data['breadcrumbs'][] = [
			'active' => TRUE,
			'text' => 'Pengaturan Hak Akses',
			'class' => 'breadcrumb-item pe-3 text-gray-400',
			'href' => site_url('Roles')
		];

		$this->data['listRoles'] = $this->Roles_model->getAllRoles();

		$this->load->view('component/header', $this->data);
		$this->load->view('component/sidebar', $this->data);
		$this->load->view('roles/views', $this->data);
		$this->load->view('component/footer');
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

			$this->Roles_model->addRole($data);
			redirect('Roles');
		} else {
			$this->data['role'] = $this->input->post('role');
			$this->data['full'] = $this->input->post('full');

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('Roles/add');
			$this->data['url'] = site_url('Roles');
			$this->data['title'] = "Pengaturan Hak Akses";

			$this->data['breadcrumbs'] = [];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Pengaturan',
				'class' => 'breadcrumb-item pe-3 text-white',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Pengaturan Penguna',
				'class' => 'breadcrumb-item pe-3 text-white',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => TRUE,
				'text' => 'Pengaturan Hak Akses',
				'class' => 'breadcrumb-item pe-3 text-gray-400',
				'href' => site_url('Roles')
			];

			$this->load->view('component/header', $this->data);
			$this->load->view('component/sidebar', $this->data);
			$this->load->view('roles/form', $this->data);
			$this->load->view('component/footer');
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
			$this->Roles_model->updateRole($data, $condition);
			redirect('Roles');
		} else {
			$roles = $this->Roles_model->getRole($id);

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

			$this->data['breadcrumbs'] = [];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Pengaturan',
				'class' => 'breadcrumb-item pe-3 text-white',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Pengaturan Penguna',
				'class' => 'breadcrumb-item pe-3 text-white',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => TRUE,
				'text' => 'Pengaturan Hak Akses',
				'class' => 'breadcrumb-item pe-3 text-gray-400',
				'href' => site_url('Roles')
			];

			$this->load->view('component/header', $this->data);
			$this->load->view('component/sidebar', $this->data);
			$this->load->view('roles/form', $this->data);
			$this->load->view('component/footer');
		}
	}

	function delete($id)
	{
		$condition['role_id'] = $id;
		$this->Roles_model->deleteRole($condition);
		redirect('Roles');
	}

	function change_default($id)
	{
		$condition['default'] = '1';
		$data = array(
			'default' => '0'
		);
		$this->Roles_model->updateRole($data, $condition);

		$condition2['role_id'] = $id;
		$data = array(
			'default' => '1'
		);
		$this->Roles_model->updateRole($data, $condition2);
		redirect('Roles');
	}

	function role_permission($id)
	{
		$this->form_validation->set_rules('permission_id', 'Permission', 'xss_clean');

		if ($this->input->post()) {
			$condition['role_id'] = $id;

			$this->Roles_model->deleteRolePermission($condition);

			$permission_id = $_POST['permission_id'];

			for ($x = 0; count($_POST['permission_id']) > $x; $x++) {
				$data = array(
					'role_id' => $id,
					'permission_id' => $permission_id[$x]
				);

				$this->Roles_model->addRolePermission($data);
			}

			redirect('Roles');
		} else {
			$this->data['listPermission'] = $this->Roles_model->getAllPermission();
			$this->data['listPermissionByRoles'] = $this->Roles_model->getAllPermissionByRoles($id);

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('Roles/role_permission/' . $id);
			$this->data['url'] = site_url('Roles');
			$this->data['title'] = "Pengaturan Hak Akses";

			$this->data['breadcrumbs'] = [];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Pengaturan',
				'class' => 'breadcrumb-item pe-3 text-white',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Pengaturan Penguna',
				'class' => 'breadcrumb-item pe-3 text-white',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => TRUE,
				'text' => 'Pengaturan Hak Akses',
				'class' => 'breadcrumb-item pe-3 text-gray-400',
				'href' => site_url('Roles')
			];

			$this->load->view('component/header', $this->data);
			$this->load->view('component/sidebar', $this->data);
			$this->load->view('roles/form_permission', $this->data);
			$this->load->view('component/footer');
		}
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
