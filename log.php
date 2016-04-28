<?php 
include("header.php");
include("connection.php");


$query = "SELECT * FROM `log`";

$logs = mysqli_query($link, $query);

$array = array();

while($row = mysqli_fetch_array($logs)){

	$array[] = $row;
	
}


?>

<html>
<head>
	<title>Log</title>
</head>
<body>
	<div class="logrow">
		<p>ID Log</p>
		<ul>
			<?php foreach ($array as $log) {
				echo '<li>'.$log[0].'</li>';
			} ?>
		</ul>
	</div>

	<div class="logrow">
		<p>ID Nota</p>
		<ul>
			<?php foreach ($array as $log) {
				echo '<li>'.$log[1].'</li>';
			} ?>
		</ul>
	</div>

	<div class="logrow">
		<p>Contenido</p>
		<ul>
			<?php foreach ($array as $log) {
				echo '<li>'.$log[2].'</li>';
			} ?>
		</ul>
	</div>

	<button type="button" class="logbutt" onclick="window.location='http://176.32.230.48/misnotastec.com/index.php'">Regresar</button>




</body>
</html>