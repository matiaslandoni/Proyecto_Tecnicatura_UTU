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
				<li class="nav-item"><a class="nav-link" href="gestion_equipos.php">Gestionar reservas de Equipos</a></li>
				<li class="nav-item"><a class="nav-link" href="gestion_zoom.php">Gestionar reservas de Zoom</a></li>
				<li class="nav-item"><a class="nav-link" href="gestion_erma.php"> Gestionar registros de Erma</a></li>
				<li class="nav-item"><a class="nav-link active" href="actusr.php">Usuario</a></li>
			</ul>
		</header>
	</div>
</head>

<body class="h-100">
	<div class="container-fluid h-100">
		<div class="col-12 col-md-6 offset-md-3 bg-light mt-5 mb-5">
			<div class="border rounded shadow text-center">
				<?php
				session_start();
				if (isset($_SESSION['nombreusuario'])) {
					$usuarioingresado = $_SESSION['nombreusuario'];
					echo "<h1>Usuario: $usuarioingresado</h1>";
					if (isset($_POST['btnmodificar'])) {
						$clave_modificar = $_POST['clave_modificar'];
						if (strlen($clave_modificar) > 6 and strlen($clave_modificar) < 20) {
							$conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
							$sql = "UPDATE usuarios SET clave='$clave_modificar' WHERE usuario='$usuarioingresado';";
							if ($result = mysqli_query($conn, $sql)) {
								echo "<script>alert('La clave se modifico correctamente');window.location= 'actusr.php' </script>";
							} else {
								echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
							}
							mysqli_close($conn);
						} else {
							echo "<script>alert('Ingrese una contraseña de entre 6 y 20 caracteres');window.location= 'index.html' </script>";
						}
					}
					if ($usuarioingresado == 'administrador') {
						echo "<a class='btn btn-primary mb-3 mt-4 w-25 p-2' href='funciones_admin.php' role='button'>Gestionar Usuarios</a>";
					}
					if (isset($_POST['btncerrar'])) {
						session_destroy();
						header('location: index.html');
					}
				} else {
					header('location: login.php');
				}
				?>
				<form method="post" class="col-12 col-md-10 offset-md-1">

					<h4 class="mt-3">Modificar clave</h4>
					<div class="input-group mt-4">
						<span class="input-group-text">Clave</span>
						<input type="text" name="clave_modificar" class="form-control rounded" placeholder="Entre 6 y 20 caracteres">
						<input type="submit" value="Modificar Clave" name="btnmodificar" class="btn btn-primary" onclick="return confirm('Esta seguro que desea modificar la clave?')">
					</div>
					<input type="submit" value="Cerrar Sesion" name="btncerrar" class="btn btn-primary mb-5 mt-5 w-50 p-2">
				</form>
			</div>
		</div>
	</div>

</body>

</html>