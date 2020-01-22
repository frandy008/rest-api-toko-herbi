<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_product extends CI_Model {

	public function getProduct($key = null)
	{
		if ($key === null) {
			# code...
			return $this->db->get('tbl_product')->result_array();
		}else{
			return $this->db->get_where('tbl_product', ['nama_product' => $key ])->result_array();
		}
	}

	public function deletePesanan($kp)
	{
		$this->db->delete('tbl_pesanan', ['kode_pesanan' => $kp]);
		return $this->db->affected_rows();
	}

	public function createPesanan($data)
	{
		$this->db->insert('tbl_pesanan', $data);
		return $this->db->affected_rows();
	}

	public function updatePesanan($data,$kode_pesanan)
	{
		//$this->db->query("UPDATE tbl_pesanan SET nama_pemesan = '$npem', nama_pesanan = '$npes', jumlah = '$jum', dp = '$dp', total_bayar = '$tb' WHERE kode_pesanan = '$kode_pesanan'");
		$this->db->update('tbl_pesanan', $data, ['kode_pesanan' => $kode_pesanan]);
		return $this->db->affected_rows();
	}

}

/* End of file M_pesanan.php */
/* Location: ./application/models/M_pesanan.php */