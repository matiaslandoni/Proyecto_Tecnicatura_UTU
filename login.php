<!doctype html>
<html class="h-100">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body class="h-100">
	<div class="container-fluid h-100">
		<div class="row h-100 justify-content-center align-items-center">

			<div class="col-12 col-md-4">

				<form method="post" class="col-12 col-md-8 offset-md-2">


					<h1 class="text-center">Iniciar Sesion</h1>
					<img src="logo.png" class="rounded mx-auto d-block w-50" alt="...">
					<div class="mb-3">
						<label for="txtusr" class="form-label">Usuario</label>
						<input type="text" class="form-control p-2" name="usuario" id="txtusr" required>
					</div>
					<div class="mb-4">
						<label for="pswclave" class="form-label">Clave</label>
						<input type="password" class="form-control p-2" name="clave" required maxlength="20" id="pswclave" required>
					</div>
					<div class="text-center">
						<input type="submit" class="btn btn-primary mb-4 w-100 p-2" value="Iniciar sesion" name="btniniciar">
					</div>

				</form>

			</div>
		</div>
	</div>
</body>

</html>

<?php
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();
if (isset($_SESSION['nombreusuario'])) {
	header('location: actusr.php');
}
if (isset($_POST['btniniciar'])) {
	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];

	$conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");

	$sql = "SELECT * from usuarios where usuario='$usuario' and clave='$clave'";
	if ($result = mysqli_query($conn, $sql)) {
		if (mysqli_num_rows($result) == 1) {
			$_SESSION['nombreusuario'] = $usuario;
			header("location: actusr.php");
		} else {
			echo "<script>alert('Usuario/Clave incorrecto o usuario no existe');window.location= 'login.php' </script>";
		}
	}
	mysqli_close($conn);
}
?>