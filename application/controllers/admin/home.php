<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Home extends CI_Controller {


		var $titulo = 'Rodrigo Transportes AdminSystem';


		/***
		*
		*
		*
		*
		*****/
		function __construct()
		{

			parent::__construct();

			$this->load->model('admin/usuarios_model');

		}


		/***
		*
		*
		*
		*
		*****/
		public function index()
		{

			$dados['titulo'] = $this->titulo;
			$this->load->view('admin/login', $dados);

		}


		/***
		*
		*
		*
		*
		*****/
		public function login()
		{

			$this->form_validation->set_rules('str_usuario', 'Usuário', 'trim|required|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('str_senha',   'Senha',   'trim|required');

			$this->form_validation->set_message('required', 'O campo %s é obrigatório.');
			$this->form_validation->set_message('min_length', 'Mínimo de 3 caracteres para o campo %s é obrigatório.');
			$this->form_validation->set_message('max_length', 'Máximo de 50 caracteres para o campo %s é obrigatório.');

			$this->form_validation->set_error_delimiters('

															<div class="alert alert-error" style="display:block">

																<a class="close" data-dismiss="alert" href="#">x</a>',

															'</div>');

			if ($this->form_validation->run() == FALSE) {

				$this->index();

			} else {
			
				$dados['str_usuario'] = $this->input->post('str_usuario');
				$dados['str_senha']   = $this->input->post('str_senha');
				$usuario              = $this->usuarios_model->login($dados);
			
				if ($usuario) {

					#DEFINO AS VARIAVEIS DE SESSÃO DO USUÁRIO LOGADO
					$dados = array(
								'usuario'     => $usuario[0]->str_usuario,
								'nome'        => $usuario[0]->str_nome,
								'id_usuario'  => $usuario[0]->id,
								'logado'      => TRUE
							);

					#INSTANCIO EM $this->session(); as informações de sessão.
					$this->session->set_userdata($dados);

					#REDIRECIONO PARA A PÁGINA INICIAL
					redirect(base_url("admin/inicio"));

				} else {

					$this->index();

				}

			}

		}


		/***
		*
		*
		*
		*
		*****/		
		public function logout()
		{

			$this->session->sess_destroy();

			redirect($this->home());

		}


		/***
		* - função que gera senha aleatória no tamanho de 8 caracteres, misturando maiusculas, numero e não tem simbolos.
		*
		*
		*
		*****/
		function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
		{
			
			$lmin        = 'abcdefghijklmnopqrstuvwxyz';
			$lmai        = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$num         = '1234567890';
			$simb        = '!@#$%*-';
			$retorno     = '';
			$caracteres  = '';

			$caracteres .= $lmin;
			
			if ($maiusculas) 
				$caracteres .= $lmai;

			if ($numeros) 
				$caracteres .= $num;

			if ($simbolos) 
				$caracteres .= $simb;

			$len = strlen($caracteres);
			
			for ($n = 1; $n <= $tamanho; $n++) {

				$rand     = mt_rand(1, $len);
				$retorno .= $caracteres[$rand - 1];

			}

			return $retorno;

		}			


		/***
		* abre a view de recuperação de senha
		*
		*
		*
		*****/
		public function esqueceu_senha()
		{

			$this->load->view('admin/esqueceu_senha');

		}


		/***
		*
		*
		*
		*
		*****/
		public function email_senha()
		{

			echo $this->input->post('email');

		}


		/***
		*
		*
		*
		*
		*****/
		public function existe_email()
		{

			# RECUPERO OS DADOS DO E-MAIL
			$email = $this->usuarios_model->existe_email($this->input->post('email'));

			# SE EXISTIR E-MAIL
			if ($email) {

				$dados['id']        = $email[0]->id;
				$senha              = $this->geraSenha();
				$dados['str_senha'] = sha1($senha);

				$atualizar		    = $this->usuarios_model->novaSenha($dados);

				if ($atualizar) {

					$nome     = $email[0]->str_nome;
					$email    = $email[0]->str_email;
					$html     = "

						<p style='font-size:21px;'>Rodrigo Transportes - RECUPERAÇÃO DE SENHA</p>

						<p style='font-size:17px;'>Foi gerado uma nova senha de acesso.</p>

						<p style='font-size:17px;'>Sua senha \"TEMPORÁRIA \" é : " . $senha . " </p>

						<p style='font-size:17px;'>Acesse Usuários em seu admin e altere para uma senha que apenas você saiba.</p>

					";

					$this->load->library('email');

					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['mailtype'] = 'html';
					$config['charset']  = 'utf-8';
					$config['wordwrap'] = TRUE;

					$this->email->initialize($config);
					$this->email->from('emersoncoder@gmail.com', 'Fale Conosco');
					$this->email->to('emersoncoder@gmail.com');
					$this->email->subject('Nova Senha - Empório do Junco');
					$this->email->message($html);
					$this->email->send();

					echo 'sim';

				}

			} else {

				echo 'nao';

			}

		}


	}