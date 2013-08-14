<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Sub_categorias_model extends CI_Model {


		/***
		*
		*
		*
		*
		*****/	    	
	    function __construct()
	    {

	        parent::__construct();

	    }


		/***
		*
		*
		*
		*
		*****/
		public function listarSubCategorias($id = null)
		{

			if ($id) {

				$this->db->select('a.*, b.str_nome as str_categorias');
				$this->db->from('tb_sub_categorias as a');
				$this->db->join('tb_categorias as b', 'b.id = a.id_categoria', 'left');
				$this->db->where('a.id', $id);
				$query = $this->db->get();

				return $query->result();

				
				
			}

				$this->db->select('a.*, b.str_nome as str_categorias');
				$this->db->from('tb_sub_categorias as a');
				$this->db->join('tb_categorias as b', 'b.id = a.id_categoria', 'left');

				$query = $this->db->get();

				return $query->result();

		}


		/***
		*
		*
		*
		*
		*****/
		public function checaSlug($string)
		{

			$this->db->where('str_slug', $string);

			$query = $this->db->get('tb_sub_categorias');

			return $query->result();

		}  	


		/***
		*
		*
		*
		*
		*****/
		function inserir($dados)
		{
			
			return $this->db->insert('tb_sub_categorias', $dados); 

		}    
		

		/***
		*
		*
		*
		*
		*****/
		function gravar($dados)
		{
		
			$this->db->where('id', $dados['id']);

			$gravou = $this->db->update('tb_sub_categorias', $dados);

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
		*****/
	    function excluir($id)
	    {

		   	$this->db->where('id', $id);

			$this->db->delete('tb_sub_categorias');

			if ($this->db->affected_rows() > 0) 
				return true;
			else
				return false;

	    }


		/***
		*
		*
		*
		*
		*****/
		public function listarSubCategoriasHome($id = null)
		{

			if ($id) {

				$this->db->select('a.*, b.str_nome as str_categorias');
				$this->db->from('tb_sub_categorias as a');
				$this->db->join('tb_categorias as b', 'b.id = a.id_categoria', 'left');
				$this->db->where('a.id', $id);

				$this->db->where('int_ativo', 1);

				$query = $this->db->get();

				return $query->result();

				
				
			}

			$this->db->select('a.*, b.str_nome as str_categorias');
			$this->db->from('tb_sub_categorias as a');
			$this->db->join('tb_categorias as b', 'b.id = a.id_categoria', 'left');

			$this->db->where('int_ativo', 1);				

			$query = $this->db->get();

			return $query->result();

		}	    		

	}