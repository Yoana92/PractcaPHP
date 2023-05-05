<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de registro</title>
    <link rel="stylesheet" href="estilos.css" type="text/css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="group">
        <h2>Formulario de Registro</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validarFormulario()">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-input" required>
            <span><em>(Requerido)</em></span>
            <br>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" class="form-input" required>
            <span><em>(Requerido)</em></span>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-input" required>
            <span><em>(Requerido)</em></span>
            <br>
            
            <div id="message-container">
                <?php

$mensaje_error = "";
$mensaje_exito = "";

if ($_POST) {
    
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];

    // Conexión con PDO
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cursosql";

    // Create conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
     
  // Check connection 

      // Verificar la conexión
    if ($conn->connect_error) {
        $mensaje_error = "Error de conexión: " . $conn->connect_error;
    } else {
        // Insertar los datos en la tabla USUARIO
        $sql = "INSERT INTO USUARIO (NOMBRE, APELLIDO, EMAIL) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $nombre, $apellido, $email);

            if ($stmt->execute()) {
                $mensaje_exito = "¡Registro completado con éxito!";
            } else {
                $mensaje_error = "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
        } else {
            $mensaje_error = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}

?>
                <?php if (!empty($mensaje_error)) { ?>
                    <div class="error-message">
                        <?php echo $mensaje_error; ?>
                    </div>
                <?php } ?>

                <?php if (!empty($mensaje_exito)) { ?>
                    <div class="success-message">
                        <?php echo $mensaje_exito; ?>
                    </div>
                <?php } ?>
            </div>
            <button type="submit">Guardar datos</button>
        </form>
    </div>
</body>
</html>
