<?php defined('BASEPATH') OR exit('No direct script access allowed');

	
	class Conteudo extends CI_Controller {


		var $titulo = 'Rodrigo Transportes - ADMINSYSTEM';


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

		}


		/***
		*
		*
		*
		*
		******/
		public function index()
		{

			#CARREGANDO INFORMAÇẼS
			$dados['titulo']           = $this->titulo;
			$dados['css_pagina']       = 'menu.css';
			$dados['dados_menu']       = $this->conteudo_model->listarConteudo();

			$dados['total_conteudo']   = count($this->conteudo_model->listarConteudo());

			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/conteudo_home');
			$this->load->view('admin/elementos/rodape');

		}


		/***
		*
		*
		*
		*
		******/
		public function editar($id, $msg = null)
		{

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']         = $this->titulo;
			$dados['css_pagina']     = 'conteudo.css';

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['dados_menu']     = $this->conteudo_model->listarConteudo();
			$dados['conteudo']       = $this->conteudo_model->listarConteudo($id);
			$dados['msg']            = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('admin/elementos/topo', $dados);
			$this->load->view('admin/conteudo_editar');
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

			$dados_conteudo['id']              = $this->input->post('id');
			$dados_conteudo['str_title']       = $this->input->post('str_title');
			$dados_conteudo['str_keywords']    = $this->input->post('str_keywords');
			$dados_conteudo['str_description'] = $this->input->post('str_description');
			$dados_conteudo['str_titulo']      = $this->input->post('str_titulo');
			$dados_conteudo['txt_texto']    = $this->input->post('txt_texto');

			$gravar                            = $this->conteudo_model->gravar($dados_conteudo);

				if($gravar)
					redirect(base_url() . 'admin/conteudo/editar/'. $this->input->post('id') . '/ok');
				else
					redirect(base_url() . 'admin/conteudo/editar/'. $this->input->post('id') . '/erro');
			

		}	


	}