<?php

	include("header.php");
	include("connection.php");


$query = "SELECT * FROM `users`";

$logs = mysqli_query($link, $query);

$array = array();

while($row = mysqli_fetch_array($logs)){

	$array[] = $row;
	
}


?>

<html>
<head>
	<title>BD</title>
</head>
<body>
	<div class="logrow">
		<p>ID User</p>
		<ul>
			<?php foreach ($array as $log) {
				echo '<li>'.$log[0].'</li>';
			} ?>
		</ul>
	</div>

	<div class="logrow">
		<p>Email</p>
		<ul>
			<?php foreach ($array as $log) {
				echo '<li>'.$log[1].'</li>';
			} ?>
		</ul>
	</div>

	<div class="logrow">
		<p>Password</p>
		<ul>
			<?php foreach ($array as $log) {
				echo '<li>'.$log[2].'</li>';
			} ?>
		</ul>
	</div>

	<button type="button" class="logbutt" onclick="window.location='http://176.32.230.48/misnotastec.com/index.php'">Regresar</button>




</body>
</html>