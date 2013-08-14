<?php

class Conteudo_model extends CI_Model {

    	
    function __construct(){
        parent::__construct();
    }

	
	# LISTAR TODO O CONTEÚDO
	public function listarConteudo($id = null)
	{

		# SE FOR PASSADO O ID
		if ($id) {

			$this->db->where('id',$id);

			$res = $this->db->get('tb_conteudo')->result();

			return $res;

		}

		$query = $this->db->get('tb_conteudo');

		return $query->result();

	}


    # LISTO TODAS AS IMAGENS DA GALERIA DE FOTOS
	public function listarGaleriadefotos($id = null)
	{

		if ($id) {

			$this->db->where('id_conteudo', $id);

			$res = $this->db->get('tb_conteudo_galeriadefotos')->result();

			return $res;

		}

		$query = $this->db->get('tb_conteudo_galeriadefotos');

		return $query->result();

	}    


	# LISTO IMAGEM ÚNICA DA GALERIA DE FOTOS
    public function ListarImagemUnica($id)
    {

		$this->db->where('id', $id);

		$res = $this->db->get('tb_conteudo_galeriadefotos')->result();
		
		return $res;

    }	

    
    # GRAVO DADOS DO CONTEÚDO
	function gravar($dados_conteudo)
	{
	
		$this->db->where('id', $dados_conteudo['id']);

		$gravou = $this->db->update('tb_conteudo', $dados_conteudo);

		if($gravou){

			return $gravou;

		} else {

			return false;

		}

	}

	# INSERT IMAGEM GALERIA DE FOTOS
	function inserir_img($dados)
	{
		
		return $this->db->insert('tb_conteudo_galeriadefotos', $dados); 

	}




    function excluir_img($id)
    {

	   	$this->db->where('id', $id);
		$this->db->delete('tb_conteudo_galeriadefotos');

		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}

    }

    public function gravar_dados_img($dados)
    {

		$this->db->where('id', $dados['id']);
		$gravou = $this->db->update('tb_conteudo_galeriadefotos', $dados);
		if($gravou){
			return $gravou;
		} else {
			return false;
		}

    }


}