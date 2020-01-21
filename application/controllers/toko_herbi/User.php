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

		//$this->methods['pesanan_get']['limit'] = 1; // 500 requests per hour per user/key
	}

	public function index_get()
	{
		$username = $this->get('u');
		$password = md5($this->get('p'));
		
		$login = $this->M_toko_herbi->loginUser($username,$password);
		
		if ($login) {
			$this->M_toko_herbi->loginUserUpdate($username);
			$this->response([
                'Response' => 'True',
                'dataUser' => $login
            ], RestController::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}else{
			$this->response([
                'Response' => 'False',
                'message' => 'Username atau password salah !'
            ], RestController::HTTP_NOT_FOUND);
		}
	}

	public function index_delete()
	{
		$username = $this->delete('u');

		if ($username === null) {
			$this->response([
                'Response' => 'False',
                'Message' => 'Pilih user yang ingin di hapus'
            ], RestController::HTTP_BAD_REQUEST);
		}else{
			if ($this->M_toko_herbi->deleteUser($username) > 0) {
				$this->response([
	                'Response' => 'True',
	                'Username' => $username,
	                'Message' => 'berhasil dihapus'
	            ], RestController::HTTP_NO_CONTENT);
			}else{
				$this->response([
	                'Response' => 'False',
	                'Message' => 'User tidak ditemukan'
	            ], RestController::HTTP_BAD_REQUEST);	
			}
		}
	}

	public function index_post()
	{
		$data = [
			//'kode_pesanan' => $this->post('kode_pesanan'),
			'username' => $this->post('u'),
			'password' => md5($this->post('p')),
			'no_hp' => $this->post('no_hp'),
			'email' => $this->post('email'),
			'id_level' => $this->post('level')

		];

		if ($this->M_toko_herbi->addUser($data) > 0) {
			$this->response([
	                'Response' => 'True',
	                'Message' => 'Berhasil menambah user'
            ], RestController::HTTP_CREATED);
		}else{
				$this->response([
	                'Response' => 'False',
	                'Message' => 'gagal membuat pesanan'
	            ], RestController::HTTP_BAD_REQUEST);	
		}
	}

	public function index_put()
	{
		$id_user = $this->put('idu');
		$data = [
			'username' => $this->put('u'),
			'password' => md5($this->put('p')),
			'no_hp' => $this->put('no_hp'),
			'email' => $this->put('email'),
			'id_level' => $this->put('level')
		];

		if ($this->M_toko_herbi->updateUser($data, $id_user) > 0) {
			$this->response([
	                'Response' => 'True',
	                'Message' => 'Berhasil memperbarui user'
            ], 204);
		}else{
			$this->response([
                'Response' => 'False',
                'Message' => 'gagal memperbarui user'
            ], 400);	
		}
	}

}

/* End of file Pesanan.php */
/* Location: ./application/controllers/api/Pesanan.php */