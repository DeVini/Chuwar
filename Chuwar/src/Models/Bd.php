<?php
	
	/**
	 * Classe de Configuração do banco de dados 
	 */
	class Bd 
	{
	
		private $host = 'p:127.0.0.1';

		private $usuario = 'root';

		private $senha = 'root';

		private $database = 'chuwarbd';

		public function table_usuarios(){

			$mysqli = $this->conecta_mysql();	
				$sql = "
						create  table if not exists usuarios
						(
							idUsuario int primary key not null auto_increment,
						    username varchar(20) not null unique,
							password varchar(50) not null
						);
						";
			$mysqli->query($sql);
			$mysqli->close();
		}

		public function table_territorios_user(){
			$mysqli = $this->conecta_mysql();
				$sql = "
						create table if not exists partida_territorio
						(
							idPartida_Territorio int primary key not null auto_increment,
							usuario int not null,
						    territorio varchar(20) not null,
						    cpu boolean not null,
						    exercitos int not null,
						    foreign key (usuario) references usuarios (idUsuario)
						);";
				
			$mysqli->query($sql);				
			$mysqli->close();
		}

		public function conecta_mysql(){
			$con = new \mysqli($this->host,$this->usuario,$this->senha,$this->database);
			mysqli_set_charset($con,'utf8');

			if(mysqli_connect_errno())
			{
				echo 'Erro ao tentar se conectar com o BD MySql: '.mysqli_connect_error();
			}
			return $con;
		}
 	}
 ?>