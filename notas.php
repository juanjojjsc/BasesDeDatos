<?php

	//empezar sesion para cookies
	
	session_start();
	//buscar cookie en array de cookies
	if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {

		$_SESSION['id'] = $_COOKIE['id'];

	}

	$notasDescargadas = "";
	$usuarioDescargado = "";

	//si la sesion esta iniciada
	if (array_key_exists("id", $_SESSION) && $_SESSION['id']) {

		//creamos una ruta de regreso para log out
		//echo "<p>Sesion Iniciada <a href='index.php?logout=1'>Cerrar Sesión</a></p>";

		//Dejar escrito lo que ya estaba guardado en la DB
		include("connection.php");

		$query = "SELECT contenido FROM `notas` WHERE id_u = ".mysqli_real_escape_string($link,$_SESSION['id'])." LIMIT 1";

		$notas = mysqli_fetch_array(mysqli_query($link, $query));

		$notasDescargadas = $notas['contenido'];
		//$usuarioDescargado = $user['email'];

		//hace fata query para el email de la tabla usuarios


	} else {

		//Si la sesion no esta iniciada, sacarlos a la home screen
		//Es para evitar que pongas en el browser /notas.php y entre.
		//Solo puedes acceder a las notas si la sesion esta iniciada
		header("Location: index.php");

	}


	//Incluir estilos
	include("header.php");
	?>



	<nav class="navbar navbar-light bg-faded navbar-fixed-top">
		<a class="navbar-brand" href="#" id="usuario"><?php echo $usuarioDescargado; ?></a>
		<div class="pull-xs-right">
			<a href='index.php?logout=1'><button class="btn btn-success-outline" type="submit">Cerrar Sesión</button></a>
		</div>
	</nav>


	<div class="container-fluid" id="contenidoNotas">

		<h1 id="titulo2">Mis Notas Tec</h1>

		<p id="cambios">Todos los cambios han sido guardados en la nube.</p>

		<textarea id="notas" class="form-control"><?php echo $notasDescargadas; ?></textarea>

		

	</div>

	<div>
		<button type="button" class="logbutt" onclick="window.location='http://176.32.230.48/misnotastec.com/log.php'">Access Log</button>
	</div>



	<?php include("footer.php"); ?>






