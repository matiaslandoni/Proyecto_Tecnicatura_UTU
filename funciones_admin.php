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
    <div class="container">
        <div class="row justify-content-md-center mt-5 border shadow bg-light rounded text-center">
            <div class="col">
                <form method="post" class="col-12 col-md-10 offset-md-1">
                    <h1>Gestion de Usuarios</h1>
                    <div class="input-group mb-3 mt-5">
                        <span class="input-group-text">Usuario</span>
                        <input type="text" name="usuario_eliminar" class="form-control">
                        <input type="submit" value="Eliminar" name="btneliminar" class="btn btn-primary" 
                        onclick="return confirm('Esta seguro que desea eliminar el usuario?')">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text">Usuario</span>
                        <input type="text" name="usuario_modificar" class="form-control rounded">
                        <span class="input-group-text">Clave</span>
                        <input type="text" name="clave_modificar" class="form-control rounded" placeholder="Entre 6 y 20 caracteres" maxlength="20">
                    </div>
                    <div class="input-group mb-3">
                        <input type="submit" value="Modificar Clave" name="btnmodificar" class="btn btn-primary w-50 p-2 m-auto" 
                        onclick="return confirm('Esta seguro que desea modificar el usuario?')">
                    </div>
                </form>
            </div>
            <div class="col align-self-center ">
                <form method="post" class="col-10 offset-1">
                    <h1>Registrar Usuario</h1>
                    <div class="input-group mb-3 mt-5">
                        <span class="input-group-text">Usuario</span>
                        <input type="text" name="usuario" class="form-control">

                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text">Clave</span>
                        <input type="text" name="clave" class="form-control" placeholder="Entre 6 y 20 caracteres" maxlength="20">
                    </div>
                    <div class="input-group mb-3">
                        <input type="submit" value="Registrar Usuario" name="btnregistrar" class="btn btn-primary w-50 p-2 m-auto">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-10 offset-lg-1 text-center mt-3">
        <?php
        session_start();
        if (isset($_SESSION['nombreusuario']) && $_SESSION["nombreusuario"] == "administrador") {
            if (isset($_POST['btnmodificar'])) {
                $usuario_modificar = $_POST['usuario_modificar'];
                $clave_modificar = $_POST['clave_modificar'];
                $conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
                $sql = "UPDATE usuarios SET clave='$clave_modificar' WHERE usuario='$usuario_modificar';";
                if ($result = mysqli_query($conn, $sql)) {
                    echo "<script>alert('La clave se modifico correctamente');window.location= 'funciones_admin.php' </script>";
                } else {
                    echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
                }
                mysqli_close($conn);
            }
            if (isset($_POST['btneliminar'])) {
                $usuario_eliminar = $_POST['usuario_eliminar'];
                $conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
                $sql = "DELETE FROM usuarios WHERE usuario='$usuario_eliminar';";
                if ($result = mysqli_query($conn, $sql)) {
                    echo "<script>alert('El usuario se elimino correctamente');window.location= 'funciones_admin.php' </script>";
                } else {
                    echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
                }
                mysqli_close($conn);
            }
            if (isset($_POST['btnregistrar'])) {
                $clave = $_POST['clave'];
                $usuario = $_POST['usuario'];
                if (strlen($usuario) > 1 and strlen($clave) > 5 and strlen($clave) < 20 and strlen($usuario) < 20) {
                    $conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
                    $sql = "SELECT * from usuarios where usuario='$usuario'";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<script>alert('El usuario ya esta registrado');window.location= 'funciones_admin.php' </script>";
                        } else {
                            $sql = "INSERT INTO usuarios (`clave`, `usuario`) VALUES ('$clave', '$usuario');";
                            if ($result = mysqli_query($conn, $sql)) {
                                echo "<script>alert('El usuario se registro correctamente');window.location= 'funciones_admin.php' </script>";
                            } else {
                                echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
                            }
                        }
                    }
                    mysqli_close($conn);
                } else {
                    echo "<script>alert('Asegurese de haber ingresado correctamente los datos');window.location= 'funciones_admin.php' </script>";
                }
            }
            $conn = new mysqli("192.168.1.153:3306", "usuario", "passwd123", "proyecto");
            $sql = "SELECT * FROM usuarios";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {

                    echo "<table class='table border'>";
                    echo "<tr class='bg-primary text-white'>";
                    echo "<th>Usuarios</th>";
                    echo "<th>Clave</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td class='border col-6'>" . $row['usuario'] . "</td>";
                        echo "<td class='border'>" . $row['clave'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    mysqli_free_result($result);
                } else {
                    echo "<script>alert('No hay usuarios registrados');window.location= 'funciones_admin.php' </script>";
                }
            } else {
                echo "<script>alert('Hubo un error al ejecutar la consulta');window.location= 'index.html' </script>";
            }
            mysqli_close($conn);
        } else {
            echo "<script>alert('No tiene acceso a dicha funcion');window.location= 'index.html' </script>";
        }
        ?>
    </div>
</body>
</html>