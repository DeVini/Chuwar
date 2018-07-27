<?php
	
	require_once('../Models/Jogador.php');
	/**
	 * 
	 */
	class Computador extends Jogador
	{
		
		function __construct(){}
		
		//insere os paises sorteados iniciais no banco de dados
		public function gravarDados($id){

			$objBD = new Bd();
			$mysqli = $objBD->conecta_mysql();
			
			try{
				$mysqli->begin_transaction();
				$sql = "insert into partida_territorio(usuario,territorio,cpu,exercitos) value (?,?,?,?);";
				
				foreach ($this->getTerritorios() as $key => $value){
					
					if($stmt = $mysqli->prepare($sql)){

						$territorio = $key;
						$exercitos = $value;
						$cpu = false;
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
		public function salvarDados($id){

		$objBD = new Bd();
		$mysqli = $objBD->conecta_mysql();
		try{

			$mysqli->begin_transaction();
			$sql = "update partida_territorio set cpu = ?,exercitos = ?  where usuario = ? and territorio = ? ";
			
			foreach ($this->getTerritorios() as $key => $value){
				
				if($stmt = $mysqli->prepare($sql)){

					
					$territorio = $key;
					$cpu = false;
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