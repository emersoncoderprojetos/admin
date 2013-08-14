<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Usuarios extends CI_Controller {


		var $titulo = "Rodrigo Transportes - AdminSystem";

		/***
		* método construtor
		*
		*
		*
		******/
		function __construct()
		{

			parent::__construct();

			if (!$this->session->userdata('session_id') || !$this->session->userdata('logado'))
				redirect(base_url());
			
			$this->load->model('admin/conteudo_model');

			$this->load->model('admin/usuarios_model');

		}


		/***
		*
		*
		*
		*
		******/
		public function index($msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']     = $this->titulo;
			$dados['css_pagina'] = 'menu.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['msg']        = $msg;

			$dados['usuarios'  ] = $this->usuarios_model->listarUsuarios();


			
			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/usuarios_home');
			$this->load->view('admin/elementos/rodape');

		}


		/***
		*
		*
		*
		*
		******/
		public function inserir()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'Nome', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_usuario', 'Usuário', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_email', 'E-mail', 'required|valid_email');

			$this->form_validation->set_rules('str_password', 'Senha', 'required|matches[str_password_confirma]');
			$this->form_validation->set_rules('str_password_confirma', 'Confirme a Senha', 'required');


			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('matches', 'O campo %s não é igual a confirmação.');
			$this->form_validation->set_message('valid_email', 'O campo %s deve conter um e-mail válido.');

			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 100 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->index('nao_validou');

			} else {

				$existe_usuario = $this->usuarios_model->existeUsuario($this->input->post('str_usuario'));
				$existe_email   = $this->usuarios_model->existeEmail($this->input->post('str_email'));				

				if($existe_usuario){

					$this->index('existe_usuario');

				} elseif ($existe_email) {

					$this->index('existe_email');

				} else {

					$dados['str_nome']    = $this->input->post('str_nome');
					$dados['str_usuario'] = $this->input->post('str_usuario');
					$dados['str_email']   = $this->input->post('str_email');
					$dados['str_senha']   = sha1($this->input->post('str_password'));
					$dados['int_ativo']   = $this->input->post('int_ativo');

					# CADASTRAR
					$inserir           		  = $this->usuarios_model->inserir($dados);

					if($inserir)
						redirect(base_url() . 'admin/usuarios/index/ok');
					else
						redirect(base_url() . 'admin/usuarios/index/erro');

				}	


			} 

		}


		/***
		*
		*
		*
		*
		******/
		public function editar($id, $msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']     = $this->titulo;
			$dados['css_pagina'] = 'menu.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['msg']        = $msg;

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['usuarios']   = $this->usuarios_model->listarUsuarios($id);

			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/usuarios_editar');
			$this->load->view('admin/elementos/rodape');		

		}


		/***
		*
		*
		*
		*
		******/
		public function gravar()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'Nome', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_usuario', 'Usuário', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_email', 'E-mail', 'required|valid_email');

			$this->form_validation->set_rules('str_password', 'Senha', 'matches[str_password_confirma]');
			$this->form_validation->set_rules('str_password_confirma', 'Confirme a Senha', '');

			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('matches', 'O campo %s não é igual a confirmação.');
			$this->form_validation->set_message('valid_email', 'O campo %s deve conter um e-mail válido.');

			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 100 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->editar($this->input->post('id'), 'nao_validou');

			} else {

				$usuario_atual = $this->input->post('usuario_atual');
				$email_atual   = $this->input->post('email_atual');

				$existe_usuario = $this->usuarios_model->existeUsuario($this->input->post('str_usuario'));
				$existe_email   = $this->usuarios_model->existeEmail($this->input->post('str_email'));




				if($existe_usuario[0]->str_usuario == $usuario_atual)
					redirect(base_url() . 'admin/usuarios/editar/' . $this->input->post('id') . '/existe_usuario');

				if($existe_email[0]->str_email == $email_atual)
					redirect(base_url() . 'admin/usuarios/editar/' . $this->input->post('id') . '/existe_email');
				
				$dados['id']          = $this->input->post('id');
				$dados['str_nome']    = $this->input->post('str_nome');
				$dados['str_usuario'] = $this->input->post('str_usuario');
				$dados['str_email']   = $this->input->post('str_email');

				if($this->input->post('str_password') > 0)
					$dados['str_senha']   = sha1($this->input->post('str_password'));	
				
				$dados['int_ativo']   = $this->input->post('int_ativo');

				# GRAVAR
				$gravar               = $this->usuarios_model->gravar($dados);

				if ($gravar)
					redirect(base_url() . 'admin/usuarios/index/ok');
				else
					redirect(base_url() . 'admin/usuarios/index/erro');


			} 

		}


		/***
		*
		*
		*
		*
		******/
		public function excluir($id)
		{

			$excluir = $this->usuarios_model->excluir($id);

			if($excluir)
				redirect(base_url() . 'admin/usuarios/index/excluido');
			else
				redirect(base_url() . 'admin/usuarios/index/erro');

		}


		/***
		*
		*
		*
		*
		******/
		public function status()
		{

			$res = $this->usuarios_model->listarUsuarios($this->input->post('id'));

			if($res[0]->int_ativo == '1'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->usuarios_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_ativo == '0'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->usuarios_model->gravar($dados);

				echo 'ativo';			
			}

		}		


	}