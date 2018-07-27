<?php
	require_once('../Models/Usuario.php');
	require_once('../Models/Chuwar.php');
	session_start();
	if(!isset($_SESSION['usuario']['username'])){
		     header('Location: ../Views/Index.php');
	}

	$chuwar = unserialize($_SESSION['chuwar']);
	$chuwar->sortearPaises();
	$chuwar->carregarDados();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Partida - ChuWar</title>
	
	<!-- jquery - link cdn -->
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

	<script type="text/javascript">
		
		function novoJogo() 
		{
    		window.location.replace("../controllers/zerarPartida.php");
		}

		function logout()
		{
			window.location.replace("../controllers/logout.php");
		}

	</script>
</head>
<body>
	<form id="" action="../controllers/atacar.php" method="post">
	<br>
	<br>
	<center>
	<?php
		if($chuwar->isVencedor()){
			echo "<input type='button' onclick= 'novoJogo()'  value='Começar novo jogo'>";
		}
	?>
	<input type="button" name="" onclick="logout();" value="Sair do Jogo">
	<?php  
		if(isset($_SESSION['aviso']['erro'])){
			echo "<br><br>".$_SESSION['aviso']['erro'];
		}
	 ?>
		<table cellpadding="40">
			<tr>
				<td valign="top">
					<div id="player" >
						<?php
							if($chuwar->isVencedor()){
								
								echo ( count($chuwar->getUsuario()->getTerritorios()) > count($chuwar->getComputador()->getTerritorios()))?"Ganhador !!":"Perdedor !!";
							}
						?>

						<div style=" border: 5px double green;">
							<img src="img/player.png" width="100px" height="150px" >
							<br>
							<center><strong >Player</strong></center>
						</div>
						
						 <?php  
							if(isset($_SESSION['aviso']['ataque_user']) && isset($_SESSION['aviso']['ataque_cpu_user'])){
								echo "<br><br><small><b>Seu Ataque</b><br>".$_SESSION['aviso']['ataque_user'];
								echo "<br><br><b>Ataque do Inimigo</b><br>".$_SESSION['aviso']['ataque_cpu_user']."</small>";
							}
						 ?>
						
						<br>
						<br>
						<b>Territórios:</b> <?php echo count($chuwar->getUsuario()->getTerritorios()); ?>
						<br>
						<b>Total de Exercitos:</b> <?php echo $chuwar->getUsuario()->totalExercitos();  ?>
						<br>
						<br>
						<b>Pais de Origem:</b>
						<br>

						<?php 
							foreach ($chuwar->getUsuario()->getTerritorios() as $key => $value) {
								
								echo "<input id='$key' type='radio' name='origem' value='$key'> $key";
								echo "<br>";
							}
						 ?>
						


					</div>
				</td>
				<td>
					<div id="tabuleiro">
						<table border="1" cellspacing="0" cellpadding="40">
							<tr>
				   				<td style= "background-color: <?php echo $chuwar->colorirPais('Colombia'); ?>;" rowspan="2" colspan="2">
				   					Colombia&nbsp;<span><?php echo $chuwar->mostrarExercitos('Colombia'); ?></span>
				   					 <br>
				   					 <?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Colombia') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='COLOMBIA' name='COLOMBIA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				   				</td>

				   				<td style= "background-color: <?php echo $chuwar->colorirPais('Argentina'); ?>;">
				   					Argentina&nbsp;<span><?php echo $chuwar->mostrarExercitos('Argentina'); ?></span><br>
				   					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Argentina') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='ARGENTINA' name='ARGENTINA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				   				</td>

				   				<td colspan="4" style="background: blue;"></td>

				   				<td rowspan="" style= "background-color: <?php echo $chuwar->colorirPais('Africa do Sul'); ?>;">
				   					Africa do Sul&nbsp;<span><?php echo $chuwar->mostrarExercitos('Africa do Sul'); ?></span>
				   					<br>
				   					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Africa do Sul') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='AFRICA' name='AFRICA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				   				</td>
				  			</tr>
				  			<tr>
				  				<td colspan="4" style= "background-color: <?php echo $chuwar->colorirPais('Brasil'); ?>;">
				  					Brasil&nbsp;<span><?php echo $chuwar->mostrarExercitos('Brasil'); ?></span>
				  					<br>
				  					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Brasil') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='BRASIL' name='BRASIL' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				  				</td>
				   				<td  rowspan="3" colspan="2" style= "background-color: <?php echo $chuwar->colorirPais('Egito'); ?>;">
				   					Egito&nbsp;<span><?php echo $chuwar->mostrarExercitos('Egito'); ?></span>
				   					<br>
				   					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Egito') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='EGITO' name='EGITO' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				   				</td>
				  			</tr>
				  			<tr>
				  				<td style= "background-color: <?php echo $chuwar->colorirPais('Mexico'); ?>;">
				  					Mexico&nbsp;<span><?php echo $chuwar->mostrarExercitos('Mexico'); ?></span>
				  					<br>
				  					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Mexico') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='MEXICO' name='MEXICO' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				  				</td>
				  				<td colspan="4" style="background: blue;"></td>
							
				  			</tr>
				  			<tr>
				  				<td rowspan="3" style= "background-color: <?php echo $chuwar->colorirPais('Eua'); ?>;">
				  					Eua&nbsp;<span><?php echo $chuwar->mostrarExercitos('Eua'); ?></span>
				  					<br>
				  					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Eua') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='EUA' name='EUA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				  				</td>
				   				<td colspan="3" style= "background-color: <?php echo $chuwar->colorirPais('Reino Unido'); ?>;">
				   					Reino Unido&nbsp;<span><?php echo $chuwar->mostrarExercitos('Reino Unido'); ?></span>
				   					<br>
				   					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Reino Unido') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='REINO' name='REINO' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				   				</td>
				 				<td style= "background-color: <?php echo $chuwar->colorirPais('Franca'); ?>;">
				 					Franca&nbsp;<span><?php echo $chuwar->mostrarExercitos('Franca'); ?></span>
				 					<br>
				 					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Franca') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='FRANCA' name='FRANCA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				 				</td>
				  			</tr>
				  			<tr>
				  				<td colspan="1" style="background: blue;"></td>	
				   				<td colspan="13" rowspan="2" style= "background-color: <?php echo $chuwar->colorirPais('Alemanha'); ?>;">
				   					Alemanha&nbsp;<span><?php echo $chuwar->mostrarExercitos('Alemanha'); ?></span>
				   					<br>
				   					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Alemanha') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='ALEMANHA' name='ALEMANHA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				   				</td>
				  			</tr>
				  			<tr>
				  				<td style= "background-color: <?php echo $chuwar->colorirPais('Russia'); ?>;">
				  					Russia&nbsp;<span><?php echo $chuwar->mostrarExercitos('Russia'); ?></span>
				  					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('Russia') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='RUSSIA' name='RUSSIA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				  					<br>
				  				</td>
				  			</tr>
				  			<tr>
				  				<td colspan="1" style="background: blue;"></td>
				  				<td style= "background-color: <?php echo $chuwar->colorirPais('China'); ?>;">
				  					China&nbsp;<span><?php echo $chuwar->mostrarExercitos('China'); ?></span>
				  					<br>
				  					<?php 
				   					 	if(!$chuwar->getUsuario()->isPais('China') && !$chuwar->isVencedor()){
												echo  "<input type='submit' id='CHINA' name='CHINA' value='Atacar'>"; 
				   					 	}	   					 	
				   					 ?>
				  				</td>
				  				<td colspan="13" style="background: blue;"></td>
				  			</tr>
						</table>
					</div>
				</td>
				<td valign="top">
					<div id="computador" >
						<?php
							if($chuwar->isVencedor()){							
								echo ( count($chuwar->getUsuario()->getTerritorios()) < count($chuwar->getComputador()->getTerritorios()))?"Ganhador !!":"Perdedor !!";
							}
						?>
						<div style=" border: 5px double gray;">
							<img src="img/computador.png" width="100px" height="150px" >
							<br>
							<center><strong>Computador</strong></center>
						</div>
						 <?php  
							if(isset($_SESSION['aviso']['ataque_cpu']) && isset($_SESSION['aviso']['ataque_user_cpu'])){
								echo "<br><br><small><b>Ataque do Inimigo</b><br>".$_SESSION['aviso']['ataque_user_cpu'];
								echo "<br><br><b>Seu Ataque</b><br>".$_SESSION['aviso']['ataque_cpu']."</small>";
							}
						 ?>
						<br>
						<br>
						<b>Territórios:</b> <?php echo count($chuwar->getComputador()->getTerritorios()); ?>
						<br>
						<b>Total de Exercitos:</b> <?php echo $chuwar->getComputador()->totalExercitos();  ?>
						
					</div>
				</td>
			</tr>
	</table>
	
	</center>
	</form>
</body>
</html>