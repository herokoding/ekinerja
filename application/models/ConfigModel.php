<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ConfigModel extends CI_Model
{

	public function getUser($userId)
	{
		$this->db->select('user.*,role.*,depart.*');
		$this->db->join('roles role', 'role.role_id = user.role_id', 'left');
		$this->db->join('departments depart', 'depart.depart_id = user.department_id', 'left');
		$this->db->where('user.user_id', $userId);

		return $this->db->get('users user');
	}

	public function updateProfile()
	{
		$user_id = $this->session->userdata('user_id');
		$user_fullname = $this->input->post('user_fullname');
		$user_email = $this->input->post('user_email');
		$username = $this->input->post('username');
		$role_id = $this->input->post('role_id');
		$department_id = $this->input->post('department_id');

		$this->db->where('user_id', $user_id);
		$this->db->update('users', [
			'user_fullname' => $user_fullname,
			'user_email' => $user_email,
			'username' => $username,
			'role_id' => $role_id,
			'department_id' => $department_id
		]);

		return $this->db->affected_rows();
	}

	public function updatePassword()
	{
		$user_id = $this->session->userdata('user_id');
		$current_password = $this->input->post('current_password');
		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');

		// Periksa apakah password saat ini benar
		$user = $this->getUser($user_id);
		if (!password_verify($current_password, $user->user_password)) {
			// Jika password saat ini salah, kembalikan error
			$this->session->set_flashdata('message', 'Password saat ini salah');
			redirect('user/show-profile');
		}

		// Periksa apakah password baru dan konfirmasi password cocok
		if ($new_password !== $confirm_password) {
			// Jika tidak cocok, kembalikan error
			$this->session->set_flashdata('message', 'Password baru dan konfirmasi password tidak cocok');
			redirect('user/show-profile');
		}

		// Hash password baru
		$user_password = password_hash($new_password, PASSWORD_DEFAULT);

		// Perbarui password di database
		$this->db->where('user_id', $user_id);
		$this->db->update('users', [
			'user_password' => $user_password
		]);

		$this->session->set_flashdata('success', 'Password berhasil diperbarui');
		redirect('user/show-profile');
	}
}

/* End of file ConfigModel.php */
/* Location: ./application/models/ConfigModel.php */