<?php defined('BASEPATH') OR exit('No direct script access allowed');

	
	class Categorias extends CI_Controller {


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
			
			$this->load->model('clicserver/conteudo_model');
			$this->load->model('clicserver/categorias_model');

			$this->load->helper('slug_helper');

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
			$dados['titulo']     = 'Categorias - Clicserver';
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['categorias'] = $this->categorias_model->listarCategorias();
			$dados['msg']        = $msg;
			
			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/categorias_home');
			$this->load->view('clicserver/elementos/rodape');

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
			$this->form_validation->set_rules('str_nome', 'Categorias', 'required|min_length[3]|max_length[100]');
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

					$dados['str_nome']      = $this->input->post('str_nome');
					$dados['str_slug']        = sanitize_title_with_dashes($this->input->post('str_slug'));

					$dados['str_title']       = $this->input->post('str_title');
					$dados['str_keywords']    = $this->input->post('str_keywords');
					$dados['str_description'] = $this->input->post('str_description');

					$dados['str_hexa_box']    = $this->input->post('str_hexa_box');					

					$dados['int_ativo']       = $this->input->post('int_ativo');
					$dados['int_destaque']    = $this->input->post('int_destaque');

					# CADASTRAR
					$inserir           = $this->categorias_model->inserir($dados);

					if($inserir)
						redirect(base_url() . 'clicserver/categorias/index/ok');
					else
						redirect(base_url() . 'clicserver/categorias/index/erro');

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
			$dados['titulo']     = 'Tipo - Clicserver';
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['categorias'] = $this->categorias_model->listarCategorias($id);

			$dados['msg']        = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/categorias_editar');
			$this->load->view('clicserver/elementos/rodape');		

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
			$this->form_validation->set_rules('str_nome', 'Categorias', 'required|min_length[3]|max_length[100]');

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
						redirect(base_url() . 'clicserver/categorias/index/ok');
					else
						redirect(base_url() . 'clicserver/categorias/index/erro');

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

			$excluir = $this->categorias_model->excluir($id);

			if($excluir)
				redirect(base_url() . 'clicserver/categorias/index/excluido');
			else
				redirect(base_url() . 'clicserver/categorias/index/erro');

		}


		/***
		*
		*
		*
		*
		******/
		public function status_categorias()
		{

			$res = $this->categorias_model->listarCategorias($this->input->post('id'));

			if($res[0]->int_ativo == '1'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->categorias_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_ativo == '0'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->categorias_model->gravar($dados);

				echo 'ativo';			
			}

		}


		/***
		*
		*
		*
		*
		******/
		public function status_destaque()
		{

			$res = $this->categorias_model->listarCategorias($this->input->post('id'));

			if($res[0]->int_destaque == '1'){

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '0';

				$this->categorias_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_destaque == '0'){

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '1';

				$this->categorias_model->gravar($dados);

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

			$existe_slug = $this->categorias_model->checaSlug($slug);

			if($existe_slug)
				echo 'sim';
			else
				echo sanitize_title_with_dashes($this->input->post('slug'));


		}


	}