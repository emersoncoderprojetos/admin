<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Capas_home extends CI_Controller {


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
			$this->load->model('clicserver/capas_home_model');

		}


		/***
		* carrega a view
		*
		*
		*
		******/
		public function index($msg = NULL)
		{	

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']     = 'Capas Home - Clicserver';
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['capas']      = $this->capas_home_model->listarCapas();		
			$dados['msg']        = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/capas_home');
			$this->load->view('clicserver/elementos/rodape');

		}


		/***
		* carrega a view
		*
		*
		*
		******/
		public function ordem($msg = NULL)
		{	

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']     = 'Ordem Capas - Clicserver';
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['capas']      = $this->capas_home_model->listarOrdemCapas();		
			$dados['msg']        = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/capas_ordem_home');
			$this->load->view('clicserver/elementos/rodape');

		}


		/***
		* ordem das capas
		* 
		*
		*
		******/
		function recebe_ordem()
		{

			foreach($this->input->post('sort') as $position => $item){

				echo 'posicao: ' . $position . ' - item:' . $item.br();

				$dados['id']        = $item;
				$dados['int_ordem'] = $position;

				$this->capas_home_model->gravar($dados);

			}

			echo $this->db->last_query();

		}


		/***
		*
		* 
		*
		*
		******/
		public function status()
		{

			$res = $this->capas_home_model->listarCapas($this->input->post('id'));

			if($res[0]->int_ativo == '1'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->capas_home_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_ativo == '0'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->capas_home_model->gravar($dados);

				echo 'ativo';			
			}

		}	

		

		/***
		* INSERE NOVA CAPA NA PÁGINA HOME
		* @cria thumb
		* @medidas da imagem : não definido
		*
		******/
		public function inserir()
		{

			if ($_FILES) {

				$config['upload_path']   = './capas_slider_home/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name']  = TRUE;
				$config['max_size']  	 = NULL;
				$config['max_width']     = '';
				$config['max_height']    = '';
				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){

					$this->index();

				} else {

					#PEGO AS INFORMAÇÕES DA CLASSE UPLOAD E ATRIBUO O NOME A VÁRIAVEL
					$arquivo_enviado         = $this->upload->data();
					$imagem                  = $arquivo_enviado['file_name'];

					#REDIMENSIONO IMAGEM NORMAL
					$thumb['image_library']  = 'GD2';
					$thumb['source_image']   = 'capas_slider_home/' . $imagem;
					$thumb['new_image']      = 'capas_slider_home/';
					$thumb['maintain_ratio'] = FALSE;
					// falta definir tamanho
					$thumb['width']          = '1920';
					$thumb['height']         = '566';
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($thumb);
					$this->image_lib->resize();
					$this->image_lib->clear();

					#REDIMENSIONO IMAGEM THUMB
					$normal['image_library']  = 'GD2';
					$normal['source_image']   = 'capas_slider_home/' . $imagem;
					$normal['new_image']      = 'capas_slider_home/thumb/';					
					$normal['create_thumb']   = FALSE;
					$normal['maintain_ratio'] = TRUE;
					$normal['width']          = '150';
					$normal['height']         = '150';
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($normal);
					$this->image_lib->resize();
					$this->image_lib->clear();

					$dados['str_imagem']  = $imagem;
					$dados['str_url']     = $this->input->post('str_url');
					$dados['str_destino'] = $this->input->post('str_destino');
					$dados['int_ativo']   = $this->input->post('int_ativo');

					$inserir              = $this->capas_home_model->inserir($dados);

					redirect(base_url() . 'clicserver/capas_home/index/ok');

				}

			} else {

				$dados['str_url']     = $this->input->post('str_url');
				$dados['str_destino'] = $this->input->post('str_destino');
				$dados['int_ativo']   = $this->input->post('int_ativo');

				$inserir              = $this->capas_home_model->inserir($dados);

				redirect(base_url() . 'clicserver/capas_home/index/erro');

			}

		}



		/***
		* INSERE NOVA CAPA NA PÁGINA HOME
		* @cria thumb
		* @medidas da imagem : não definido
		*
		******/
		public function gravar()
		{

			if ($_FILES) {

				$config['upload_path']   = './capas_slider_home/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name']  = TRUE;
				$config['max_size']  	 = NULL;
				$config['max_width']     = '';
				$config['max_height']    = '';
				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){

					echo $this->upload->display_errors();

				} else {

					#PEGO AS INFORMAÇÕES DA CLASSE UPLOAD E ATRIBUO O NOME A VÁRIAVEL
					$arquivo_enviado         = $this->upload->data();
					$imagem                  = $arquivo_enviado['file_name'];

					#REDIMENSIONO IMAGEM NORMAL
					$thumb['image_library']  = 'GD2';
					$thumb['source_image']   = 'capas_slider_home/' . $imagem;
					$thumb['new_image']      = 'capas_slider_home/';
					$thumb['maintain_ratio'] = FALSE;
					// falta definir tamanho
					$thumb['width']          = '1920';
					$thumb['height']         = '566';
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($thumb);
					$this->image_lib->resize();
					$this->image_lib->clear();

					#REDIMENSIONO IMAGEM THUMB
					$normal['image_library']  = 'GD2';
					$normal['source_image']   = 'capas_slider_home/' . $imagem;
					$normal['new_image']      = 'capas_slider_home/thumb/';					
					$normal['create_thumb']   = FALSE;
					$normal['maintain_ratio'] = TRUE;
					$normal['width']          = '150';
					$normal['height']         = '150';
					$this->load->library('image_lib', $config);
					$this->image_lib->initialize($normal);
					$this->image_lib->resize();
					$this->image_lib->clear();


					$consulta_imagem = $this->capas_home_model->listarCapas($this->input->post('id'));

					if ($consulta_imagem[0]->str_imagem) {

						unlink(FCPATH . 'capas_slider_home/' . $consulta_imagem[0]->str_imagem);
						unlink(FCPATH . 'capas_slider_home/thumb/' . $consulta_imagem[0]->str_imagem);

						$dados['id']         = $id;
						$dados['str_imagem'] = '';

						$this->capas_home_model->gravar($dados);					

					}

					
					$dados['id']          = $this->input->post('id');

					$dados['str_imagem']  = $imagem;
					$dados['str_url']     = $this->input->post('str_url');
					$dados['str_destino'] = $this->input->post('str_destino');
					$dados['int_ativo']   = $this->input->post('int_ativo');

					$gravar               = $this->capas_home_model->gravar($dados);

					redirect(base_url() . 'clicserver/capas_home/index/ok');

				}

			} else {

				$dados['id']          = $this->input->post('id');			

				$dados['str_url']     = $this->input->post('str_url');
				$dados['str_destino'] = $this->input->post('str_destino');
				$dados['int_ativo']   = $this->input->post('int_ativo');

				$gravar               = $this->capas_home_model->gravar($dados);

				redirect(base_url() . 'clicserver/capas_home/index/ok');			

			}

		}



		/***
		* editar
		*
		*
		*
		******/
		public function editar($id, $msg = NULL)
		{	

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']     = 'Capas Home - Clicserver';
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['capas']      = $this->capas_home_model->listarCapas($id);
			$dados['msg']        = $msg;

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/capas_editar');
			$this->load->view('clicserver/elementos/rodape');

		}	


		/***
		*
		*
		*
		*
		******/
		function excluir($id)
		{

			$imagem = $this->capas_home_model->listarCapas($id);

			if ($imagem[0]->str_imagem) {
				unlink(FCPATH . 'capas_slider_home/' . $imagem[0]->str_imagem);
				unlink(FCPATH . 'capas_slider_home/thumb/' . $imagem[0]->str_imagem);
			}

			$this->capas_home_model->excluir($id);

			redirect(base_url() . 'clicserver/capas_home/index/excluido');

		}


		/***
		*
		*
		*
		*
		******/
		function excluir_imagem($id)
		{

			$imagem = $this->capas_home_model->listarCapas($id);

			if ($imagem[0]->str_imagem) {

				unlink(FCPATH . 'capas_slider_home/' . $imagem[0]->str_imagem);
				unlink(FCPATH . 'capas_slider_home/thumb/' . $imagem[0]->str_imagem);

			}

			$dados['id']         = $id;
			$dados['str_imagem'] = '';

			$this->capas_home_model->gravar($dados);

			redirect(base_url() . 'clicserver/capas_home/editar/' . $id . '');

		}

	}