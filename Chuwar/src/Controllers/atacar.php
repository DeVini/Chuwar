<?php
	
	require_once('../Models/Usuario.php');
	require_once('../Models/Chuwar.php');
	session_start();
	$chuwar = unserialize($_SESSION['chuwar']);
	$chuwar->carregarDados();	

	$destino = "";
	$origem = $_POST['origem'];
	if(isset( $_POST['ARGENTINA'])){
		$destino = 'Argentina';
	}else 
	if(isset( $_POST['COLOMBIA'])){
		$destino = 'Colombia';
	}else 

	if(isset( $_POST['BRASIL'])){
		$destino = 'Brasil';
	}else 

	if(isset( $_POST['MEXICO'])){
		$destino = 'Mexico';
	}else 

	if(isset( $_POST['EGITO'])){
		$destino = 'Egito';
	}else 

	if(isset( $_POST['EUA'])){
		$destino = 'Eua';
	}else 

	if(isset( $_POST['RUSSIA'])){
		$destino = 'Russia';
	}else 

	if(isset( $_POST['REINO'])){
		$destino = 'Reino Unido';
	}else 

	if(isset( $_POST['ALEMANHA'])){
		$destino = 'Alemanha';
	}else 

	if(isset( $_POST['FRANCA'])){
		$destino = 'Franca';
	}else 

	if(isset( $_POST['AFRICA'])){
		$destino = 'Africa do Sul';
	}else 
	if(isset( $_POST['CHINA'])){
		$destino = 'China';
	}

	if( isset($_SESSION['aviso']['ataque_user']) && isset($_SESSION['aviso']['ataque_cpu_user']) && isset($_SESSION['aviso']['ataque_cpu']) && isset($_SESSION['aviso']['ataque_user_cpu']) ){
							unset($_SESSION['aviso']['ataque_cpu']);
							unset($_SESSION['aviso']['ataque_user']);
							unset($_SESSION['aviso']['ataque_user_cpu']);
							unset($_SESSION['aviso']['ataque_cpu_user']);
	}
	
	if(!$chuwar->isVencedor()){
			if($chuwar->ataqueUsuario($origem,$destino)){

				$chuwar->carregarDados();
				$array_cpu = $chuwar->maiorVantagem(); 
				$origem_cpu = $array_cpu['origem_cpu'];
				$destino_cpu = $array_cpu['destino_cpu'];
				$chuwar->ataqueCPU($origem_cpu,$destino_cpu);
				//$chuwar->sortearExercitos();

			}
	}
	//
	header('Location: ../Views/Partida.php');
 ?>