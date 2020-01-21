<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

class User extends RestController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_toko_herbi');

		$this->methods['pesanan_get']['limit'] = 1; // 500 requests per hour per user/key
	}

	public function index_get()
	{
		$username = $this->get('u');
		$password = md5($this->get('p'));
		
		$login = $this->M_toko_herbi->loginUser($username,$password);
		
		if ($login) {
			
			$this->response([
                'Response' => 'True',
                'dataPesanan' => $pesanan
            ], RestController::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}else{
			$this->response([
                'Response' => 'False',
                'message' => 'kode pesanan tidak tersedia'
            ], RestController::HTTP_NOT_FOUND);
		}
	}

	public function index_delete()
	{
		$kode_pesanan = $this->delete('kp');

		if ($kode_pesanan === null) {
			$this->response([
                'Response' => 'False',
                'message' => 'masukan kode pesanan'
            ], RestController::HTTP_BAD_REQUEST);
		}else{
			if ($this->M_pesanan->deletePesanan($kode_pesanan) > 0) {
				$this->response([
	                'Response' => 'True',
	                'kode_pesanan' => $kode_pesanan,
	                'message' => 'berhasil dihapus'
	            ], RestController::HTTP_NO_CONTENT);
			}else{
				$this->response([
	                'Response' => 'False',
	                'message' => 'kode pesanan tidak ditemukan'
	            ], RestController::HTTP_BAD_REQUEST);	
			}
		}
	}

	public function index_post()
	{
		$data = [
			//'kode_pesanan' => $this->post('kode_pesanan'),
			'nama_pemesan' => $this->post('nama_pemesan'),
			'nama_pesanan' => $this->post('nama_pesanan'),
			'jumlah' => $this->post('jumlah'),
			'dp' => $this->post('dp'),
			'total_bayar' => $this->post('total_bayar')

		];

		if ($this->M_pesanan->createPesanan($data) > 0) {
			$this->response([
	                'Response' => 'True',
	                'message' => 'berhasil membuat pesanan'
            ], RestController::HTTP_CREATED);
		}else{
				$this->response([
	                'Response' => 'False',
	                'message' => 'gagal membuat pesanan'
	            ], RestController::HTTP_BAD_REQUEST);	
		}
	}

	public function index_put()
	{
		$kode_pesanan = $this->put('kp');
		$data = [
			'nama_pemesan' => $this->put('nama_pemesan'),
			'nama_pesanan' => $this->put('nama_pesanan'),
			'jumlah' => $this->put('jumlah'),
			'dp' => $this->put('dp'),
			'total_bayar' => $this->put('total_bayar'),
		];

		if ($this->M_pesanan->updatePesanan($data, $kode_pesanan) > 0) {
			$this->response([
	                'Response' => 'True',
	                'message' => 'berhasil memperbarui pesanan'
            ], RestController::HTTP_NO_CONTENT);
		}else{
				$this->response([
	                'Response' => 'False',
	                'message' => 'gagal memperbarui pesanan'
	            ], RestController::HTTP_BAD_REQUEST);	
		}
	}

}

/* End of file Pesanan.php */
/* Location: ./application/controllers/api/Pesanan.php */