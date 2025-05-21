<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>

    <style>
        body {
            background: linear-gradient(135deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #8B00FF);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: hidden;
            animation: backgroundAnimation 10s ease infinite alternate;
        }

        @keyframes backgroundAnimation {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }

        .container {
            text-align: center;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 400px;
            animation: fadeIn 1.2s ease-out;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 28px;
            color: #333;
        }

        .subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        form {
            gap: 15px;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #fcb551;
            box-shadow: 0 0 5px rgba(201, 235, 116, 0.5);
            transform: scale(1.02);
        }

        input[type="text"]:focus + label,
        input[type="number"]:focus + label {
            transform: translateY(-20px);
            font-size: 12px;
            color: #fcb551;
        }

        input[type="submit"] {
            background: linear-gradient(135deg, #f8ca5e 0%, #ACB6E5 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s, transform 0.3s;
        }

        input[type="submit"]:hover {
            background: linear-gradient(135deg, #ACB6E5 0%, #f0ba4f 100%);
            transform: scale(1.05);
        }

        label {
            position: absolute;
            left: 15px;
            top: 12px;
            font-size: 14px;
            font-weight: bold;
            color: #555;
            transition: all 0.3s ease;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-top: 16px;
        }

        th, td {
            padding: 10px 13px; 
            text-align: left;
            border-radius: 8px; 
        }

        th {
            background-color: #fcb551;
            color: white;
        }

        td {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<?php
$conectar = mysqli_connect("localhost", "root", "", "formulario");

if (!empty($_POST["ingresar"])) {
    $cedula = $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $edad = $_POST["edad"];
    $profesion = $_POST["profesion"];

    $insertar = "INSERT INTO datos (cedula, nombre, apellido, direccion, ciudad, edad, profesion)
    VALUES ($cedula, '$nombre', '$apellido', '$direccion', '$ciudad', $edad, '$profesion')";
    mysqli_query($conectar, $insertar);
}

if (isset($_POST['update'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $edad = $_POST['edad'];
    $profesion = $_POST['profesion'];

    $update_query = "UPDATE datos SET nombre='$nombre', apellido='$apellido', direccion='$direccion', ciudad='$ciudad', edad=$edad, profesion='$profesion' WHERE cedula=$cedula";
    mysqli_query($conectar, $update_query);
}

if (isset($_POST['delete'])) {
    $cedula = $_POST['cedula'];
    $delete_query = "DELETE FROM datos WHERE cedula=$cedula";
    mysqli_query($conectar, $delete_query);
}
?>

<div class="container">
    <h1>Registro de Usuario</h1>
    <p class="subtitle">Registro</p>

    <form method="POST" action="formulario.php">
        Cedula <input type="number" name="cedula">
        Nombre <input type="text" name="nombre">
        Apellido <input type="text" name="apellido">
        Direccion <input type="text" name="direccion">
        Ciudad <input type="number" name="ciudad">
        Edad <input type="number" name="edad">
        Profesion <input type="text" name="profesion">
        <input type="submit" name="ingresar" value="Ingresar">
        <input type="submit" name="update" value="Actualizar">
        <input type="submit" name="delete" value="Eliminar">
    </form>
</div>

<div class="container">
    <?php
    $consulta = "SELECT * FROM datos";
    $resultado = mysqli_query($conectar, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "<h4>Registros actuales</h4>";
        echo "<table border='1'>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Edad</th>
                    <th>Profesión</th>
                </tr>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>{$fila['cedula']}</td>
                    <td>{$fila['nombre']}</td>
                    <td>{$fila['apellido']}</td>
                    <td>{$fila['direccion']}</td>
                    <td>{$fila['ciudad']}</td>
                    <td>{$fila['edad']}</td>
                    <td>{$fila['profesion']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hay registros en la base de datos.</p>";
    }
    ?>
</div>

</body>
</html>
