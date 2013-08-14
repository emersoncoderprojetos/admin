<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Produtos extends CI_Controller {


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
			$this->load->model('clicserver/categorias_model');
			$this->load->model('clicserver/sub_categorias_model');
			$this->load->model('clicserver/produtos_model');

			$this->load->helper('slug_helper');

		}


		/***
		* carrega página inicial
		*
		*
		*
		******/
		public function index($msg = '')
		{	

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']         = 'Produtos - Clicserver';
			$dados['css_pagina']     = 'conteudo.css';
			$dados['dados_menu']     = $this->conteudo_model->listarConteudo();
			$dados['msg']            = $msg;

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['categorias']     = $this->categorias_model->listarCategorias();
			$dados['sub_categorias'] = $this->sub_categorias_model->listarSubCategorias();
	 		$dados['produtos']       = $this->produtos_model->listarProdutos();

			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/produtos_home');
			$this->load->view('clicserver/elementos/rodape');

		}



		/***
		* insere novo produto
		*
		*
		*
		******/
		public function inserir()
		{

			# INICIO | VALIDAÇÃO DO FORMULÁRIO
			$this->form_validation->set_rules('str_nome', 'Nome', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_slug', 'Slug', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('txt_descricao', 'Descrição', 'required');
			$this->form_validation->set_rules('id_categoria', 'Escolha a Categoria', 'required');
			$this->form_validation->set_rules('id_sub_categoria', 'Escolha a Sub-Categoria', 'required');
			
			# MENSAGENS DE VALIDAÇÃO DO FORMUÁRIO
			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 200 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU
				$this->index('nao_validou');

			} else {

				if ($this->input->post('confirma_slug') == 1) {

					$this->index('nao_validou_slug');

				} else {

					if ($_FILES) {

						$dados_produtos['id_categoria']       = $this->input->post('id_categoria');
						$dados_produtos['id_sub_categoria']   = $this->input->post('id_sub_categoria');
						$dados_produtos['id_responsavel']     = $this->session->userdata('id_usuario');

						$dados_produtos['str_nome']           = $this->input->post('str_nome');
						$dados_produtos['txt_descricao']    = $this->input->post('txt_descricao');

						$dados_produtos['str_title']          = $this->input->post('str_title');
						$dados_produtos['str_keywords']       = $this->input->post('str_keywords');
						$dados_produtos['str_description']    = $this->input->post('str_description');

						$dados_produtos['int_ativo']          = $this->input->post('int_ativo');
						$dados_produtos['int_destaque']       = $this->input->post('int_destaque');
						
						$dados_produtos['str_slug']           = sanitize_title_with_dashes($dados_produtos['str_nome']);
						$dados_produtos['dt_cadastro']        = date('Y-m-d H:i:s');

						$inserir_produtos 				      = $this->produtos_model->salvar($dados_produtos);

						$id_produto       			          = $this->db->insert_id();

				    	$config['upload_path']   = './produtos_imagem/';
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
							$thumb['source_image']   = 'produtos_imagem/' . $imagem;
							$thumb['new_image']      = 'produtos_imagem/';
							$thumb['maintain_ratio'] = FALSE;
							$thumb['width']          = '1920';
							$thumb['height']         = '927';
							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($thumb);
							$this->image_lib->resize();
							$this->image_lib->clear();

							# REDIMENSIONO IMAGEM THUMB
							$normal['image_library']  = 'GD2';
							$normal['source_image']   = 'produtos_imagem/' . $imagem;
							$normal['new_image']      = 'produtos_imagem/thumb/';					
							$normal['create_thumb']   = FALSE;
							$normal['maintain_ratio'] = TRUE;
							$normal['width']          = '231';
							$normal['height']         = '304';

							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($normal);
							$this->image_lib->resize();
							$this->image_lib->clear();

							# SALVO NA TABELA 
							$dados_imagens['id_produtos'] = $id_produto;
							$dados_imagens['str_imagem']  = $imagem;
							$inserir_imagens 			  = $this->produtos_model->salvar_imagem($dados_imagens);

			            }

			            redirect(base_url() . 'clicserver/produtos/index/ok');

			        } else {

						$dados_produtos['id_categoria']       = $this->input->post('id_categoria');
						$dados_produtos['id_sub_categoria']   = $this->input->post('id_sub_categoria');
						$dados_produtos['id_responsavel']     = $this->session->userdata('id_usuario');

						$dados_produtos['str_nome']           = $this->input->post('str_nome');
						$dados_produtos['txt_descricao']    = $this->input->post('txt_descricao');

						$dados_produtos['str_title']          = $this->input->post('str_title');
						$dados_produtos['str_keywords']       = $this->input->post('str_keywords');
						$dados_produtos['str_description']    = $this->input->post('str_description');

						$dados_produtos['int_ativo']          = $this->input->post('int_ativo');
						$dados_produtos['int_destaque']       = $this->input->post('int_destaque');
						
						$dados_produtos['str_slug']           = sanitize_title_with_dashes($dados_produtos['str_nome']);
						$dados_produtos['dt_cadastro']        = date('Y-m-d H:i:s');

						$inserir_produtos 				      = $this->produtos_model->salvar($dados_produtos);
	 
						redirect(base_url() . 'clicserver/produtos/index/ok');

			        }

			    }

			}

		}


		/***
		* página de edição do produto
		*
		*
		*
		******/
		public function editar($id, $msg = null)
		{

			#CARREGANDO INFORMAÇẼS PADRÕES
			$dados['titulo']         = 'Conteúdo - Edição - Clicserver';
			$dados['css_pagina']     = 'conteudo.css';
			$dados['dados_menu']     = $this->conteudo_model->listarConteudo();
			$dados['msg']            = $msg;

			#CARREGANDO INFORMAÇẼS DINÂNICOS
			$dados['categorias']     = $this->categorias_model->listarCategorias();
			$dados['sub_categorias'] = $this->sub_categorias_model->listarSubCategorias();
	 		$dados['produtos']       = $this->produtos_model->listarProdutos($id);

			$dados['imagem']         = $this->produtos_model->listarImagensProdutos($id);
			$dados['total_imagem']   = count($this->produtos_model->listarImagensProdutos($id));


			#CARREGANDO AS VIEWS
			$this->load->view('clicserver/elementos/topo', $dados);
			$this->load->view('clicserver/produtos_editar');
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
			$this->form_validation->set_rules('str_nome', 'Nome', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('str_slug', 'Slug', 'required|min_length[3]|max_length[200]');
			$this->form_validation->set_rules('txt_descricao', 'Descrição', 'required');
			$this->form_validation->set_rules('id_categoria', 'Escolha a Categoria', 'required');
			$this->form_validation->set_rules('id_sub_categoria', 'Escolha a Sub-Categoria', 'required');

			
			# MENSAGENS DE VALIDAÇÃO DO FORMUÁRIO
			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 200 caracteres para o campo %s é obrigatório.');

			if ($this->form_validation->run() == FALSE) {

				# NÃO VALIDOU
				$this->editar($this->input->post('id'));

			} else {

				if ($this->input->post('confirma_slug') == 1) {

					$this->index('nao_validou_slug');

				} else {

					if ($_FILES) {

						$dados_produtos['id']                    = $this->input->post('id');

						$dados_produtos['id_categoria']          = $this->input->post('id_categoria');
						$dados_produtos['id_sub_categoria']      = $this->input->post('id_sub_categoria');

						$dados_produtos['str_nome']              = $this->input->post('str_nome');
						$dados_produtos['txt_descricao']         = $this->input->post('txt_descricao');

						$dados_produtos['str_title']             = $this->input->post('str_title');
						$dados_produtos['str_keywords']          = $this->input->post('str_keywords');
						$dados_produtos['str_description']       = $this->input->post('str_description');

						$dados_produtos['int_ativo']             = $this->input->post('int_ativo');
						$dados_produtos['int_destaque']          = $this->input->post('int_destaque');
						
						$dados_produtos['str_slug']              = sanitize_title_with_dashes($this->input->post('str_slug'));

						$dados_produtos['dt_ultima_modificacao'] = date('Y-m-d H:i:s');					

						$gravar_produtos 				         = $this->produtos_model->gravar($dados_produtos);

				    	$config['upload_path']   = './produtos_imagem/';
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
							$thumb['source_image']   = 'produtos_imagem/' . $imagem;
							$thumb['new_image']      = 'produtos_imagem/';
							$thumb['maintain_ratio'] = FALSE;
							$thumb['width']          = '1920';
							$thumb['height']         = '927';
							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($thumb);
							$this->image_lib->resize();
							$this->image_lib->clear();

							# REDIMENSIONO IMAGEM THUMB
							$normal['image_library']  = 'GD2';
							$normal['source_image']   = 'produtos_imagem/' . $imagem;
							$normal['new_image']      = 'produtos_imagem/thumb/';					
							$normal['create_thumb']   = FALSE;
							$normal['maintain_ratio'] = TRUE;
							$normal['width']          = '231';
							$normal['height']         = '304';

							$this->load->library('image_lib', $config);
							$this->image_lib->initialize($normal);
							$this->image_lib->resize();
							$this->image_lib->clear();

							# SALVO NA TABELA 
							$dados_imagens['id_produtos'] = $dados_produtos['id'];
							$dados_imagens['str_imagem']  = $imagem;

							$inserir_imagens 			  = $this->produtos_model->salvar_imagem($dados_imagens);

			            }

			            redirect(base_url() . 'clicserver/produtos/index/ok');

			        } else {

						$dados_produtos['id']                 = $this->input->post('id');

						$dados_produtos['id_categoria']          = $this->input->post('id_categoria');
						$dados_produtos['id_sub_categoria']      = $this->input->post('id_sub_categoria');

						$dados_produtos['str_nome']              = $this->input->post('str_nome');
						$dados_produtos['txt_descricao']         = $this->input->post('txt_descricao');

						$dados_produtos['str_title']             = $this->input->post('str_title');
						$dados_produtos['str_keywords']          = $this->input->post('str_keywords');
						$dados_produtos['str_description']       = $this->input->post('str_description');

						$dados_produtos['int_ativo']             = $this->input->post('int_ativo');
						$dados_produtos['int_destaque']          = $this->input->post('int_destaque');
						
						$dados_produtos['str_slug']              = sanitize_title_with_dashes($this->input->post('str_slug'));

						$dados_produtos['dt_ultima_modificacao'] = date('Y-m-d H:i:s');										

						$gravar_produtos 				      = $this->produtos_model->gravar($dados_produtos);

						redirect(base_url() . 'clicserver/produtos/index/ok');

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
		function excluir($id)
		{

			$imagem      = $this->produtos_model->listarImagensProdutos($id);

			if ($imagem) {

				foreach($imagem as $img){

					unlink(FCPATH . 'produtos_imagem/' . $img->str_imagem);
					unlink(FCPATH . 'produtos_imagem/thumb/' . $img->str_imagem);
				}

			}

			$this->produtos_model->excluir($id);

			$this->produtos_model->excluir_todas_imagem($id);

			$this->index('excluido_sucesso');

		}	


		/***
		*
		*
		*
		*
		******/
		function excluir_imagem($id)
		{

			$imagem     = $this->produtos_model->listarImagemUnicaProduto($id);
			$id_produto = $imagem[0]->id_produtos;

				unlink(FCPATH . 'produtos_imagem/' . $imagem[0]->str_imagem);
				unlink(FCPATH . 'produtos_imagem/thumb/' . $imagem[0]->str_imagem);

			$this->produtos_model->excluir_imagens_produto($id);

			redirect(base_url() . 'clicserver/produtos/editar/' . $id_produto);

		}


		/***
		*
		*
		*
		*
		******/
		public function status()
		{

			$res = $this->produtos_model->listarProdutos($this->input->post('id'));

			if ($res[0]->int_ativo == '1') {

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '0';

				$this->produtos_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_ativo == '0'){

				$dados['id']        = $this->input->post('id');
				$dados['int_ativo'] = '1';

				$this->produtos_model->gravar($dados);

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

			$res = $this->produtos_model->listarProdutos($this->input->post('id'));

			if ($res[0]->int_destaque == '1') {

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '0';

				$this->produtos_model->gravar($dados);

				echo 'desativado';

			}

			else if($res[0]->int_destaque == '0'){

				$dados['id']           = $this->input->post('id');
				$dados['int_destaque'] = '1';

				$this->produtos_model->gravar($dados);

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

			$existe_slug = $this->produtos_model->checaSlug($slug);

			if($existe_slug)
				echo 'sim';
			else
				echo sanitize_title_with_dashes($this->input->post('slug'));

		}


		/***
		*
		*
		*
		*
		******/
		function slug()
		{

			echo sanitize_title_with_dashes($this->input->post('slug'));

		}	


		/***
		*
		*
		*
		*
		******/
		public function get_sub_cat($id_categoria)
		{

			$sub_categorias = $this->produtos_model->getSubCategorias($id_categoria);
			     
			if (empty($sub_categorias))
			    return '{ "str_nome" : "Nenhuma sub-categoria encontrada" }';
			 
			echo json_encode($sub_categorias);

			return;

		}

	}