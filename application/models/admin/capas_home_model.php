<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Capas_home_model extends CI_Model {
	    	
	    function __construct()
	    {

	        parent::__construct();

	    }

		
		/***
		* lista todas as capas
		*
		*
		*
		******/
		public function listarCapas($id = null)
		{

			if ($id) {

				$this->db->where('id', $id);

				$res = $this->db->get('tb_capas_home')->result();

				return $res;

			}

			$query = $this->db->get('tb_capas_home');

			return $query->result();

		}


		/***
		* lista todas as capas ativas
		*
		*
		*
		******/
		public function listarOrdemCapas($id = null)
		{

			if ($id) {

				$this->db->where('id', $id);

				$this->db->where('int_ativo', 1);

				$this->db->order_by('int_ordem', 'asc');
 

				$res = $this->db->get('tb_capas_home')->result();

				return $res;

			}

			$this->db->where('int_ativo', 1);

			$this->db->order_by('int_ordem', 'asc');			

			$query = $this->db->get('tb_capas_home');

			return $query->result();

		}		
		

		/***
		* exclui a imagem
		*
		*
		*
		******/
	    function excluir($id)
	    {

		   	$this->db->where('id', $id);

			$this->db->delete('tb_capas_home');

			if ($this->db->affected_rows() > 0)
				return true;
			else
				return false;
	    
		}


		/***
		* cadastra a imagem
		*
		*
		*
		******/
		function inserir($dados)
		{
			
			return $this->db->insert('tb_capas_home', $dados); 

		}    		


	    /***
	    *
	    *
	    *
	    *
	    ******/
		function gravar($dados)
		{
		
			$this->db->where('id', $dados['id']);

			$gravou = $this->db->update('tb_capas_home', $dados);

			if ($gravou)
				return $gravou;
			else
				return false;

		}		


		# FRONT END

		public function listarCapasHome()
		{	

			$this->db->where('int_ativo', 1);

			$query = $this->db->get('tb_capas_home');

			return $query->result();

		}


	}