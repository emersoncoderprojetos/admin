<?php defined('BASEPATH') OR exit('No direct script access allowed');


	class Menu_model extends CI_Model {

	    
	    /***
	    * função construtora
	    *
	    *
	    *
	    ******/	
	    function __construct()
	    {

	        parent::__construct();

	    }


	    /***
	    * lista os menus
	    *
	    *
	    *
	    ******/
		public function listarMenu($id = null)
		{

			if ($id) {

				$this->db->where('id', $id);

				$res = $this->db->get('tb_menu')->result();

				return $res;

			}

			$query = $this->db->get('tb_menu');

			return $query->result();

		}


	    /***
	    * lista os sub-menus
	    *
	    *
	    *
	    ******/
		public function listarSubMenu($id = null)
		{

			if ($id) {

				$this->db->where('id', $id);

				$res = $this->db->get('tb_submenu')->result();

				return $res;

			}

			$this->db->select('a.*');
			$this->db->select('b.str_nome as str_menu');
			$this->db->select('b.str_slug as str_menu_slug');

			$this->db->join('tb_menu as b', 'a.id_menu = b.id');

			$query = $this->db->get('tb_submenu a');

			return $query->result();

		} 		


	    /***
	    * cadastra os menus
	    *
	    *
	    *
	    ******/
		function inserirMenu($dados)
		{
			
			return $this->db->insert('tb_menu', $dados); 

		}


	    /***
	    * cadastra os submenu
	    *
	    *
	    *
	    ******/
		function inserirSubMenu($dados)
		{
			
			return $this->db->insert('tb_submenu', $dados); 

		}		
		

	    /***
	    * grava dados do menu
	    *
	    *
	    *
	    ******/
		function gravarMenu($dados)
		{
		
			$this->db->where('id', $dados['id']);

			$gravou = $this->db->update('tb_menu', $dados);

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
	    function excluirMenu($id)
	    {

		   	$this->db->where('id', $id);

			$this->db->delete('tb_menu');

			if($this->db->affected_rows() > 0){

				return true;

			} else {

				return false;

			}

	    }		


	    /***
	    * busca dados de slug
	    *
	    *
	    *
	    ******/
		public function checaSlug($string)
		{

			$this->db->where('str_slug', $string);

			$query = $this->db->get('tb_menu');

			return $query->result();

		}


	}