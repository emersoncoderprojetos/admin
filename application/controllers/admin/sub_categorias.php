<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Sub_categorias extends CI_Controller {


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
			
			$this->load->model('clicserver/conteudo_model');
			$this->load->model('clicserver/sub_categorias_model');
			$this->load->model('clicserver/categorias_model');

			$this->load->helper('slug_helper');

		}


		/***
		* carrega página inicial
		*
		*
		*
		******/
		public function index($msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']         = 'Sub-Categorias - Clicserver';
			$dados['css_pagina']     = 'conteudo.css';
			$dados['dados_menu']     = $this->conteudo_model->listarConteudo();
			$dados['categorias']     = $this->categorias_model->listarCategorias();
			$dados['sub_categorias'] = $this->sub_categorias_model->listarSubCategorias();
			$dados['msg']            = $msg;
			
			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/sub_categorias_home');
			$this->load->view('clicserver/elementos/rodape');

		}


		/***
		* insere
		*
		*
		*
		******/
		public function inserir()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'sub_categorias', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('id_categoria', 'Categoria', 'required');
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

					$dados['str_nome']        = $this->input->post('str_nome');
					$dados['id_categoria']    = $this->input->post('id_categoria');
					$dados['str_slug']        = sanitize_title_with_dashes($this->input->post('str_slug'));

					$dados['str_title']       = $this->input->post('str_title');
					$dados['str_keywords']    = $this->input->post('str_keywords');
					$dados['str_description'] = $this->input->post('str_description');

					$dados['int_ativo']       = $this->input->post('int_ativo');
					$dados['int_destaque']    = $this->input->post('int_destaque');

					# CADASTRAR
					$inserir           = $this->sub_categorias_model->inserir($dados);

					if($inserir)
						redirect(base_url() . 'clicserver/sub_categorias/index/ok');
					else
						redirect(base_url() . 'clicserver/sub_categorias/index/erro');

				}

			}

		}


		/***
		* carrega página de edição
		*
		*
		*
		******/
		public function editar($id, $msg = null)
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']         = 'Sub-Categorias - Clicserver';
			$dados['css_pagina']     = 'conteudo.css';
			$dados['dados_menu']     = $this->conteudo_model->listarConteudo();

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['sub_categorias'] = $this->sub_categorias_model->listarSubCategorias($id);
			$dados['categorias']     = $this->categorias_model->listarCategorias();
			$dados['msg']            = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/sub_categorias_editar');
			$this->load->view('clicserver/elementos/rodape');		

		}


		/***
		* grava dados
		*
		*
		*
		******/
		public function gravar()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'sub_categorias', 'required|min_length[3]|max_length[100]');

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
					$dados['id_categoria']    = $this->input->post('id_categoria');
					$dados['str_nome']    	  = $this->input->post('str_nome');
					$dados['str_slug']        = sanitize_title_with_dashes($this->input->post('str_slug'));
					$dados['str_title']       = $this->input->post('str_title');
					$dados['str_keywords']    = $this->input->post('str_keywords');
					$dados['str_description'] = $this->input->post('str_description');
					$dados['int_ativo']  	  = $this->input->post('int_ativo');
					$dados['int_destaque']    = $this->input->post('int_destaque');

					$gravar                   = $this->sub_categorias_model->gravar($dados);

					if($gravar)
						redirect(base_url() . 'clicserver/sub_categorias/index/ok');
					else
						redirect(base_url() . 'clicserver/sub_categorias/index/erro');

				}

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

			$excluir = $this->sub_categorias_model->excluir($id);

			if($excluir)
				redirect(base_url() . 'clicserver/sub_categorias/index/excluido');
			else
				redirect(base_url() . 'clicserver/sub_categorias/index/erro');

		}


		/***
		*
		*
		*
		*
		******/
		public function status()
		{

			$res = $this->sub_categorias_model->listarSubCategorias($this->input->post('id'));

			if ($res[0]->int_ativo == '1') {

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->sub_categorias_model->gravar($dados);

				echo 'desativado';

			}

			else if ($res[0]->int_ativo == '0') {

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->sub_categorias_model->gravar($dados);

				echo 'ativo';			
			}

		}


		/***
		*
		*
		*
		*
		******/
		public function destaque()
		{

			$res = $this->sub_categorias_model->listarSubCategorias($this->input->post('id'));

			if ($res[0]->int_destaque == '1') {

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '0';

				$this->sub_categorias_model->gravar($dados);

				echo 'desativado';

			}

			else if ($res[0]->int_destaque == '0') {

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '1';

				$this->sub_categorias_model->gravar($dados);

				echo 'ativo';			
			}

		}


		/***
		*
		*
		*
		*
		******/
		function existe_slug()
		{

			$slug        = sanitize_title_with_dashes($this->input->post('slug'));

			$existe_slug = $this->sub_categorias_model->checaSlug($slug);

			if ($existe_slug)
				echo 'sim';
			else
				echo sanitize_title_with_dashes($this->input->post('slug'));

		}

	}