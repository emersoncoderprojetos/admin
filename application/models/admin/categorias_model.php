<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Categorias_model extends CI_Model {

	    
	    /***
	    *
	    *
	    *
	    *
	    ******/	
	    function __construct()
	    {

	        parent::__construct();

	    }


	    /***
	    *
	    *
	    *
	    *
	    ******/
		public function listarCategorias($id = null)
		{

			if ($id) {

				$this->db->where('id', $id);

				$res = $this->db->get('tb_categorias')->result();

				return $res;

			}

			$query = $this->db->get('tb_categorias');

			return $query->result();

		} 


	    /***
	    *
	    *
	    *
	    *
	    ******/
		public function listarCategoriasInterna()
		{

			$this->db->where('int_ativo', 1);

			$query = $this->db->get('tb_categorias');

			return $query->result();

		}	


	    /***
	    *
	    *
	    *
	    *
	    ******/
		public function checaSlug($string)
		{

			$this->db->where('str_slug', $string);

			$query = $this->db->get('tb_categorias');

			return $query->result();

		}  	


	    /***
	    *
	    *
	    *
	    *
	    ******/
		function inserir($dados)
		{
			
			return $this->db->insert('tb_categorias', $dados); 

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

			$gravou = $this->db->update('tb_categorias', $dados);

			if ($gravou)
				return $gravou;
			else
				return false;

		}


	    /***
	    *
	    *
	    *
	    *
	    ******/
	    function excluir($id)
	    {

		   	$this->db->where('id', $id);

			$this->db->delete('tb_categorias');

			if($this->db->affected_rows() > 0){

				return true;

			} else {

				return false;

			}

	    }		



	    #
	    #	FRONT END
	    #


	    /***
	    *
	    *
	    *
	    *
	    ******/
		public function listarCategoriasHome($id = null)
		{

			if ($id) {

				$this->db->where('id', $id);
				$this->db->where('int_ativo', 1);

				$res = $this->db->get('tb_categorias')->result();

				return $res;

			}

			$this->db->where('int_ativo', 1);

			$query = $this->db->get('tb_categorias');

			return $query->result();

		} 


	}