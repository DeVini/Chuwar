<?php 
	require_once('../Models/Bd.php');
	require_once('../Models/War.php');
	require_once('../Models/Usuario.php');
	require_once('../Models/Computador.php');
	/**
	 * 
	 */
	class Chuwar implements War
	{
		//objetos
		private $usuario;
		private $computador;

		private $paises = array();

		function __construct()
		{
			$this->usuario = new Usuario();
			$this->usuario->setId($_SESSION['usuario']['id']);
			$this->usuario->setUsername($_SESSION['usuario']['username']);
			$this->usuario->setPassword($_SESSION['usuario']['password']);
			$this->computador = new Computador();
		}

		
  		public function getUsuario(){
  			return $this->usuario;
  		}

  		public function getComputador(){
  			return $this->computador;
  		}

		public function isPartida_em_andamento()
		{
			$retorno = false;
			$objBD = new Bd();
			$mysqli = $objBD->conecta_mysql();
			
			$sql = "SELECT COUNT(partida_territorio.idPartida_Territorio) from usuarios join partida_territorio on usuarios.idUsuario = partida_territorio.usuario where
			 usuarios.username = ? and usuarios.password = ?";

				if($stmt = $mysqli->prepare($sql)){
					
					$username = $this->usuario->getUsername();
					$password = $this->usuario->getPassword();
					$stmt->bind_param("ss",$username,$password);
					$stmt->execute();
					$stmt->bind_result($count);
					
					while($stmt->fetch()) {
					    $count += $count;
					}

					if($count > 0){
						$retorno = true;
					}
					$stmt->close();
			}
			$mysqli->close();
			return $retorno;
		}

		private function preencherArrayPaises(){
				$paises = array('Brasil' => 'Brasil',
			 'Colombia' => 'Colombia',
			  'Argentina' => 'Argentina',
			   'Mexico' => 'Mexico',
			   'Egito' => 'Egito',
			   'Eua' => 'Eua',
				'Reino Unido' => 'Reino Unido',
				 'Franca' => 'Franca',
				  'Alemanha' => 'Alemanha',
				   'Africa do Sul' => 'Africa do Sul',
				   'Russia '=> 'Russia',
				    'China' => 'China');
				return $paises;
		}
		//sortea os paises no inicio de uma partida
		public function sortearPaises()
		{
			if(!$this->isPartida_em_andamento()){
				//cria um array com as constantes de paises
				$paises = $this->preencherArrayPaises();
				//sortea um indice desse array
				while (count($paises) > 0){
				
						$indice = $paises[array_rand($paises)];
						//verifica se o usuario ja tem 6 paises 
						if(count($this->usuario->getTerritorios()) < 6){
							$this->usuario->setTerritorios($indice,3);
						}else
						{	
							$this->computador->setTerritorios($indice,3);
						}
						$this->removerPais($paises,$indice);
				}

				//grava no banco de dados
				$this->usuario->gravarDados();
				$this->computador->gravarDados($this->usuario->getId());
			}
		}
		//remove pais do array com referencia 
		private function removerPais(&$array,$indice){
			$newArray = array();
			foreach($array as $value)
			{
				if( $value != $indice )
				{
					array_push($newArray, $value);
				}
			}
			$array = $newArray;
		}

		//verifica se o pais de origem faz fronteira com o de destino
		public function isFronteira($origem,$destino)
		{
			$retorno = false;
			switch ($origem) {

				case 'Brasil':
						if(($destino == 'Colombia')||($destino == 'Argentina')||($destino == 'Egito'))
						{
					
							$retorno = true;
						}
					break;
				case 'Africa do Sul':
						if($destino == 'Egito')
						{
							$retorno = true;							
						}
				break;	
				case 'Colombia':
					if(($destino == 'Brasil') || ($destino == 'Mexico') || ($destino == 'Argentina'))
					{
						$retorno = true;	
					}
				break;
				case 'Argentina':
					if(($destino == 'Brasil') || ($destino== 'Colombia'))
					{
						$retorno = true;	
					}
					break;
				case 'Mexico':
					if(($destino == 'Eua')||($destino == 'Colombia'))
					{
						$retorno = true;	
					}
					break;
				case 'Eua':
					if(($destino == 'Mexico') || ($destino == 'Russia') ||($destino == 'Reino Unido'))
					{
						
						$retorno = true;	

					}
					break;
				case 'Reino Unido':
					if(($destino == 'Eua') ||($destino == 'Franca') ||($destino == 'Alemanha'))
					{
						$retorno = true;	
					}					
					break;
				case 'Russia':
					if(($destino == 'Alemanha') ||($destino == 'China') || ($destino == 'Eua'))
					{
						$retorno = true;	
					}					
					break;
				case 'Alemanha':
					if(($destino == 'Franca') ||($destino == 'Reino Unido')||($destino == 'Egito') || ($destino == 'Russia'))
					{
						$retorno = true;	
					}					
					break;
				case 'Franca':
					if(($destino == 'Alemanha') || ($destino == 'Reino Unido') || ($destino == 'Egito'))
					{
						$retorno = true;	
					}
					break;
				case 'China':
					if(($destino == 'Russia'))
					{
						$retorno = true;	
					}
					break;
				case 'Egito':
					if(($destino == 'Franca') || ($destino == 'Alemanha')
					 || ($destino == 'Brasil') ||($destino == 'Africa do Sul'))
					{
						$retorno = true;
					}					
					break;
			}
			return $retorno;
		}


		//faz o sorteio de 0 a 10 (ataque contra o inimigo, se for maior q 5 ele ganha o ataque)
		public function ataqueUsuario($origem,$destino)
		{
				session_start();
				unset($_SESSION['aviso']['erro']);
				$retorno = false;
				$num_ataque = array(0,1,2,3,4,5,6,7,8,9,10);
				echo $ataque = $num_ataque[array_rand($num_ataque)];
				
				if($origem == "" ){
					$_SESSION['aviso']['erro'] = "[AVISO] Selecione um pais de origem !!";
				}else
				if($this->isFronteira($origem,$destino)){
					
					if($ataque > 5){

						$this->computador->removeExercito($destino);
						$_SESSION['aviso']['ataque_user'] = "Você ganhou o ataque de ".$origem."<br>contra o ".$destino;
						$_SESSION['aviso']['ataque_user_cpu'] = "Seu território ".$destino." perdeu a batalha<br>contra os exercitos de ".$origem;
						if($this->computador->getTerritorio($destino) == 0){

							$this->computador->removerPais($destino);
							$this->usuario->setTerritorios($destino,1);
							$_SESSION['aviso']['ataque_user'] = "Você ganhou o território ".$destino."<br>com os exercitos de ".$origem;
							$_SESSION['aviso']['ataque_user_cpu'] = "Perdeu seu território ".$destino."<br>para os exercitos de ".$origem;

						}
					}else{
						$this->usuario->removeExercito($origem);
						$_SESSION['aviso']['ataque_user'] = "Você Perdeu o ataque de ".$origem."<br>contra o ".$destino;
						$_SESSION['aviso']['ataque_user_cpu'] = "Ganhou o ataque de ".$origem."<br>contra o ".$destino;
						if($this->usuario->getTerritorio($origem) == 0){

							$this->usuario->removerPais($origem);
							$this->computador->setTerritorios($origem,1);
							$_SESSION['aviso']['ataque_user'] = "Você perdeu o territorio ".$origem."<br>para o exercito do território ".$destino;
							$_SESSION['aviso']['ataque_user_cpu'] = "Ganhou o territorio ".$origem."<br>com os exercitos de ".$destino;
						}
					}
						$this->usuario->salvarDados();
						$this->computador->salvarDados($this->usuario->getId());
						$retorno = true;
				}else{		
					$_SESSION['aviso']['erro'] = "[AVISO] O pais de origem selecionado não faz fronteira com o pais de destino !!";
				}
				return $retorno;
		}

		public function ataqueCPU($origem,$destino)
		{
				session_start();
				
				$num_ataque = array(0,1,2,3,4,5,6,7,8,9,10);
				$ataque = $num_ataque[array_rand($num_ataque)];
				
				if($this->isFronteira($origem,$destino)){
					if($ataque > 5){

						$this->usuario->removeExercito($destino);
						$_SESSION['aviso']['ataque_cpu'] = "Ganhou o ataque de ".$origem."<br>contra o ".$destino;
						$_SESSION['aviso']['ataque_cpu_user'] = "Seu território ".$destino."perdeu a batalha<br>contra os exercitos de ".$origem;
						if($this->usuario->getTerritorio($destino) == 0){

							$this->usuario->removerPais($destino);
							$this->computador->setTerritorios($destino,1);
							$_SESSION['aviso']['ataque_cpu'] = "Ganhou o território ".$destino."<br>com os exercitos de ".$origem ;
							$_SESSION['aviso']['ataque_cpu_user'] = "Você perdeu o território ".$destino."<br>para os exercitos de ".$origem;
						}

					}else{

						$this->computador->removeExercito($origem);
						$_SESSION['aviso']['ataque_cpu'] = "Perdeu o ataque de ".$origem."<br>contra o ".$destino;
						$_SESSION['aviso']['ataque_cpu_user'] = "Você ganhou a batalha contra ".$origem."<br>com os exercitos de ".$destino;
						if($this->computador->getTerritorio($origem) == 0){

							$this->computador->removerPais($origem);
							$this->usuario->setTerritorios($origem,1);
							$_SESSION['aviso']['ataque_cpu'] = "Perdeu o territorio ".$origem."<br>para os exercitos de ".$destino;
							$_SESSION['aviso']['ataque_cpu_user'] = "Você ganhou o território ".$origem."<br>com os exercitos de ".$destino;
						}	
					}
				}

				$this->computador->salvarDados($this->usuario->getId());
				$this->usuario->salvarDados();
		}
		/*
			Esse algoritmo dará vida para o computador decidir onde jogar
			O metodo deverá fazer um calculo com base nos territórios do computador e verificar com os territórios inimigos que fazem fronteiras e subtrair os exercitos, no qual ele tiver mais vantagem será onde ele irá atacar
		*/
		public function maiorVantagem() : array
		{
			$origem = "";
			$destino = "";
			$exercitos = 0;

			foreach ($this->computador->getTerritorios() as $key_cp => $value_cp) {
				
				foreach ($this->usuario->getTerritorios() as $key_pl => $value_pl) {
					
					if($this->isFronteira($key_cp,$key_pl)){


						if(($value_cp - $value_pl) >= $exercitos){

							$exercitos = ($value_cp - $value_pl);
							$origem = $key_cp;
							$destino = $key_pl;
						}
					}

				}
			}

			$array['origem_cpu'] = $origem;
			$array['destino_cpu'] = $destino;
			return $array;
		}

		/*
			responsavel por sortear de 1 a 6 exercitos em paises aleatórios do usuario
			e do computador

			obs: é obrigatório adicionar 6 exercitos por rodada, o algoritimo devera decidir
			qual o valor de execitos de 1 a 6 em paises aleatorios,( ex: 1 para o brasil, 4 para colombia e mais 1 para eua)
		*/
		public function sortearExercitos()
		{	
			$territorios_cpu = $this->computador->getTerritorios();
			$territorios_usuario = $this->usuario->getTerritorios();

			$territorio_cpu = array_rand($territorios_cpu);
			$this->computador->addExercito($territorio_cpu,6);
			$territorio_usuario = array_rand($territorios_usuario);
			$this->usuario->addExercito($territorio_usuario,6);

			$this->computador->salvarDados($this->usuario->getId());
			$this->usuario->salvarDados();
		}

		//verifica se houve algum vencedor da partida toda
		public function isVencedor()
		{
			$retorno = false;
			if( (count($this->usuario->getTerritorios()) == 12) || (count($this->computador->getTerritorios()) == 12)){
				$retorno = true;
			}
			return $retorno;
		}
		//responsavel por deletar todos os dados referente a partida finalizada no banco de dados
		public function zerarPartida(){

			$objBD = new Bd();
			$mysqli = $objBD->conecta_mysql();
			
			try{

				$mysqli->begin_transaction();
				$sql = "delete from partida_territorio where usuario = ?";
			
					if($stmt = $mysqli->prepare($sql)){
						$id = $this->usuario->getId();
						$stmt->bind_param("i",$id);
						$stmt->execute();
					}

					$mysqli->commit();

			}catch(Exception $e){
				$mysqli->rollback();
			}
			$mysqli->close();
		}
		/*
		*esse metodo carrega os dados do banco de dados no inicio da partida	
		*
		*/
		public function carregarDados(){

			$this->usuario->zerar();
			$this->computador->zerar();

			$objBD = new Bd();
			$mysqli = $objBD->conecta_mysql();
			$sql = "SELECT territorio,cpu, exercitos from partida_territorio where usuario = ?";

			if($stmt = $mysqli->prepare($sql)){
				$id_usuario = $this->usuario->getId();
				$stmt->bind_param('i',$id_usuario);
				$stmt->execute();
				$stmt->bind_result($territorio,$cpu,$exercitos);
					
				while($stmt->fetch()) 
				{
					  if($cpu){

					  	$this->usuario->setTerritorios($territorio,$exercitos);
					  }else{
					  	$this->computador->setTerritorios($territorio,$exercitos);
					  }

				}
				$stmt->close();
			}
			$mysqli->close();
		}

		public function colorirPais($pais){
			$retorno = "gray";

			if($this->usuario->isPais($pais)){
				$retorno = "green";
			}

			return $retorno;
		}

		public function mostrarExercitos($pais){
			$exercitos = 0;
			if($this->usuario->isPais($pais)){
				$exercitos = $this->usuario->getTerritorio($pais);
			}else{
				$exercitos = $this->computador->getTerritorio($pais);				
			}
			return $exercitos;
		}
	}
 ?>