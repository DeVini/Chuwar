<?php
	
	require_once('../Models/Usuario.php');
	session_start();

	$usuario = $_POST['username'];
	$senha = md5($_POST['password']);
	$user = new Usuario();

	if(!$user->userExist($usuario)){
		$user->cadastrar($usuario,$senha);
		echo "Cadastrado com sucesso";
		header('Location: ../Index.php');
	}else{
		echo "Não foi possivel cadastrar o Usuario pois esse username já foi cadastrado !!";
		echo "<a href='../views/Cadastro.php'>Tente novamente</a>";
	}
 ?>