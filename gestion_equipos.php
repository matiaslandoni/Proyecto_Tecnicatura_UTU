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
				<li class="nav-item"><a class="nav-link" href="reserva_zoom.php">Reservar Zoom</a></li>
				<li class="nav-item"><a class="nav-link" href="reserva_erma.php">Ingreso Sala Erma</a></li>
				<li class="nav-item"><a class="nav-link active" href="gestion_equipos.php">Gestionar reservas de Equipos</a></li>
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
					<h1>Gestion de reservas de Equipos</h1>
					<div class="input-group mb-3 mt-5">
						<span class="input-group-text">Fecha inicio</span>
						<input type="date" name="fecha_inicio" class="form-control rounded">
						<span class="input-group-text">Fecha final</span>
						<input type="date" name="fecha_final" class="form-control rounded">
					</div>
					<div class="input-group mb-3 mt-3">
						<input type="submit" value="Buscar reservas" name="btnbuscar" class="btn btn-primary w-50 p-2 m-auto">
					</div>
					<h4>Eliminar reserva</h4>
					<div class="input-group mb-4 mt-4">
						<span class="input-group-text">ID de Reserva</span>
						<input type="number" name="id_reserva_eliminar" class="form-control">
						<input type="submit" value="Eliminar" name="btneliminar" class="btn btn-primary" 
						onclick="return confirm('Esta seguro que desea eliminar la reserva?')">
					</div>
					<h4>Modificar reserva</h4>
					<div class="input-group mb-3 mt-4">
						<span class="input-group-text">ID</span>
						<input type="number" name="id_reserva_modificar" class="form-control rounded">
						<span class="input-group-text">Nombre</span>
						<input type="text" name="nombre_responsable" class="form-control rounded">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">Telefono</span>
						<input type="text" name="telefono_responsable" class="form-control">
						<span class="input-group-text">Fecha de Uso</span>
						<input type="date" name="fecha_uso" class="form-control">
					</div>
					<div class="input-group mb-4">
						<span class="input-group-text">Hora Inicio</span>
						<input type="time" name="hora_inicio" class="form-control">
						<span class="input-group-text">Hora Final</span>
						<input type="time" name="hora_final" class="form-control">
					</div>
					<div class="input-group mb-4">
						<span class="input-group-text">Cantidad</span>
						<input type="number" name="cantidad_equipos" class="form-control">
						<span class="input-group-text">Tipo</span>
						<input type="text" name="tipo" class="form-control">
					</div>
					<div class="input-group">
						<input type="submit" value="Modificar reserva" name="btnmodificar" class="btn btn-primary w-50 p-2 m-auto mb-3">
					</div>
				</form>
			</div>
		</div>
		<?php
		session_start();
		if (isset($_SESSION['nombreusuario'])) {
			if (isset($_POST['btneliminar'])) {
				$id_reserva_eliminar = $_POST['id_reserva_eliminar'];
				if (strlen($id_reserva_eliminar) > 0) {
					$conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
					$sql = "SELECT * FROM reserva_equipos WHERE id_reserva_equipos='$id_reserva_eliminar';";
					if ($result = mysqli_query($conn, $sql)) {
						if (mysqli_num_rows($result) == 1) {
							$sql = "DELETE FROM reserva_equipos WHERE id_reserva_equipos='$id_reserva_eliminar';";
							if ($result = mysqli_query($conn, $sql)) {
								echo "<script>alert('La reserva se elimino correctamente');window.location= 'gestion_equipos.php' </script>";
							} else {
								echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
							}
						} else {
							echo "<script>alert('La ID no coincide con los registros');window.location= 'gestion_equipos.php' </script>";
						}
						mysqli_close($conn);
					}
				} else {
					echo "<script>alert('Es necesario completar todos los campos');window.location= 'gestion_equipos.php' </script>";
				}
			}
			if (isset($_POST['btnmodificar'])) {
				date_default_timezone_set('America/Argentina/Buenos_Aires');
				$id_reserva_modificar = $_POST['id_reserva_modificar'];
				$nombre_responsable = $_POST['nombre_responsable'];
				$telefono_responsable = $_POST['telefono_responsable'];
				$fecha_uso = $_POST['fecha_uso'];
				$hora_inicio = $_POST['hora_inicio'];
				$hora_final = $_POST['hora_final'];
				$cantidad_equipos = $_POST['cantidad_equipos'];
				$tipo = $_POST['tipo'];
				$fecha_reserva = date('Y-m-d', time());
				if (
					strlen($id_reserva_modificar) > 0 and strlen($nombre_responsable) > 1 and strlen($fecha_uso) > 1 and strlen($hora_inicio) > 1 and strlen($hora_final) > 1
					and strlen($telefono_responsable) > 1 and strlen($cantidad_equipos) > 0 and strlen($tipo) > 1
				) {
					$conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
					$sql = "SELECT * FROM reserva_equipos WHERE id_reserva_equipos='$id_reserva_modificar';";
					if ($result = mysqli_query($conn, $sql)) {
						if (mysqli_num_rows($result) == 1) {
							$sql = "UPDATE reserva_equipos 
				SET nombre_responsable='$nombre_responsable', telefono_responsable='$telefono_responsable',  fecha_uso ='$fecha_uso', 
				hora_inicio ='$hora_inicio', hora_final ='$hora_final', fecha_reserva ='$fecha_reserva', cantidad_equipos ='$cantidad_equipos' 
				WHERE id_reserva_equipos='$id_reserva_modificar'; ";
							if ($result = mysqli_query($conn, $sql)) {
								echo "<script>alert('La reserva se modifico correctamente');window.location= 'gestion_equipos.php' </script>";
							} else {
								echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
							}
						} else {
							echo "<script>alert('La ID no coincide con los registros');window.location= 'gestion_equipos.php' </script>";
						}
					}
					mysqli_close($conn);
				} else {
					echo "<script>alert('Es necesario completar todos los campos');window.location= 'gestion_equipos.php' </script>";
				}
			}
			if (isset($_POST['btnbuscar'])) {
				$fecha_inicio = $_POST['fecha_inicio'];
				$fecha_final = $_POST['fecha_final'];
				$conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
				$sql = "SELECT * FROM reserva_equipos WHERE fecha_reserva BETWEEN '$fecha_inicio' AND '$fecha_final';";
				if ($result = mysqli_query($conn, $sql)) {
					if (mysqli_num_rows($result) > 0) {
						echo "<div class='col-12 col-md-10 offset-md-1 text-center'>";
						echo "<table class='table border'>";
						echo "<tr class='bg-primary text-white'>";
						echo "<th>ID</th>";
						echo "<th>Nombre responsable</th>";
						echo "<th>Telefono</th>";
						echo "<th>Fecha realizada</th>";
						echo "<th>Fecha de uso</th>";
						echo "<th>Hora inicio</th>";
						echo "<th>Hora final</th>";
						echo "<th>Cantidad de equipos</th>";
						echo "<th>Tipo de equipo</th>";
						echo "</tr>";
						while ($row = mysqli_fetch_array($result)) {
							echo "<tr>";
							echo "<td class='border'>" . $row['id_reserva_equipos'] . "</td>";
							echo "<td class='border'>" . $row['nombre_responsable'] . "</td>";
							echo "<td class='border'>" . $row['telefono_responsable'] . "</td>";
							echo "<td class='border'>" . $row['fecha_reserva'] . "</td>";
							echo "<td class='border'>" . $row['fecha_uso'] . "</td>";
							echo "<td class='border'>" . $row['hora_inicio'] . "</td>";
							echo "<td class='border'>" . $row['hora_final'] . "</td>";
							echo "<td class='border'>" . $row['cantidad_equipos'] . "</td>";
							echo "<td class='border'>" . $row['tipo'] . "</td>";
							echo "</tr>";
						}
						echo "</table>";
						echo "</div>";
						mysqli_free_result($result);
					} else {
						echo "<script>alert('No hay reservas registradas');window.location= 'reserva_equipos.php' </script>";
					}
				} else {
					echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
				}
				mysqli_close($conn);
			}
		} else {
			header('location: login.php');
		}
		?>
	</div>
	</div>
</body>
</html>