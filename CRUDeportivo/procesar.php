<?php
session_start();

$host = "localhost";
$dbname = "eventos_deportivos";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

function redirigirConErrores($errores, $accion) {
    $_SESSION['errores'] = $errores;
    header("Location: $accion.php");
    exit();
}

function validarCampos($conn,$tipo) {
    $errores = [];
    
    $nombre_evento = $_POST['nombre_evento'] ?? '';
    $tipo_deporte = $_POST['tipo_deporte'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $ubicacion = $_POST['ubicacion'] ?? '';
    $id_organizador = $_POST['id_organizador'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    if($tipo == 'evento'){
        if (empty($nombre_evento)) {
            $errores[] = "El campo 'Nombre del Evento' es obligatorio.";
        }
        if (empty($tipo_deporte)) {
            $errores[] = "El campo 'Tipo de Deporte' es obligatorio.";
        }
        if (empty($fecha)) {
            $errores[] = "El campo 'Fecha' es obligatorio.";
        }
        if (empty($hora)) {
            $errores[] = "El campo 'Hora' es obligatorio.";
        }
        if (empty($ubicacion)) {
            $errores[] = "El campo 'Ubicación' es obligatorio.";
        }
        if (empty($id_organizador)) {
            $errores[] = "El campo 'Organizador' es obligatorio.";
        }
    }
    
    if($tipo == 'organizador'){
        if (empty($nombre)) {
            $errores[] = "El campo 'Nombre' es obligatorio.";
        }
        if (empty($email)) {
            $errores[] = "El campo 'Email' es obligatorio.";
        }
        if (empty($telefono)) {
            $errores[] = "El campo 'Teléfono' es obligatorio.";
        }
    }
    
    return $errores;
}

// function listarEventos($conn,$filtro) {
//     $sql = "SELECT e.*, o.nombre AS organizador 
//             FROM eventos e 
//             JOIN organizadores o ON e.id_organizador = o.id";

//     if($filtro){


//         $sql .= " WHERE  e.nombre_evento LIKE '%".$filtro. "%'";
//      }  //  echo $sql ;
//     return $conn->query($sql);
// }

function listarOrganizadores($conn) {
    $sql = "SELECT * FROM organizadores";
    return $conn->query($sql);
}

function obtenerEvento($conn, $id) {
    $sql = "SELECT * FROM eventos WHERE id = $id";
    $resultado = $conn->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return null;
    }
}
function guardarEvento($conn) {

    $camposRequeridos = [
        'nombre_evento' => $_POST['nombre_evento'] ?? '',
        'tipo_deporte' => $_POST['tipo_deporte'] ?? '',
        'fecha' => $_POST['fecha'] ?? '',
        'hora' => $_POST['hora'] ?? '',
        'ubicacion' => $_POST['ubicacion'] ?? '',
        'id_organizador' => $_POST['id_organizador'] ?? ''
    ];
    
    $errores = validarCampos($camposRequeridos,'evento');
    
    if (!empty($errores)) {
        redirigirConErrores($errores, 'formularioEvento');
    }

    $id = $_POST['id'] ?? null;
    $nombre = $camposRequeridos['nombre_evento'];
    $tipo = $camposRequeridos['tipo_deporte'];
    $fecha = $camposRequeridos['fecha'];
    $hora = $camposRequeridos['hora'];
    $ubicacion = $camposRequeridos['ubicacion'];
    $organizador_id = $camposRequeridos['id_organizador'];

    if ($id) {
        $sql = "UPDATE eventos 
                SET nombre_evento = '$nombre', tipo_deporte = '$tipo', fecha = '$fecha', 
                    hora = '$hora', ubicacion = '$ubicacion', id_organizador = $organizador_id 
                WHERE id = $id";
    } else {
        $sql = "INSERT INTO eventos (nombre_evento, tipo_deporte, fecha, hora, ubicacion, id_organizador) 
                VALUES ('$nombre', '$tipo', '$fecha', '$hora', '$ubicacion', $organizador_id)";
    }
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Evento guardado correctamente.');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}


function guardarOrganizador($conn) {
    $camposRequeridos = [
        'nombre' => $_POST['nombre'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefono' => $_POST['telefono'] ?? ''
    ];
    
    $errores = validarCampos($camposRequeridos,'organizador');
    
    if (!empty($errores)) {
        redirigirConErrores($errores, 'formularioOrganizador');
    }

    $nombre = $camposRequeridos['nombre'];
    $email = $camposRequeridos['email'];
    $telefono = $camposRequeridos['telefono'];

    $sql = "INSERT INTO organizadores (nombre, email, telefono) 
            VALUES ('$nombre', '$email', '$telefono')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Organizador guardado correctamente.');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}

function eliminarEvento($conn) {
    $id = $_POST['id'];
    if (isset($id)) {
        $sql = "DELETE FROM eventos WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Evento eliminado correctamente.');
                window.location.href = 'index.php';
              </script>";
            exit();
        }
    }
    header("Location: index.php");
    exit();
}

function eliminarOrganizador($conn) {
    $id = $_POST['id'];
    $sql = "SELECT COUNT(*) AS total FROM eventos WHERE id_organizador = $id";
    $resultado = $conn->query($sql);
    $row = $resultado->fetch_assoc();
    if ($row['total'] == 0) {
        $sql = "DELETE FROM organizadores WHERE id = $id";
        $conn->query($sql);
        echo "<script>
                alert('Organizador eliminado con éxito.');
                window.location.href = 'index.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('No se puede eliminar el organizador porque tiene eventos asociados.');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['accion']) {
        case 'guardarEvento':
            guardarEvento($conn);
            break;
        case 'guardarOrganizador':
            guardarOrganizador($conn);
            break;
        case 'eliminarEvento':
            eliminarEvento($conn);
            break;
        case 'eliminarOrganizador':
            eliminarOrganizador($conn);
            break;
        default:
            break;
    }
}

// ----------------------------------------------
// function get_noticias_order_by_categoria()
// 	{
// 		$sql="select "
// 		." n.titulo,n.texto,c.id_categoria,n.html,n.fecha,c.categoria"
// 		." from "
// 		." noticias as n, Categorias as c"
// 		." where "
// 		." n.id_categoria = c.id_categoria "
// 		." order by c.categoria desc";
				
// 		$res=mysql_query($sql,Conectar::con());
// 		while ($reg=mysql_fetch_assoc($res))
// 		{
// 			$this->noticia[]=$reg;
// 		}
// 			return $this->noticia;
			
// 	}
// $query=mysqli_query($con, "SELECT * from project where id='".$id_del."' ORDER BY id ASC ");

function listarEventos($conn, $filtro, $campoOrden = 'nombre_evento', $orden = 'ASC', $inicio = 0, $eventosPorPagina = 10) {
    $columnasPermitidas = ['nombre_evento', 'tipo_deporte', 'fecha', 'hora', 'ubicacion', 'organizador'];
    $ordenPermitido = ['ASC', 'DESC'];

    // sin esto no funcionan las fechas ni las horas
    if (!in_array($campoOrden, $columnasPermitidas)) {
        $campoOrden = 'fecha';
    }
    if (!in_array($orden, $ordenPermitido)) {
        $orden = 'ASC';
    }

    $sql = "SELECT e.*, o.nombre AS organizador 
            FROM eventos e 
            JOIN organizadores o ON e.id_organizador = o.id";

    if ($filtro) {
        $sql .= " WHERE e.nombre_evento LIKE '%" . $filtro . "%'";
    }

    // ORDER BY
    $sql .= " ORDER BY " . $campoOrden . " " . $orden;
    $sql .= " LIMIT " . $inicio . ", " . $eventosPorPagina;

    return $conn->query($sql);
}

function contarEventos($conn, $filtro) {
    $sql = "SELECT COUNT(*) as total FROM eventos WHERE nombre_evento LIKE '%" . $filtro . "%'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// ----------------------------------------------------------------


?>

