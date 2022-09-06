<!doctype html>
<html lang="en" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<div class="container-fluid border">
		<header class="d-flex justify-content-center py-3">
			<ul class="nav nav-pills">
				<li class="nav-item"><a class="nav-link" href="reserva_equipos.php">Reservar Equipos</a></li>
                <li class="nav-item"><a class="nav-link active" href="reserva_zoom.php">Reservar Zoom</a></li>
                <li class="nav-item"><a class="nav-link" href="reserva_erma.php">Ingreso Sala Erma</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_equipos.php">Gestionar reservas de Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_zoom.php">Gestionar reservas de Zoom</a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_erma.php"> Gestionar registros de Erma</a></li>
                <li class="nav-item"><a class="nav-link" href="actusr.php">Usuario</a></li>
			</ul>
		</header>
	</div>
</head>
<body class="h-100">
	<div class="container-fluid h-100">
		<div class="col-12 col-md-6 offset-md-3 bg-light mt-5 mb-5">
			<div class="border rounded shadow text-center">
				<form method="post" class="col-12 col-md-10 offset-md-1">

					<h1>Reserva Zoom</h1>
					<div class="input-group mb-3 mt-5">
						<span class="input-group-text">Nombre</span>
						<input type="text" name="nombre_responsable" class="form-control" required>

					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">Telefono</span>
						<input type="text" name="telefono_responsable" class="form-control" required>

					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">Fecha</span>
						<input type="date" name="fecha_zoom" class="form-control rounded" required>
						<span class="input-group-text">Hora</span>
						<input type="time" name="hora" class="form-control rounded" required>

					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">Asistente</span>
						<input type="text" name="asistente" class="form-control" required>

					</div>
					<div class="input-group">
						<input type="submit" value="Finalizar reserva" name="btnreserva" class="btn btn-primary w-50 p-2 m-auto mb-3">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php
session_start();
if (isset($_SESSION['nombreusuario'])) {
	if (isset($_POST['btnreserva'])) {
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$nombre_responsable = $_POST['nombre_responsable'];
		$fecha_zoom = $_POST['fecha_zoom'];
		$hora = $_POST['hora'];
		$asistente = $_POST['asistente'];
		$telefono_responsable = $_POST['telefono_responsable'];
		$fecha_reserva = date('Y-m-d', time());

		if (strlen($nombre_responsable) > 1 and strlen($fecha_zoom) > 1 and strlen($hora) > 1 and strlen($asistente) > 1 and strlen($telefono_responsable) > 1) {
			$conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
			$sql = "INSERT INTO `reserva_zoom`  (`nombre_responsable`, `telefono_responsable`, `fecha_zoom`, `hora`, `fecha_reserva`, `asistente`) 
			VALUES ('$nombre_responsable', '$telefono_responsable', '$fecha_zoom', '$hora', '$fecha_reserva', '$asistente');";
			if ($result = mysqli_query($conn, $sql)) {
				echo "<script>alert('Reserva realizada correctamente');window.location= 'reserva_zoom.php' </script>";
			} else {
				echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
			}
			mysqli_close($conn);
		} else {
			echo "<script>alert('Asegurese de haber completado los campos requeridos');window.location= 'reserva_zoom.php' </script>";
		}
	}
} else {
	header('location: login.php');
}
?>