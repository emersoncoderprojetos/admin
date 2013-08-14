<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Orcamento_model extends CI_Model {


    function __construct(){
        parent::__construct();
    }

	
	/***
	*
	* lista produto pela slug
	*
	*
	******/
	public function listarProdutos($slug)
	{

		$this->db
			->select('a.*, b.str_nome as str_categoria, c.str_nome as str_sub_categoria')
			->from('tb_produtos a')
			->join('tb_categorias      as b', 'b.id = a.id_categoria', 'left')
			->join('tb_sub_categorias  as c', 'c.id = a.id_sub_categoria', 'left')
			->where('a.str_slug', $slug);

		$query = $this->db->get();

		return $query->result();

	}


	/***
	*
	* lista produto pela slug
	*
	*
	******/
	public function listarDadosProdutos($id_produto)
	{

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.txt_descricao, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

		$this->db->where('a.id', $id_produto);

		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos', 'left');

		$this->db->join('tb_categorias as c', 'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d', 'd.id = a.id_sub_categoria');


		$res = $this->db->get('tb_produtos a')->result();

		return $res;

	}


	/***
	* LISTAGEM DE TIPOS DE DOWNLOADS
	*
	*
	*
	******/
	public function listarTipos($id = null)
	{

		if ($id) {

			$this->db->where('id', $id);

			$res = $this->db->get('tb_tipos_download')->result();

			return $res;

		}

		$query = $this->db->get('tb_tipos_download');

		return $query->result();

	}


	/***
	* LISTAGEM DE DOWNLOADS DOS PRODUTOS
	*
	*
	*
	******/
	public function listarDownloads($id = null)
	{

		if ($id) {

			$this->db
				->select('a.*, b.str_nome as str_tipo_download')
				->from('tb_produtos_arquivos a')
				->join('tb_tipos_download as b', 'b.id = a.id_tipo_download')
				->where('a.id_produto', $id);

			$query = $this->db->get();

			return $query->result();

		}

		$this->db
			->select('a.*, b.str_nome as str_tipo_download')
			->from('tb_produtos_arquivos a')
			->join('tb_tipos_download as b', 'b.id = a.id_tipo_download');

		$query = $this->db->get();

		return $query->result();		

	}



	public function listarDownloadsUnico($id = null)
	{



			$this->db
				->select('a.*, b.str_nome as str_tipo_download')
				->from('tb_produtos_arquivos a')
				->join('tb_tipos_download as b', 'b.id = a.id_tipo_download')
				->where('a.id', $id);

			$query = $this->db->get();

			return $query->result();


	

	} 		 			


	/***
	*
	*
	*
	*
	******/
	public function salvar($dados)
	{
		
		return $this->db->insert('tb_produtos', $dados); 

	}


	/***
	*
	*
	*
	*
	******/
	public function inserir_tipo($dados)
	{
		
		return $this->db->insert('tb_tipos_download', $dados); 

	}


	/***
	*
	*
	*
	*
	******/
	public function salvar_imagem($dados)
	{
		
		return $this->db->insert('tb_produtos_imagem', $dados); 

	}			


	/***
	*
	*
	*
	*
	******/
	public function inserir_downloads($dados)
	{
		
		return $this->db->insert('tb_produtos_arquivos', $dados); 

	}	


	/***
	*
	*
	*
	*
	******/
	public function gravar($dados)
	{
	
		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_produtos', $dados);

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
	public function gravar_arquivos($dados)
	{
	
		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_produtos_arquivos', $dados);

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
	public function gravar_tipos($dados)
	{
	
		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_tipos_download', $dados);

		if ($gravou)
			return $gravou;
		else
			return false;

	}	


	/***
	* não sei se esta sendo utilizado
	*
	*
	*
	******/
    public function excluir_imagem($dados)
    {

		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_produtos', $dados);

		if ($gravou)
			return $gravou;
		else
			return false;

    }


    public function excluir_imagens_produto($id)
    {


	   	$this->db->where('id', $id);
		$this->db->delete('tb_produtos_imagem');

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
	******/
    public function excluir_arquivos($id)
    {


	   	$this->db->where('id', $id);
		$this->db->delete('tb_produtos_arquivos');

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
	******/
    public function excluir_tipos_download($id)
    {


	   	$this->db->where('id', $id);
		$this->db->delete('tb_tipos_download');

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
	******/
    public function existe_imagem($id)
    {

    	$this->db->select('str_imagem');
		$this->db->where('id', $id);

		$res = $this->db->get('tb_produtos')->result();

		return $res;

    }





	/***
	*
	*
	*
	*
	******/
	public function grava_nova_imagem($dados)
	{
	
		$this->db->where('id', $dados['id']);

		$gravou = $this->db->update('tb_produtos', $dados);

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
		$this->db->delete('tb_produtos');

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
	******/
    function excluir_todas_imagem($id)
    {

	   	$this->db->where('id_produtos', $id);
		$this->db->delete('tb_produtos_imagem');

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
	******/
	public function checaSlug($string)
	{

		$this->db->where('str_slug', $string);

		$query = $this->db->get('tb_produtos');

		return $query->result();

	}


	/***
	*
	*
	*
	*
	******/
	function listarImagensProdutos($id)
	{

		$this->db->where('id_produtos', $id);

    	$query = $this->db->get('tb_produtos_imagem');

    	return $query->result();

    }


	function listarImagemUnicaProduto($id)
	{

		$this->db->where('id', $id);

    	$query = $this->db->get('tb_produtos_imagem');

    	return $query->result();

    }    

	/***
	*
	*
	*
	*
	******/
    public function getSubCategorias($id)
    {

    	$this->db->select('*');
		$this->db->where('id_categoria', $id);

		$res = $this->db->get('tb_sub_categorias')->result();

		return $res;

    }

	/***
	*
	* 		FRONT END
	*
	*
	******/

	public function listarCategoriasMenu(){

    	$this->db->select('*');
		$this->db->where('int_ativo', 1);

		$res = $this->db->get('tb_categorias')->result();

		return $res;

	}

	public function listarSubCategoriasMenu(){

    	$this->db->select('*');
		$this->db->where('int_ativo', 1);

		$res = $this->db->get('tb_sub_categorias')->result();

		return $res;

	}	


	public function listarProdutosPagIni(){

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.str_codigo, a.txt_visao_geral, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

    	$this->db->where('a.id_categoria', 46);
    	$this->db->where('a.id_sub_categoria', 50);
		$this->db->where('a.int_ativo', 1);

		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos');

		$this->db->join('tb_categorias as c', 'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d', 'd.id = a.id_sub_categoria');


		$res = $this->db->get('tb_produtos a')->result();

		return $res;

	}


	public function verDadosCatSlug($slug)
	{

    	$this->db->select('*');
		$this->db->where('str_slug', $slug);

		$res = $this->db->get('tb_categorias')->result();

		return $res;

	}


	public function verDadosSubCatSlug($slug)
	{

    	$this->db->select('*');
		$this->db->where('str_slug', $slug);

		$res = $this->db->get('tb_sub_categorias')->result();

		return $res;

	}


	public function listarProdutosPorSub($id_sub)
	{

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.str_codigo, a.txt_visao_geral, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

		$this->db->where('a.int_ativo', 1);
		$this->db->where('a.id_sub_categoria', $id_sub);


		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos');

		$this->db->join('tb_categorias as c', 'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d', 'd.id = a.id_sub_categoria');


		$res = $this->db->get('tb_produtos a')->result();

		return $res;

	}



    /***
    * query da paginação da página produtos quando é carregado
    * traz o resultado da primeira sub_categoria encontrada.
    *
	*
	*
	******/
    public function listarProdutosDaPrimeiraSubCat($id_sub_categoria, $offset)
    {

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.str_codigo, a.txt_visao_geral, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

		$this->db->where('a.id_sub_categoria', $id_sub_categoria);
		$this->db->where('a.int_ativo', 1);
		$this->db->where('c.int_ativo', 1);
		$this->db->where('d.int_ativo', 1);

		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos');
		$this->db->join('tb_categorias as c',      'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d',  'd.id = a.id_sub_categoria');

		$query = $this->db->get('tb_produtos a', 6, $offset);

		return $query->result();

    }


    /***
    * query da paginação
    * traz o resultado de todos os produtos por id_categoria e id_sub_categoria
    *
	*
	*
	******/
    public function listarProdutosPaginacao($id_sub_categoria, $offset)
    {

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.str_codigo, a.txt_visao_geral, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

		$this->db->where('a.id_sub_categoria', $id_sub_categoria);
		$this->db->where('a.int_ativo', 1);
		$this->db->where('c.int_ativo', 1);
		$this->db->where('d.int_ativo', 1);

		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos');
		$this->db->join('tb_categorias as c',      'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d',  'd.id = a.id_sub_categoria');

		$query = $this->db->get('tb_produtos a', 6, $offset);

		return $query->result();

    }


    /***
    * 
    * 
    *
	*
	*
	******/
    public function totalProdutosPaginacao($id_sub_categoria)
    {

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.str_codigo, a.txt_visao_geral, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

		$this->db->where('a.id_sub_categoria', $id_sub_categoria);
		$this->db->where('a.int_ativo', 1);
		$this->db->where('c.int_ativo', 1);
		$this->db->where('d.int_ativo', 1);

		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos');
		$this->db->join('tb_categorias as c',      'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d',  'd.id = a.id_sub_categoria');

		$query = $this->db->get('tb_produtos a');

		return $query->result();

    }


    /***
    * lista as noticias da paginação
    *
    *
	*
	*
	******/
	public function totalProdutosPagInicPaginacao($id_categoria, $id_sub_categoria)
	{

		$this->db->where('id_categoria', $id_categoria);
		$this->db->where('id_sub_categoria', $id_sub_categoria);
		$this->db->where('int_ativo', 1);
		$this->db->from('tb_produtos');

		return $this->db->count_all_results();

	}


    /***
    * lista as noticias da paginação
    *
    *
	*
	*
	******/
	public function ultimaSubCategoria()
	{

		$this->db->select('a.id as id_categoria, a.str_slug as slug_cat, b.id as id_sub_categoria, b.str_slug as sub_slug');
		$this->db->from('tb_categorias a');
		$this->db->join('tb_sub_categorias b', 'a.id = b.id_categoria');

		$query = $this->db->get();

		return $query->result();

	}

	public function posicaoCategoriaMenu()
	{

		$this->db->where('int_ativo', 1);

		$query = $this->db->get('tb_categorias');

		$res   = $query->result();

		return $res;

	}


	/***
	* dados do produto
	* busca resultado pela slug
	*
	*
	******/
	public function listarProdutosFront($slug)
	{

		$this->db
			->select('a.*, b.str_nome as str_categoria, c.str_nome as str_sub_categoria')
			->from('tb_produtos a')
			->join('tb_categorias      as b', 'b.id = a.id_categoria', 'left')
			->join('tb_sub_categorias  as c', 'c.id = a.id_sub_categoria', 'left')
			->where('a.int_ativo', 1)
			->where('a.str_slug', $slug);

		$query = $this->db->get();

		return $query->result();

	}

	public function listarProdutosRelacionados($id_sub_categoria)
	{

    	$this->db->select('a.id, a.id_categoria, c.str_slug as slug_cat, d.str_slug as slug_sub, a.id_sub_categoria, a.str_nome as nome_produto, a.str_codigo, a.txt_visao_geral, a.int_ativo, b.str_imagem, a.str_slug as slug_produto');

		$this->db->where('a.int_ativo', 1);
		$this->db->where('a.id_sub_categoria', $id_sub_categoria);


		$this->db->join('tb_produtos_imagem as b', 'a.id = b.id_produtos');

		$this->db->join('tb_categorias as c', 'a.id_categoria = c.id');
		$this->db->join('tb_sub_categorias as d', 'd.id = a.id_sub_categoria');


		$res = $this->db->get('tb_produtos a')->result();

		return $res;

	}

	public function listarTiposDownload()
	{

		$query = $this->db->get('tb_tipos_download');

		$res   = $query->result();

		return $res;

	}


	public function listarDownloadProduto($id_produto)
	{	

		$this->db->where('id_produto', $id_produto);

		$query = $this->db->get('tb_produtos_arquivos');

		$res   = $query->result();

		return $res;

	}


}