<?php
class Usuarios_model extends CI_Model {
    	
    function __construct(){
        parent::__construct();
    }
	
	function existe_email($email)
	{

		$this->db->where('str_email',$email);		
		$res = $this->db->get('tb_usuarios')->result();
		
		return $res;

	}

	function login($data)
	{

		$this->db->where('str_usuario', $data['str_usuario']);
		$this->db->where('str_senha', sha1($data['str_senha']));

    	$query = $this->db->get('tb_usuarios');
    	
    	return $query->result();

    }

    function novaSenha($dados)
    {

		$this->db->where('id', $dados['id']);

		$gravou = $this->db->update('tb_usuarios', $dados);

		if ($gravou)
			return $gravou;
		else
			return false;    	

    }


	public function listarUsuarios($id = null)
	{

		if ($id) {

			$this->db

				->select('*')
				->from('tb_usuarios')
				->where('id', $id);

			$query = $this->db->get();

			return $query->result();

		}

		$this->db

			->select('*')
			->from('tb_usuarios');

		$query = $this->db->get();

		return $query->result();

	}


    function gravar($dados)
    {

		$this->db->where('id', $dados['id']);

		$gravou = $this->db->update('tb_usuarios', $dados);

		if ($gravou)
			return $gravou;
		else
			return false;    	

    }	


    public function existeUsuario($usuario)
    {

		$this->db

			->select('*')
			->from('tb_usuarios')
			->where('str_usuario', $usuario);

		$query = $this->db->get();

		return $query->result(); 


    }


    public function existeEmail($email)
    {

		$this->db

			->select('*')
			->from('tb_usuarios')
			->where('str_email', $email);

		$query = $this->db->get();

		return $query->result(); 


    }


	public function inserir($dados)
	{
		
		return $this->db->insert('tb_usuarios', $dados); 

	}


    function excluir($id)
    {

	   	$this->db->where('id', $id);
		$this->db->delete('tb_usuarios');

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
		    
    }  	
	

}