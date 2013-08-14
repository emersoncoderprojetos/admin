<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Noticias extends CI_Controller {


		var $titulo = 'Notícias - ClicServer';


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

			$this->load->model('clicserver/noticias_model');
			$this->load->model('clicserver/conteudo_model');

			$this->load->helper('slug_helper');
			$this->load->helper('funcoes_helper');

		}


		/***
		*
		*
		*
		*
		******/
		public function index($msg = '')
		{	

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']     = $this->titulo;
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['msg']        = $msg;
			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['noticias']  = $this->noticias_model->listarNoticias();

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/noticias_home');
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
			$this->form_validation->set_rules('str_titulo', 'Título', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_slug', 'SLUG', 'required');
			$this->form_validation->set_rules('txt_descricao', 'Descrição', 'required');
			$this->form_validation->set_rules('date_data_noticia', 'Data', 'required');
			
			# MENSAGENS DE VALIDAÇÃO DO FORMUÁRIO
			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 200 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU
				$this->index('nao_validou');

			} else {

				$str_slug = sanitize_title_with_dashes($this->input->post('str_slug'));

				$existe_slug = $this->noticias_model->existeSlug($str_slug);

				if ($existe_slug) {
					
					$this->index('existe_slug');					

				} else {

					if ($_FILES) {

				    	$config['upload_path']   = './noticias_imagem/';
			            $config['allowed_types'] = 'gif|jpg|jpeg|png';
			            $config['max_size']      = NULL;
			            $config['max_width']     = NULL;
			            $config['max_height']    = NULL;
			            $config['encrypt_name']  = TRUE;
			            $this->load->library('upload');

			            foreach ($_FILES as $key => $value) {

		                    $this->upload->initialize($config);
							$this->upload->do_upload($key);

							# PEGO O NOME DE CADA IMAGEM
							$arquivo_enviado         = $this->upload->data();
							$imagem                  = $arquivo_enviado['file_name'];

							# REDIMENSIONO IMAGEM NORMAL
							$thumb['image_library']  = 'GD2';
							$thumb['source_image']   = 'noticias_imagem/' . $imagem;
							$thumb['new_image']      = 'noticias_imagem/';
							$thumb['maintain_ratio'] = TRUE;
							$thumb['width']          = '900';
							$thumb['height']         = '600';
							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($thumb);
							$this->image_lib->resize();
							$this->image_lib->clear();

							# REDIMENSIONO IMAGEM THUMB
							$normal['image_library']  = 'GD2';
							$normal['source_image']   = 'noticias_imagem/' . $imagem;
							$normal['new_image']      = 'noticias_imagem/thumb/';					
							$normal['create_thumb']   = FALSE;
							$normal['maintain_ratio']  = TRUE;
							$normal['width']           = '390';
							$normal['height']          = '275';
							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($normal);
							$this->image_lib->resize();
							$this->image_lib->clear();

			            }

						$dados['str_titulo']        = $this->input->post('str_titulo');
						$dados['str_slug']          = sanitize_title_with_dashes($this->input->post('str_slug'));
						$dados['date_data_noticia'] = data_br_to_us($this->input->post('date_data_noticia'));
						$dados['txt_descricao']     = $this->input->post('txt_descricao');
						$dados['int_ativo']         = $this->input->post('int_ativo');
						$dados['int_destaque']      = $this->input->post('int_destaque');
						$dados['str_imagem']        = $imagem;
						$inserir 		            = $this->noticias_model->inserir($dados);

			            redirect(base_url() . 'clicserver/noticias/index/ok');

			        } else {

						$dados['str_titulo']    = $this->input->post('str_titulo');
						$dados['str_slug']      = sanitize_title_with_dashes($this->input->post('str_slug'));
						$dados['txt_descricao'] = $this->input->post('txt_descricao');
						$dados['date_data_noticia'] = data_br_to_us($this->input->post('date_data_noticia'));					
						$dados['int_ativo']     = $this->input->post('int_ativo');
						$dados['int_destaque']  = $this->input->post('int_destaque');

						$inserir 		        = $this->noticias_model->inserir($dados);

			            redirect(base_url() . 'clicserver/noticias/index/ok');

			        }

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

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']     = $this->titulo;
			$dados['css_pagina'] = 'conteudo.css';
			$dados['dados_menu'] = $this->conteudo_model->listarConteudo();
			$dados['msg']        = $msg;

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['noticias']   = $this->noticias_model->listarNoticias($id);

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/noticias_editar');
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
			$this->form_validation->set_rules('str_titulo', 'Título', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_slug', 'SLUG', 'required');
			$this->form_validation->set_rules('txt_descricao', 'Descrição', 'required');
			$this->form_validation->set_rules('date_data_noticia', 'Data', 'required');
			
			# MENSAGENS DE VALIDAÇÃO DO FORMUÁRIO
			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 200 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU ENTÃO
				$this->editar($this->input->post('id'));

			} else {

				$str_slug = $this->noticias_model->listarNoticias($this->input->post('id'));

				if ($str_slug[0]->str_slug != $this->input->post('str_slug')) {

					$str_slug = sanitize_title_with_dashes($this->input->post('str_slug'));

					$existe_slug = $this->noticias_model->existeSlug($str_slug);

					if($existe_slug){

						$this->editar($this->input->post('id'), 'existe_slug');

					} else {

						if ($_FILES) {

					    	$config['upload_path']   = './noticias_imagem/';
				            $config['allowed_types'] = 'gif|jpg|jpeg|png';
				            $config['max_size']      = NULL;
				            $config['max_width']     = NULL;
				            $config['max_height']    = NULL;
				            $config['encrypt_name']  = TRUE;
				            $this->load->library('upload');

				            foreach ($_FILES as $key => $value) {

			                    $this->upload->initialize($config);
								$this->upload->do_upload($key);

								# PEGO O NOME DE CADA IMAGEM
								$arquivo_enviado         = $this->upload->data();
								$imagem                  = $arquivo_enviado['file_name'];

								# REDIMENSIONO IMAGEM NORMAL
								$thumb['image_library']  = 'GD2';
								$thumb['source_image']   = 'noticias_imagem/' . $imagem;
								$thumb['new_image']      = 'noticias_imagem/';
								$thumb['maintain_ratio'] = TRUE;
								$thumb['width']          = '900';
								$thumb['height']         = '600';
								$this->load->library('image_lib', $config);
								$this->image_lib->initialize($thumb);
								$this->image_lib->resize();
								$this->image_lib->clear();

								# REDIMENSIONO IMAGEM THUMB
								$normal['image_library']  = 'GD2';
								$normal['source_image']   = 'noticias_imagem/' . $imagem;
								$normal['new_image']      = 'noticias_imagem/thumb/';					
								$normal['create_thumb']   = FALSE;
								$normal['maintain_ratio']  = TRUE;
								$normal['width']           = '390';
								$normal['height']          = '275';
								$this->load->library('image_lib', $config);
								$this->image_lib->initialize($normal);
								$this->image_lib->resize();
								$this->image_lib->clear();

				            }

				            $consulta_imagem = $this->noticias_model->listarNoticias($this->input->post('id'));

				            if ($consulta_imagem[0]->str_imagem) {

								unlink(FCPATH . 'noticias_imagem/' . $consulta_imagem[0]->str_imagem);
								unlink(FCPATH . 'noticias_imagem/thumb/' . $consulta_imagem[0]->str_imagem);

								$dados_imagem['id']         = $this->input->post('id');
								$dados_imagem['str_imagem'] = '';

								$this->noticias_model->gravar($dados_imagem);

				            }

				            $dados['id']	            = $this->input->post('id');
							$dados['str_titulo']        = $this->input->post('str_titulo');
							$dados['str_slug']          = sanitize_title_with_dashes($this->input->post('str_slug'));
							$dados['date_data_noticia'] = data_br_to_us($this->input->post('date_data_noticia'));
							$dados['txt_descricao']     = $this->input->post('txt_descricao');
							$dados['int_ativo']         = $this->input->post('int_ativo');
							$dados['int_destaque']      = $this->input->post('int_destaque');
							$dados['str_imagem']        = $imagem;

							$inserir 		            = $this->noticias_model->gravar($dados);

				            redirect(base_url() . 'clicserver/noticias/index/ok');

				        } else {

							$dados['id']	            = $this->input->post('id');			        	
							$dados['str_titulo']        = $this->input->post('str_titulo');
							$dados['str_slug']          = sanitize_title_with_dashes($this->input->post('str_slug'));
							$dados['date_data_noticia'] = data_br_to_us($this->input->post('date_data_noticia'));
							$dados['txt_descricao']     = $this->input->post('txt_descricao');
							$dados['int_ativo']         = $this->input->post('int_ativo');
							$dados['int_destaque']      = $this->input->post('int_destaque');

							$inserir 		            = $this->noticias_model->gravar($dados);

				            redirect(base_url() . 'clicserver/noticias/index/ok');

				        }

				    }

				} else {

					if ($_FILES) {

				    	$config['upload_path']   = './noticias_imagem/';
			            $config['allowed_types'] = 'gif|jpg|jpeg|png';
			            $config['max_size']      = NULL;
			            $config['max_width']     = NULL;
			            $config['max_height']    = NULL;
			            $config['encrypt_name']  = TRUE;
			            $this->load->library('upload');

			            foreach ($_FILES as $key => $value) {

		                    $this->upload->initialize($config);
							$this->upload->do_upload($key);

							# PEGO O NOME DE CADA IMAGEM
							$arquivo_enviado         = $this->upload->data();
							$imagem                  = $arquivo_enviado['file_name'];

							# REDIMENSIONO IMAGEM NORMAL
							$thumb['image_library']  = 'GD2';
							$thumb['source_image']   = 'noticias_imagem/' . $imagem;
							$thumb['new_image']      = 'noticias_imagem/';
							$thumb['maintain_ratio'] = TRUE;
							$thumb['width']          = '900';
							$thumb['height']         = '600';
							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($thumb);
							$this->image_lib->resize();
							$this->image_lib->clear();

							# REDIMENSIONO IMAGEM THUMB
							$normal['image_library']  = 'GD2';
							$normal['source_image']   = 'noticias_imagem/' . $imagem;
							$normal['new_image']      = 'noticias_imagem/thumb/';					
							$normal['create_thumb']   = FALSE;
							$normal['maintain_ratio']  = TRUE;
							$normal['width']           = '390';
							$normal['height']          = '275';
							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($normal);
							$this->image_lib->resize();
							$this->image_lib->clear();

			            }

			            $consulta_imagem = $this->noticias_model->listarNoticias($this->input->post('id'));

			            if ($consulta_imagem[0]->str_imagem) {

							unlink(FCPATH . 'noticias_imagem/' . $consulta_imagem[0]->str_imagem);
							unlink(FCPATH . 'noticias_imagem/thumb/' . $consulta_imagem[0]->str_imagem);

							$dados_imagem['id']         = $this->input->post('id');
							$dados_imagem['str_imagem'] = '';

							$this->noticias_model->gravar($dados_imagem);

			            }

			            $dados['id']	        = $this->input->post('id');
						$dados['str_titulo']    = $this->input->post('str_titulo');
						$dados['str_slug']      = sanitize_title_with_dashes($this->input->post('str_slug'));
						$dados['date_data_noticia'] = data_br_to_us($this->input->post('date_data_noticia'));
						$dados['txt_descricao'] = $this->input->post('txt_descricao');
						$dados['int_ativo']     = $this->input->post('int_ativo');
						$dados['int_destaque']  = $this->input->post('int_destaque');
						$dados['str_imagem']    = $imagem;

						$gravar 		        = $this->noticias_model->gravar($dados);

			            redirect(base_url() . 'clicserver/noticias/index/ok');

			        } else {

			        	$dados['id']	        = $this->input->post('id');

						$dados['str_titulo']    = $this->input->post('str_titulo');
						$dados['str_slug']      = sanitize_title_with_dashes($this->input->post('str_slug'));
						$dados['date_data_noticia'] = data_br_to_us($this->input->post('date_data_noticia'));					
						$dados['txt_descricao'] = $this->input->post('txt_descricao');
						$dados['int_ativo']     = $this->input->post('int_ativo');
						$dados['int_destaque']  = $this->input->post('int_destaque');

						$gravar 		        = $this->noticias_model->gravar($dados);

			            redirect(base_url() . 'clicserver/noticias/index/ok');

			        }

			    }

			}

		}


		function excluir($id)
		{

			$imagem = $this->noticias_model->listarNoticias($id);

			if ($imagem[0]->str_imagem) {

				unlink(FCPATH . 'noticias_imagem/' . $imagem[0]->str_imagem);
				unlink(FCPATH . 'noticias_imagem/thumb/' . $imagem[0]->str_imagem);

			}

			$this->noticias_model->excluir($id);


			$this->index('excluido_sucesso');

		}	

		function excluir_imagem($id)
		{

			$imagem = $this->noticias_model->listarNoticias($id);

				unlink(FCPATH . 'noticias_imagem/' . $imagem[0]->str_imagem);
				unlink(FCPATH . 'noticias_imagem/thumb/' . $imagem[0]->str_imagem);

			$dados_imagem['id']         = $id;
			$dados_imagem['str_imagem'] = '';

			$this->noticias_model->gravar($dados_imagem);

			redirect(base_url() . 'clicserver/noticias/editar/' . $id);

		}


		public function status()
		{

			$res = $this->noticias_model->listarNoticias($this->input->post('id'));

			if ($res[0]->int_ativo == '1') {

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->noticias_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_ativo == '0'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->noticias_model->gravar($dados);

				echo 'ativo';			

			}

		}


		public function destaque()
		{

			$res = $this->noticias_model->listarNoticias($this->input->post('id'));

			if ($res[0]->int_destaque == '1') {

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '0';

				$this->noticias_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_destaque == '0'){

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '1';

				$this->noticias_model->gravar($dados);

				echo 'ativo';			

			}

		}


		public function slug()
		{

			$str_slug    = sanitize_title_with_dashes($this->input->post('titulo'));

			$existe_slug = $this->noticias_model->existeSlug($str_slug);

			if($existe_slug)
				echo 'sim';
			else
				echo sanitize_title_with_dashes($this->input->post('titulo'));

		}


	}