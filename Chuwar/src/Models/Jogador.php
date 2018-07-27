<?php  
require_once('../Models/Bd.php');

	class Jogador 
	{
		protected $territorios = array();

		function __construct(){}

		public function getTerritorio($pais){
			return $this->territorios[$pais];
		}

		public function getTerritorios(){
			return $this->territorios;
		}

		public function zerar(){
			$this->territorios = array();
		}

		public function setTerritorios($pais,$exercito){
			//array_push($this->territorios)
			$this->territorios[$pais] = $exercito;
		}

		public function removerPais($indice){
			$newArray = array();
			foreach($this->territorios as $value)
			{
				if( $value != $indice )
				{
					array_push($newArray, $value);
				}
			}
			$this->territorios = $newArray;
		}
		
		public function addExercito($pais,$valor){
			$this->territorios["$pais"] = $this->territorios["$pais"] + $valor;
		}

		public function removeExercito($pais){
			if($this->getTerritorio($pais) > 0 ){
				$this->territorios["$pais"] = $this->territorios["$pais"] - 1 ;
			}
		}

		//verifica se o pais dado foi conquistado
		public function isPais($pais)
		{
			return array_key_exists($pais, $this->territorios);
		}

		public function totalExercitos(){
			$total = 0;
			foreach ($this->getTerritorios() as $key => $value) {
				$total += $value;
			}
			return $total;
		}
	}
?>