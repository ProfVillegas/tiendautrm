<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión -  Tienda UTRM</title>
    <style>
    *,body{
        padding:0;
        margin:0;
        text-align:center;
    }
    form{
        display:block;
        padding:10px;
        border-radius:5px;
        border:1px #333 dashed;
        width: 300px;
        margin:0 auto;
    }
    form input{
        padding:3px 6px;
    }
    .alert{
        color:#f91c0c;
        font-size:14pt;

    }   
    </style>
</head>
<body>

    <form action="index.php" method="get">
        <label for="nombre" class="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Escriba su nombre corto" required>
        <label for="psw" class="psw">Password</label>
        <input type="password" name="psw" id="psw" required>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <?php
        echo "<p class='alert'>Hola Mundo</p>";
        $users[]=array('name'=>'Admin','psw'=>'stitch','roll'=>'admin');
        if(isset($_GET['nombre'])){
            echo "<p>Se enviaron Datos</p>";
            if($_GET['nombre']==$users[0]['name'] && $_GET['psw']==$users[0]['psw']){
                header('location:dashboard/index_admin.php');
            } else {
                header("location:index.php?errno=1");
            }
        } else {
            echo "<p>No se enviaron datos</p>";
        }
        if(isset($_GET['errno'])){
            echo "<p class='alert'>Usuario y/o contraseña incorrecta</p>";
        }
    ?>    
</body>
</html>