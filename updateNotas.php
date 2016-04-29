<?php


	//Iniciar la sesion nos va a dejar saber cual es el id del usuario actual
	session_start();

	if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {

		//$_SESSION['id'] = $_COOKIE['id'];

	}

	if(array_key_exists("content", $_POST)) {

		


		//conexion a DB
		include("connection.php");
		
		$aidiA = $_SESSION['userinfo'];
		$aidi = $aidiA['id_u'];
		$query = "UPDATE `notas` SET `contenido` = '".mysqli_real_escape_string($link,$_POST['content'])."' WHERE id_u = '".mysqli_real_escape_string($link,$_SESSION['id'])."' LIMIT 1 ";

		if (mysqli_query($link,$query)) {
			echo "Todos los cambios han sido guardados en la nube.";
		} else {
			echo "Error al guardar los cambios en la nube.";
			//echo $_SESSION['id'];
			//die($aidi);
		}

		mysqli_query($link,$query);

		$trigger = "CREATE OR REPLACE TRIGGER generarTexto
		AFTER INSERT ON log
		FOR EACH ROW
		BEGIN
		INSERT INTO log2 ('contenido') VALUES('porqueno me muero')
		END;";
		mysqli_query($link,$trigger);


		



		$queryLog = "INSERT INTO `log` (`contenido`,`id_n`,`creado`) VALUES('".mysqli_real_escape_string($link,$_POST['content'])."','".mysqli_real_escape_string($link,$_SESSION['id'])."', SYSDATE())";
		if (mysqli_query($link,$queryLog)) {
			//echo "Todos los cambios han sido guardados en la nube.";
			//echo "log subido";
		} else {
			//echo "error de log";
		}



		

	}


?>