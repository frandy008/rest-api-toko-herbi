<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_toko_herbi extends CI_Model {

	public function loginUser($u,$p)
	{
		return $this->db->get_where('tbl_users', ['username' => $u, 'password' => $p ])->result_array();
	}

	public function loginUserUpdate($u){
		$tgl = date("d/m/Y");
		$this->db->query("UPDATE tbl_users SET last_login = '$tgl' WHERE username = '$u'");
	}

	public function deleteUser($u)
	{
		$this->db->delete('tbl_users', ['username' => $u]);
		return $this->db->affected_rows();
	}

	public function addUser($data)
	{
		$this->db->insert('tbl_users', $data);
		return $this->db->affected_rows();
	}

	public function updateUser($data,$idu)
	{
		//$this->db->query("UPDATE tbl_pesanan SET nama_pemesan = '$npem', nama_pesanan = '$npes', jumlah = '$jum', dp = '$dp', total_bayar = '$tb' WHERE kode_pesanan = '$kode_pesanan'");
		$this->db->update('tbl_users', $data, ['id_user' => $idu]);
		return $this->db->affected_rows();
	}

}

/* End of file M_toko_herbi.php */
/* Location: ./application/models/M_toko_herbi.php */