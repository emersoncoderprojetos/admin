<?php defined('BASEPATH') OR exit('No direct script access allowed');

	
	class Menus extends CI_Controller {


		var $titulo = "Rodrigo Transportes - AdminSystem";
		/***
		*
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

			$this->load->model('admin/menu_model');

			$this->load->helper('slug_helper');

			$this->load->helper('funcoes_helper');

		}


		/***
		* - formulário de criação do menu
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

			$dados['menus']      = $this->menu_model->listarMenu();
			
			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/menu_home');
			$this->load->view('admin/elementos/rodape');

		}


		/***
		* - formulário de criação de sub-menu
		*
		*
		*
		******/
		public function submenus($msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']     = $this->titulo;
			$dados['css_pagina'] = 'menu.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['msg']        = $msg;

			$dados['menu']       = $this->menu_model->listarMenu();
			$dados['submenu']    = $this->menu_model->listarSubMenu();
			
			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/sub_menu_home');
			$this->load->view('admin/elementos/rodape');

		}		


		/***
		* cadastro de menu
		*
		*
		*
		******/
		public function inserir_menu()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'Menu', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('str_slug', 'Slug', 'required');

			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 100 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->index('nao_validou');

			} else {

				if ($this->input->post('confirma_slug') == 1) {

					$this->index('nao_validou_slug');					

				} else {

					$dados['str_nome']  = $this->input->post('str_nome');
					$dados['str_slug']  = sanitize_title_with_dashes($this->input->post('str_slug'));

					$dados['int_ativo'] = $this->input->post('int_ativo');

					# CADASTRAR
					$inserir            = $this->menu_model->inserirMenu($dados);

					if($inserir)
						redirect(base_url() . 'admin/menus/index/ok');
					else
						redirect(base_url() . 'admin/menus/index/erro');

				}

			}

		}


		/***
		*
		*
		*
		*
		******/
		public function inserir_submenu()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('id_menu', 'Menu', 'required');
			$this->form_validation->set_rules('str_nome', 'Sub-Menu', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('str_slug', 'Slug', 'required');

			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 100 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->submenus('nao_validou');

			} else {

				if ($this->input->post('confirma_slug') == 1) {

					$this->index('nao_validou_slug');					

				} else {

					$dados['id_menu']   = $this->input->post('id_menu');
					$dados['str_nome']  = $this->input->post('str_nome');
					$dados['str_slug']  = sanitize_title_with_dashes($this->input->post('str_slug'));
					$dados['int_ativo'] = $this->input->post('int_ativo');

					# CADASTRAR
					$inserir_sub_menu   = $this->menu_model->inserirSubMenu($dados);

					if($inserir_sub_menu)
						redirect(base_url() . 'admin/menus/submenus/ok');
					else
						redirect(base_url() . 'admin/menus/submenus/erro');

				}

			}

		}


		/***
		* editar menu
		*
		*
		*
		******/
		public function editar_menu($id, $msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']     = $this->titulo;
			$dados['css_pagina'] = 'menu.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['msg']        = $msg;

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['menu']       = $this->menu_model->listarMenu($id);

			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/menu_editar');
			$this->load->view('admin/elementos/rodape');		

		}


		/***
		* editar menu
		*
		*
		*
		******/
		public function editar($id, $msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']     = 'Tipo - admin';
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['categorias'] = $this->categorias_model->listarCategorias($id);

			$dados['msg']        = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/categorias_editar');
			$this->load->view('admin/elementos/rodape');		

		}



		/***
		*
		*
		*
		*
		******/
		public function gravar_menu()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'Menu', 'required|min_length[3]|max_length[100]');

			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 100 caracteres para o campo %s obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->editar_menu($this->input->post('id'));

			} else {


				if ($this->input->post('confirma_slug') == 1) {

					# NÃO VALIDOU ENTÃO
					$this->editar_menu($this->input->post('id'), 'nao_validou_slug');					

				} else {

					$dados['id']         	  = $this->input->post('id');
					$dados['str_nome'] 	      = $this->input->post('str_nome');
					$dados['str_slug']        = sanitize_title_with_dashes($this->input->post('str_slug'));
					$dados['int_ativo']  	  = $this->input->post('int_ativo');

					$gravar_menu              = $this->menu_model->gravarMenu($dados);

					if($gravar_menu)
						redirect(base_url() . 'admin/menus/index/ok');
					else						redirect(base_url() . 'admin/menus/index/erro');



				}

			}

		}



		/***
		*
		*
		*
		*
		******/
		public function gravar_sub_menu()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('id_menu', 'Menu', 'required');
			$this->form_validation->set_rules('str', 'Categorias', 'required|min_length[3]|max_length[100]');


			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 100 caracteres para o campo %s obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->editar($this->input->post('id'));

			} else {

				if ($this->input->post('confirma_slug') == 1) {

					$this->editar($this->input->post('id'), 'nao_validou_slug');					

				} else {

					$dados['id']         	  = $this->input->post('id');
					$dados['str_nome'] 	      = $this->input->post('str_nome');

					$dados['str_slug']        = sanitize_title_with_dashes($this->input->post('str_slug'));

					$dados['str_title']       = $this->input->post('str_title');
					$dados['str_keywords']    = $this->input->post('str_keywords');
					$dados['str_description'] = $this->input->post('str_description');

					$dados['str_hexa_box']    = $this->input->post('str_hexa_box');

					$dados['int_ativo']  	  = $this->input->post('int_ativo');
					$dados['int_destaque']    = $this->input->post('int_destaque');

					$gravar                   = $this->categorias_model->gravar($dados);

					if($gravar)
						redirect(base_url() . 'admin/categorias/index/ok');
					else
						redirect(base_url() . 'admin/categorias/index/erro');

				}

			}

		}


		/***
		* excluir menu
		*
		*
		*
		******/
		public function excluir_menu($id)
		{

			$excluir = $this->menu_model->excluirMenu($id);

			if($excluir)
				redirect(base_url() . 'admin/menus/index/excluido');
			else
				redirect(base_url() . 'admin/menus/index/erro');

		}



		/***
		*
		*
		*
		*
		******/
		public function excluir($id)
		{

			$excluir = $this->categorias_model->excluir($id);

			if($excluir)
				redirect(base_url() . 'admin/categorias/index/excluido');
			else
				redirect(base_url() . 'admin/categorias/index/erro');

		}		


		/***
		*
		*
		*
		*
		******/
		public function status()
		{

			$res = $this->menu_model->listarMenu($this->input->post('id'));

			if($res[0]->int_ativo == '1'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->menu_model->gravarMenu($dados);

				echo 'desativado';

			}

			else if($res[0]->int_ativo == '0'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->menu_model->gravarMenu($dados);

				echo 'ativo';			
			}

		}


		/***
		* verifica se existe slug
		*
		*
		*
		******/
		function existe_slug()
		{

			$slug        = sanitize_title_with_dashes($this->input->post('slug'));

			$existe_slug = $this->menu_model->checaSlug($slug);

			if($existe_slug) { 
				
				if($existe_slug[0]->str_slug)
					echo 'sim';

			} else {

				echo sanitize_title_with_dashes($this->input->post('slug'));
					
			}


		}


		/***
		* traz os dados do slug
		*
		*
		*
		******/
		function dados_slug()
		{

			$slug        = sanitize_title_with_dashes($this->input->post('slug'));

			$existe_slug = $this->menu_model->checaSlug($slug);

			if($existe_slug) { 
				
				if ($existe_slug[0]->str_slug)
					echo $existe_slug[0]->str_slug;

			} else {

				echo 'nao';
					
			}


		}		


		/***
		* cria slug
		*
		*
		*
		******/
		function cria_slug()
		{

			echo sanitize_title_with_dashes($this->input->post('slug'));

		}	


	}