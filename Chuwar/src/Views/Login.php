<?php
	
	require_once('../Models/Bd.php');
	require_once('../Models/Usuario.php');
	 
	 $bd = new Bd();

	 $bd->table_usuarios();
	 $bd->table_territorios_user();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login - ChuWar</title>
</head>
<body>
	<form id="" action="../controllers/logar.php" method="post">
		<center>
			<div id="login">
				<div>
				<label for="username">Username:</label> 
				<input id="username" type="text" name="username">
				<label for="username">Senha:</label> 
				<input type="password" name="password">
				<input type="submit" name="" value="Logar">
				<br><br>
				<a href="Cadastro.php">Cadastre-se</a>
			</div>
		</center>
	</form>
</body>
</html>