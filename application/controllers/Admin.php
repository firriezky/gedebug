<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$data = $this->db->get('buku')->result();
		$this->load->view('show', ['var_data' => $data]);
	}

	public function cek_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
		);
		$cek = $this->m_login->cek_login("admin", $where)->num_rows();
		if ($cek > 0) {

			$data_session = array(
				'nama' => $username,
				'status' => "login"
			);

			$this->session->set_userdata($data_session);

			redirect(base_url("admin"));
		} else {
			echo "Username dan password salah !";
		}
	}

	function edit_buku($id_buku)
	{
        echo "$id_buku";
		// $data['siswa'] = $this->siswa_model->getById($kd_siswa);
		// $this->load->view('template/header');
		// $this->load->view('siswa/edit',$data);
		// $this->load->view('template/footer');
	}


	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
