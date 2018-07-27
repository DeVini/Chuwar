<?php
require_once('../Models/Jogador.php');
/**
 * 
 */

class Usuario extends Jogador
{
	private $id = 0;
	private $username = "";
	private $password = "";

	function __construct(){}

	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}

	public function getUsername(){
		return $this->username;
	}
	public function setUsername($username){
		$this->username = $username;
	}

	public function getPassword(){
		return $this->password;
	}
	public function setPassword($password){
		$this->password = $password;
	}

	public function cadastrar($username,$password){
		$retorno = false;
		$objBD = new Bd();
		$mysqli = $objBD->conecta_mysql();
		
		try{

			$mysqli->begin_transaction();
			$sql = "insert into usuarios(username,password) values (?,?)";

				if($stmt = $mysqli->prepare($sql)){

					$stmt->bind_param("ss",$username,$password);
					$stmt->execute();
					$stmt->close();
				}
				$mysqli->commit();
				$retorno = true;

		}catch(Exception $e){
			$retorno = false;
			$mysqli->rollback();

		}
		$mysqli->close();
		return $retorno;
	}

	public function userExist($username){
		$objBD = new Bd();

		$sql = "SELECT idUsuario FROM usuarios WHERE username = ? ";
		$mysqli = $objBD->conecta_mysql();
		$retorno = false;
		if($stmt = $mysqli->prepare($sql)){

			$stmt->bind_param("s",$username);
			$stmt->execute();
			$stmt->bind_result($id);
			while ($stmt->fetch()) {
				$id = $id;
 			}

			if($id > 0){
				$retorno = true;
			}

			$stmt->close();
		}
		$mysqli->close();
		return $retorno;
	}

	public function isLogar($username,$password){
		$objBD = new Bd();

		$sql = "SELECT idUsuario FROM usuarios WHERE username = ? AND password = ?; ";
		$mysqli = $objBD->conecta_mysql();
		$retorno = 0;
		if($stmt = $mysqli->prepare($sql)){

			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->bind_result($id);
			while ($stmt->fetch()) {
				$id = $id;
 			}

			if($id > 0){
				$retorno = $id;
			}

			$stmt->close();
		}
		$mysqli->close();
		return $retorno;
	}
	
	//insere os paises sorteados iniciais no banco de dados
	public function gravarDados(){

		$objBD = new Bd();
		$mysqli = $objBD->conecta_mysql();
		
		try{
			$mysqli->begin_transaction();
			$sql = "insert into partida_territorio(usuario,territorio,cpu,exercitos) values (?,?,?,?)";
			
			foreach ($this->getTerritorios() as $key => $value){
				
				if($stmt = $mysqli->prepare($sql)){

					$id = $this->id;
					$territorio = $key;
					$cpu = true;
					$exercitos = $value;

					$stmt->bind_param("isii",$id,$territorio,$cpu,$exercitos);
					$stmt->execute();
					$stmt->close();
				}
				$mysqli->commit();
			}

		}catch(Exception $e){
			$mysqli->rollback();
		}
		$mysqli->close();
	}	

	//faz um update de seus dados
	public function salvarDados(){

		$objBD = new Bd();
		$mysqli = $objBD->conecta_mysql();
		
		try{

			$mysqli->begin_transaction();
			$sql = "update partida_territorio set cpu = ?,exercitos = ?  where usuario = ? and territorio = ? ";
			
			foreach ($this->getTerritorios() as $key => $value){
				if($stmt = $mysqli->prepare($sql)){

					$id = $this->id;
					$territorio = $key;
					$cpu = true;
					$exercitos = $value;

					$stmt->bind_param("iiis",$cpu,$exercitos,$id,$territorio);
					$stmt->execute();
					$stmt->close();
				}
				$mysqli->commit();
			}
		}catch(Exception $e){
			$mysqli->rollback();
		}
		$mysqli->close();
	}
}
?>