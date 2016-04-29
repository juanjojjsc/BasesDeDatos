<?php 

	$error = "";
	include("header.php");


	if (array_key_exists("submit", $_POST)) {

		if (!$_POST['email']) {

			$error .= "Ingresa tu correo electrónico.<br>";

		}

		if (!$_POST['password']) {

			$error .= "Ingresa tu contraseña.<br>";

		}

		if ($error != "") {

			$error = "<p> Errores de autenticación:</p>".$error;

		} else {


			
			$query1 = "CREATE USER 'admin@admin.com'@'localhost' IDENTIFIED BY 'admin'";
			$query2 = "GRANT ALL ON cl59-misnotas.* TO 'admin@admin.com'@'localhost'";
			
			mysqli_query($link,$query1);
			mysqli_query($link,$query2);

			// Si no hay errores de que este vacio
			if ($_POST['email'] == 'admin@admin.com' && $_POST['password'] == 'admin')
			{
				header("Location: bd.php");
			}






		}



	}










?>

<html>
<head>
	<title>Admin Log In</title>
</head>
<body>

	<!-- ADMIN -->

		<div class="container" id="logInContainer">

  		<div id="fondo">
			<div id="error"><?php if ($error != "") {
	  			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
	  		}
	  		?></div>

			<div>
				<form method="post" id="adminForm">
				<p class="instrucciones">Inicio de Sesion para Admin</p>
				<fieldset class="form-group">
					<input class="form-control" type="email" name="email" placeholder="Correo electronico">
				</fieldset>
				<fieldset class="form-group">
					<input class="form-control" type="password" name="password" placeholder="Contraseña">
				</fieldset>
				<fieldset class="form-group">
					<input type="hidden" name="registrar" value="1">
					<input class="btn btn-success" type="submit" name="submit" value="Iniciar Sesion">
				</fieldset>
			</form>
			</div>

			<button type="button" class="logbutt" onclick="window.location='http://176.32.230.48/misnotastec.com/index.php'">Regresar</button>
			</div>



		</div>


</body>
</html>