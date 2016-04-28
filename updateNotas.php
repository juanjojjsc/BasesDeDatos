<?php

	//incluir index.php

	//Iniciar la sesion nos va a dejar saber cual es el id del usuario actual
	session_start();

	if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {

		$_SESSION['id'] = $_COOKIE['id'];

	}

	if(array_key_exists("content", $_POST)) {

		$usuario_actual = $_SESSION['id'];
		

		//conexion a DB
		include("connection.php");

		//$query = "UPDATE `notas` WHERE id_u = $usuario_actual SET `contenido` = '".mysqli_real_escape_string($link,$_POST['content'])."' WHERE id = ".mysqli_real_escape_string($link,$_SESSION['id'])." LIMIT 1 ";
		$query = "UPDATE `notas` SET `contenido` = '".mysqli_real_escape_string($link,$_POST['content'])."' WHERE id_u = ".mysqli_real_escape_string($link,$_SESSION['id'])." LIMIT 1 ";

		if (mysqli_query($link,$query)) {
			echo "Todos los cambios han sido guardados en la nube.";
		} else {
			echo "Error al guardar los cambios en la nube.";
		}

		mysqli_query($link,$query);



		$query = "INSERT INTO `log` (`contenido`,`id_n`,`creado`) VALUES('".mysqli_real_escape_string($link,$_POST['content'])."',$usuario_actual,'2016-02-02')";
		mysqli_query($link,$query);


		//$query = "INSERT INTO `log` (`id_n`,`contenido`,`creado`) VALUES($usuario_actual,$_POST['content'],'2016-04-28')";




		//$query = "UPDATE `log` SET `contenido` = '".mysqli_real_escape_string($link,$_POST['content'])."' WHERE id_n = ".mysqli_real_escape_string($link,$_SESSION['id'])." LIMIT 1 ";
		//$query = "UPDATE `log` WHERE id_l = '1' SET `contenido` = '".mysqli_real_escape_string($link,$_POST['content'])."' LIMIT 1 ";

		//mysqli_query($link,$query);













		

	}


?>