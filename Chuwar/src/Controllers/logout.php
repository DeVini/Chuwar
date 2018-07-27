<?php
	session_start();
	
	if(isset($_SESSION['usuario']['username'])){
			unset($_SESSION['usuario']['username']);
			unset($_SESSION['usuario']['password']);
			header('Location: ../Index.php');
			
			if( isset($_SESSION['aviso']['ataque_user']) && isset($_SESSION['aviso']['ataque_cpu_user']) && isset($_SESSION['aviso']['ataque_cpu']) && isset($_SESSION['aviso']['ataque_user_cpu']) ){
							unset($_SESSION['aviso']['ataque_cpu']);
							unset($_SESSION['aviso']['ataque_user']);
							unset($_SESSION['aviso']['ataque_user_cpu']);
							unset($_SESSION['aviso']['ataque_cpu_user']);

			}
			if (isset($_SESSION['aviso']['erro'])) {
				unset($_SESSION['aviso']['erro']);
			}
	}
?>