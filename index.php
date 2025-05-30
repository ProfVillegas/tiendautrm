<?php
session_start();
?>

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
        //$users[]=array('name'=>'Admin','psw'=>'stitch','roll'=>'admin');
        if(isset($_GET['nombre'])){
            $con= new mysqli('localhost','root','','tiendautrm');

            if($con->connect_errno){
                echo "<p class='error'>".$con->connect_error."</p>";
                exit();
            }
            $query="select id, username, roll from users
            where username=? and psw=? ";

            $stmt=$con->prepare($query);

            if($stmt){
                $stmt->bind_param("ss",$_GET['nombre'],$_GET['psw']);
                $stmt->execute();

                $result= $stmt->get_result();
                //echo "<span>".$result->num_rows."</span>";
                //Si no encuentra registro
                if($result->num_rows!=1){
                    header("location:index.php?errno=1");
                }

                
                //Declaro variables de $_SESSION
                $row=$result->fetch_assoc();
                $_SESSION['id']=$row['id'];
                $_SESSION['username']=$row['username'];
                $_SESSION['roll']=$row['roll'];

                //Redirección
                header("location:dashboard/index_".$row['roll'].".php");
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