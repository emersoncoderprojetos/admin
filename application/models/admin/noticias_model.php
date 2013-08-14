<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias_model extends CI_Model {
    	
    function __construct()
    {

        parent::__construct();

    }


    /***
    * lista todas as noticias
    *
    *
	*
	*
	******/	
	public function listarNoticias($id = null)
	{

		if ($id) {

			$this->db

				->select('*')
				->from('tb_noticias')
				->where('id', $id);

			$query = $this->db->get();

			return $query->result();

		}

		$this->db

			->select('*')
			->from('tb_noticias');

		$query = $this->db->get();

		return $query->result();

	}


    /***
    * insere nova noticia
    *
    *
	*
	*
	******/
	public function inserir($dados)
	{
		
		return $this->db->insert('tb_noticias', $dados); 

	}


    /***
    * gravação de edição de dados
    *
    *
	*
	*
	******/
	public function gravar($dados)
	{
	
		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_noticias', $dados);

		if ($gravou)
			return $gravou;
		else
			return false;

	}


    /***
    * excluir/deletar
    *
    *
	*
	*
	******/
    function excluir($id)
    {

	   	$this->db->where('id', $id);
		$this->db->delete('tb_noticias');

		if ($this->db->affected_rows() > 0)
			return true;
		else
			return false;

    
    }


    /***
    * grava status / ativo
    *
    *
	*
	*
	******/
    public function status($dados)
    {

		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_noticias', $dados);

		if ($gravou)
			return $gravou;
		else 
			return false;

    }


    /***
    * verifica se existe o slug
    *
    *
	*
	*
	******/
    public function existeSlug($str_slug)
    {

		$this->db

			->select('*')
			->from('tb_noticias')
			->where('str_slug', $str_slug);

		$query = $this->db->get();

		return $query->result();

    }



    /***
    *  lista todas as noticias ativas
    *
    *
	*
	*
	******/
    public function listarNoticiasTodas()
    {

		$this->db

			->select('*')
			->from('tb_noticias')
			->where('int_ativo', 1);

		$query = $this->db->get();

		return $query->result();

    }


    /***
    * lista as noticias da paginação
    *
    *
	*
	*
	******/
    public function listarNoticiasPaginacao($offset)
    {

		$query = $this->db->get('tb_noticias', 5, $offset);

		return $query->result();

    }


    /***
    * lista as noticias da paginação
    *
    *
	*
	*
	******/
	public function totalNoticiasPaginacao()
	{

		$this->db->where('int_ativo', 1);
		$this->db->from('tb_noticias');

		return $this->db->count_all_results();

	}



	/***      ***
	* FRONT		*
	*			*
	* END		*
	*			*
	***       ***/	  

    /***
    * lista todas as noticias ativas
    *
    *
	*
	*
	******/	
	public function listarNoticiasHome($id = null)
	{

		if ($id) {

			$this->db

				->select('*')
				->from('tb_noticias')
				->where('id', $id)
				->where('int_ativo', 1);

			$query = $this->db->get();

			return $query->result();

		}

		$this->db

			->select('*')
			->from('tb_noticias')
			->where('int_ativo', 1);

		$query = $this->db->get();

		return $query->result();

	}

    
    /***
    * lista as noticias da paginação
    *
    *
	*
	*
	******/
	public function listarNoticiaSlug($slug)
	{

		$this->db->where('str_slug', $slug);
		$this->db->from('tb_noticias');

		$query = $this->db->get();

		return $query->result();		

	}	


    /***
    *  lista todas as noticias ativas
    *
    *
	*
	*
	******/
    public function listarNoticiasFront()
    {

		$this->db

			->select('*')
			->from('tb_noticias')
			->where('int_ativo', 1)
			
			->where('int_destaque', 1);

		$query = $this->db->get();

		return $query->result();

    }	


    /***
    *  lista todas as noticias ativas
    *
    *
	*
	*
	******/
    public function listarNoticiasUltima()
    {

		$this->db

			->select('*')
			->from('tb_noticias')
			->where('int_ativo', 1)
			->limit(1);
			
		$query = $this->db->get();

		return $query->result();

    }	

}