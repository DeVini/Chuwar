<?php
	require_once('../models/Bd.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login - ChuWar</title>
</head>
<body>
	<form id="" action="../controllers/cadastrar.php" method="post">
		<center>
			<div id="login">
				<div>
				<label for="username">Username:</label> 
				<input id="username" type="text" name="username">
				<label for="username">Senha:</label> 
				<input type="password" name="password">
				<input type="submit" name="" value="Cadastrar">
				<br><br><br>
				<a href="../Index.php">Voltar para a tela de login</a>
			</div>
		</center>
	</form>
</body>
</html>