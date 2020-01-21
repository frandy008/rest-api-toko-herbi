<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_toko_herbi extends CI_Model {

	public function loginUser($u,$p)
	{
		return $this->db->get_where('tbl_users', ['username' => $u, 'password' => $p ])->result_array();
	}

}

/* End of file M_toko_herbi.php */
/* Location: ./application/models/M_toko_herbi.php */