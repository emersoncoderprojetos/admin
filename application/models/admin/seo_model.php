<?php
class Seo_model extends CI_Model {
    	
    function __construct(){
        parent::__construct();
    }
	
	public function listarSeo($id = null)
	{

		if ($id) {
			$this->db->where('id', $id);
			$res = $this->db->get('tb_seo')->result();
			return $res;
		}

		$query = $this->db->get('tb_seo');
		return $query->result();

	}

	function gravar($dados_seo)
	{

		$this->db->where('id', $dados_seo['id']);

		$gravou = $this->db->update('tb_seo', $dados_seo);
		
		if($gravou){
			return $gravou;
		} else {
			return false;
		}

	}


}