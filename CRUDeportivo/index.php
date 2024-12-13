<?php
include 'procesar.php';

// Variables para la paginación
$eventosPorPagina = 10; 
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * $eventosPorPagina;

$campoOrden = isset($_GET['campoOrden']) ? $_GET['campoOrden'] : 'nombre_evento';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'ASC';

// ASC y DESC
$nuevoOrden = $orden === 'ASC' ? 'DESC' : 'ASC';

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';
$eventos = listarEventos($conn, $filtro, $campoOrden, $orden, $inicio, $eventosPorPagina);

//total de eventos para la paginación
$totalEventos = contarEventos($conn, $filtro);
$totalPaginas = ceil($totalEventos / $eventosPorPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos Deportivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

<form method="GET">
    <input name="filtro" type="text" value="<?php echo $filtro ?>" >
    <button type="submit" class="btn btn-primary">Buscar</button>
</form>

<h2>Listado de Eventos</h2>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><a href="?campoOrden=nombre_evento&orden=<?php echo $nuevoOrden; ?>">Nombre del Evento</a></th>
            <th><a href="?campoOrden=tipo_deporte&orden=<?php echo $nuevoOrden; ?>">Tipo de Deporte</a></th>
            <th><a href="?campoOrden=fecha_evento&orden=<?php echo $nuevoOrden; ?>">Fecha</a></th>
            <th><a href="?campoOrden=hora_evento&orden=<?php echo $nuevoOrden; ?>">Hora</a></th>
            <th><a href="?campoOrden=ubicacion&orden=<?php echo $nuevoOrden; ?>">Ubicación</a></th>
            <th><a href="?campoOrden=organizador&orden=<?php echo $nuevoOrden; ?>">Organizador</a></th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($evento = $eventos->fetch_assoc()) {
        echo "<tr>
                <td>{$evento['nombre_evento']}</td>
                <td>{$evento['tipo_deporte']}</td>
                <td>{$evento['fecha']}</td>
                <td>{$evento['hora']}</td>
                <td>{$evento['ubicacion']}</td>
                <td>{$evento['organizador']}</td>
                <td>
                    <a href='formularioEvento.php?id={$evento['id']}' class='btn btn-warning btn-sm'>Editar</a>
                    <form action='procesar.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='accion' value='eliminarEvento'>
                        <input type='hidden' name='id' value='{$evento['id']}'>
                        <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este evento?\");'>Eliminar</button>
                    </form>
                </td>
            </tr>";
    }
    ?>
    </tbody>
</table>

<!-- Paginación -->
<nav>
    <ul class="pagination">
        <li class="page-item <?php if($paginaActual <= 1){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($paginaActual <= 1){ echo '#'; } else { echo "?pagina=".($paginaActual - 1); } ?>">Anterior</a>
        </li>
        <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?php if($i == $paginaActual){ echo 'active'; } ?>">
                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if($paginaActual >= $totalPaginas){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($paginaActual >= $totalPaginas){ echo '#'; } else { echo "?pagina=".($paginaActual + 1); } ?>">Siguiente</a>
        </li>
    </ul>
</nav>

<a href="formularioEvento.php" class="btn btn-primary">Añadir Evento</a>

<h2 class="mt-5">Listado de Organizadores</h2>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $organizadores = listarOrganizadores($conn);
    while ($organizador = $organizadores->fetch_assoc()) {
        echo "<tr>
                <td>{$organizador['nombre']}</td>
                <td>{$organizador['email']}</td>
                <td>{$organizador['telefono']}</td>
                <td>
                    <form action='procesar.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='accion' value='eliminarOrganizador'>
                        <input type='hidden' name='id' value='{$organizador['id']}'>
                        <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este organizador?\");'>Eliminar</button>
                    </form>
                </td>
            </tr>";
    }
    ?>
    </tbody>
</table>
<a href="formularioOrganizador.php" class="btn btn-primary">Añadir Organizador</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
