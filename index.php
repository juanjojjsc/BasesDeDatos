<?php
	
	//start cookies
	session_start();

	$error = "";

	//Si estamos de regreso desde un logout
	if (array_key_exists("logout", $_GET)) {
		//borrar cookie
		unset($_SESSION);
		setcookie("id", "", time() - 60*60);
		$_COOKIE["id"] = "";

	} else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {

		//Si ya esta Iniciada la sesion, brincarnos la pantalla de Log In
		header("Location: notas.php");

	}


	if (array_key_exists("log", $_POST)) {
		//Redireccionar a pagina de notas
		header("Location: log.php");
	}

	// Inicio de Admin-->
// 	$query = "CREATE USER 'admin@gmail.com' IDENTIFIED BY 'password'"
// $admin = mysqli_query($link,$query);
// $query = "GRANT ALL ON cl59-misnotas.* TO 'admin@gmail.com'"
// $admin = mysqli_query($link,$query);

// $query = "SELECT * FROM `admins` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
// $result = mysqli_query($link,$query);
// $userA = mysqli_fetch_array($result);

if (isset($user)) {
		
					if($userA['password'] == 'password') {
						header("Location: admin.php");

					} else {
						$error = "Contraseña incorrecta.";
					}
				} else {
					$error = "Usuario y/o contraseña incorrectos.";

	if (array_key_exists("submit", $_POST)) {

		//archivo externo que maneja la conexion a la DB
		include("connection.php"); 


		if (!$_POST['email']) {

			$error .= "Ingresa tu correo electrónico.<br>";

		}

		if (!$_POST['password']) {

			$error .= "Ingresa tu contraseña.<br>";

		}

		if ($error != "") {

			$error = "<p> Errores de autenticación:</p>".$error;

		} else {

			//Checar si estamos en estado Registro o Inicio de Sesion
			if ($_POST['registrar'] == '1') {

				//Si estamos en registro

				//Checar que ese usuario este disponible

				$query = "SELECT id_u FROM `users` WHERE email_u = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

				$result = mysqli_query($link, $query);

				//Si encontro algo, siginica que ya existe
				if (mysqli_num_rows($result) > 0) {

					$error = "Direccion de correo ya tomada.";

				} else {

					//Si no encontro nada, podemos registrar ese usuario
					$query = "INSERT INTO `users` (`email_u`,`password_u`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."','".mysqli_real_escape_string($link, $_POST['password'])."')";

					if(!mysqli_query($link,$query)) {

						$error = "<p>Error al registrar. Intente más tarde.</p>";

					} else {



						//Encriptar la password usando md5 hash usando como SALT el id del ultimo objeto insertado
						$query = "UPDATE `users` SET password_u = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id_u = ".mysqli_insert_id($link)." LIMIT 1";
						//$query = "UPDATE `users` SET password_u = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id_u = ".$_COOKIE['id'])."  LIMIT 1";
						echo md5(md5(mysqli_insert_id($link)).$_POST['password']);

						mysqli_query($link,$query);

						//Creamos una cookie usando el id (de la BD) de nuestro usuario
						$_SESSION['id'] = mysqli_insert_id($link);

						//Si han pedido ser recordados
						if ($_POST['stayLoggedIn'] == '1') {

							setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);

						}

						//Redireccionar a pagina de notas
						header("Location: notas.php");
					}


				}
			} else {
				//Si estamos en Inicio de Sesion
				

				//Checar que los datos ingresados sean correctos
				
				//Primero checar el email
				$query = "SELECT * FROM `users` WHERE email_u = '".mysqli_real_escape_string($link, $_POST['email'])."'";
				//Obtener el id, y usarlo como salt para DESencriptar la contraseña
				$result = mysqli_query($link,$query);
				//Crear un array con los datos del username que se requesteo
				$user = mysqli_fetch_array($result);
				//extraer el id del arreglo solo si $user existe
				if (isset($user)) {
					//Encriptar lo que nos dio el usuario

					echo $_POST['password'];
					echo "<br />";
					echo md5(md5($user['id_u']).$_POST['password']);
					echo "<br />";
					$hashedPwd = md5(md5($user['id_u']).$_POST['password']);

					echo $hashedPwd;
echo "<br />";

					//checar que coincidan la contrasena dada con la de la BD
					if($hashedPwd == $user['password_u']) {
						//Si si coincide crear una cookie
						$_SESSION['id'] = $user['id_u'];
						//Si se quiere ser recordado
						if ($_POST['stayLoggedIn'] == '1') {

							setcookie("id", $user['id_u'], time() + 60*60*24*365);

						}
						//Redireccionar a pagina de notas
						header("Location: notas.php");

					} else {
						$error = "Contraseña incorrecta.";
					}
				} else {
					$error = "Usuario y/o contraseña incorrectos.";
				}

			}

		}

	}

?>


<!-- Incluir el head y estilos que estan en otro archivo -->
<?php include("header.php"); ?>

  
  	<div class="container" id="logInContainer">

  		<div id="fondo">
	  		<h1 id="titulo">Mis Notas Tec</h1>
	  		<p id="subtitulo"><strong>Notas rápidas en la nube para alumnos</strong></p>

	  		<div id="error"><?php if ($error != "") {
	  			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
	  		}
	  		?></div>

	  		<!-- Registro -->
			<form method="post" id="signUpForm">
				<p class="instrucciones">¿Interesado? Regístrate ahora</p>
				<fieldset class="form-group">
					<input class="form-control" type="email" name="email" placeholder="Correo Electrónico">
				</fieldset>
				<fieldset class="form-group">
					<input class="form-control" type="password" name="password" placeholder="Contraseña">
				</fieldset>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="stayLoggedIn" value=1>
					Recordarme
					</label>
				</div>
				<fieldset class="form-group">
					<input type="hidden" name="registrar" value="1">
					<input class="btn btn-success" type="submit" name="submit" value="Registrarse">
				</fieldset>
				<p><a class="toggleForms">Iniciar Sesión</a></p>
			</form>

			<!-- Inicio de Sesion -->
			<form method="post" id="logInForm">
				<p class="instrucciones">Inicio de Sesión para usuarios</p>
				<fieldset class="form-group">
					<input class="form-control" type="email" name="email" placeholder="Correo Electrónico">
				</fieldset>
				<fieldset class="form-group">
					<input class="form-control" type="password" name="password" placeholder="Contraseña">
				</fieldset>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="stayLoggedIn" value=1>
					Recordarme
					</label>
				</div>
				</fieldset>
				<fieldset class="form-group">
					<input type="hidden" name="registrar" value="0">
					<input class="btn btn-success" type="submit" name="submit" value="Iniciar Sesión">
				</fieldset>
				<p><a class="toggleForms">Registrarse</a></p>
			</form>


		</div>

		
		


  	</div>
    

<?php include("footer.php"); ?>














