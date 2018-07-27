<?php
	
	require_once('../Models/Usuario.php');
	require_once('../Models/Chuwar.php');
	session_start();

	$usuario = $_POST['username'];
	$senha = md5($_POST['password']);
	$user = new Usuario();

	$id = $user->isLogar($usuario,$senha);
	if($id > 0){	

		$_SESSION['usuario']['username'] = $usuario;
		$_SESSION['usuario']['password'] = $senha;
		$_SESSION['usuario']['id'] = $id;
		$chuwar = new Chuwar();
		$_SESSION['chuwar'] = serialize($chuwar);
			
		header('Location: ../Views/Partida.php');

	}else{
		echo '<center>Usuario e senha não cadastrado !!';
		echo "<br><a href='../Index.php'>Voltar para a tela de login</a></center>";
		if(isset($_SESSION['usuario']['username']) && isset($_SESSION['usuario']['password'])){
			
			unset($_SESSION['usuario']['username']);
			unset($_SESSION['usuario']['password']);
		}
	}
 ?>