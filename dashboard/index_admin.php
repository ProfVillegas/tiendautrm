<?php
session_start();

if (!$_SESSION['username']) {
    header("location:../index.php?msg=3");
}

/*Consultar a la base de datos */

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Usuarios</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
        }

        .main-content {
            padding: 20px;
        }

        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-4">
                    <h4 class="mb-4">Menú</h4>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" aria-current="page">
                                Usuarios
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Categorías
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Ventas
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Usuarios
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="nav-link link-dark">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2>Lista de Usuarios</h2>
                <button class="btn btn-primary mb-3" onclick="add(this)">Agregar Usuario</button>
                <?php
                $con = new mysqli('localhost', 'root', '', 'tiendautrm');

                if ($con->connect_errno) {
                } else {
                    $query = "select id, username, roll, visible from users";
                    $result = $con->query($query);
                }
                ?>
                <!-- Tabla de Usuarios -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Perfil</th>
                                <th>Visualizar</th>
                                <th>Nuevo</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>No. <?php echo $row['id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['roll']; ?></td>
                                    <td><a class="visible" href="#" data-id="<?php echo $row['id']; ?>" data-visible="<?php echo $row['visible']; ?>">
                                            <?php echo ($row['visible'] == 1) ? 'on' : 'off'; ?>
                                        </a></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning save">Editar</button>
                                        <button class="btn btn-sm btn-danger remove">Eliminar</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('click', function(event) {
            console.log(event.target);
            if (event.target.matches('.visible')) {
                data = JSON.stringify([{
                    op: 'visible',
                    id: event.target.dataset.id,
                    vs: event.target.dataset.visible,
                    tb: 'users'
                }]);
                AjaxRequest(data);
                event.preventDefault();
                if (event.target.dataset.visible == "1") {
                    event.target.dataset.visible = 0;
                    event.target.textContent = "off";
                } else {
                    event.target.dataset.visible = 1;
                    event.target.textContent = "on";
                }
            }
        });

        function AjaxRequest(data) {
            return fetch('request.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
                .then(response => response.json())
                .then(json => {
                    return json;
                }).catch(error => {
                    alert("Error: " + error);
                });
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>