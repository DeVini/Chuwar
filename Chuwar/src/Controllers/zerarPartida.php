<?php  
	require_once('../models/Jogador.php');
	require_once('../models/Usuario.php');
	require_once('../models/Computador.php');
	require_once('../models/Chuwar.php');
	session_start();
	$chuwar = unserialize($_SESSION['chuwar']);
	$chuwar->carregarDados();	

	if ($chuwar->isVencedor()) {
		session_start();
			if( isset($_SESSION['aviso']['ataque_user']) && isset($_SESSION['aviso']['ataque_cpu_user']) && isset($_SESSION['aviso']['ataque_cpu']) && isset($_SESSION['aviso']['ataque_user_cpu']) ){
							unset($_SESSION['aviso']['ataque_cpu']);
							unset($_SESSION['aviso']['ataque_user']);
							unset($_SESSION['aviso']['ataque_user_cpu']);
							unset($_SESSION['aviso']['ataque_cpu_user']);

			}

			if (isset($_SESSION['aviso']['erro'])) {
				unset($_SESSION['aviso']['erro']);
			}
		$chuwar->zerarPartida();
		header('Location: ../Views/Partida.php');
	}
?>