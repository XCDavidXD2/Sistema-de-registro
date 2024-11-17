<?php

require_once 'connect.php';

$nombre = $apellido = $email = $contraseña = $confirmar = $direccionEnvio = $numTarjeta = $fechaCaducidad = $codigoSeguridad = "";
$errorNombre = $errorApellido = $errorEmail = $errorContraseña = $errorConfirmacion = $errorDireccionEnvio = $errorNumTarjeta = $errorFechaCaducidad = $errorCodigoSeguridad = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["name"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];
    $confirmar = $_POST["confirmar"];
    $direccionEnvio = $_POST["direccionEnvio"];
    $numTarjeta = $_POST["numTarjeta"];
    $fechaCaducidad = $_POST["fechaCaducidad"];
    $codigoSeguridad = $_POST["codigoSeguridad"];
    $errores = [];

    //NOMBRE
    if (empty($nombre)) {
        $errorNombre = "Nombre requerido";
    } else {
        if (preg_match("/[0-9]/", $nombre)) {
            $errorNombre = "Solo se permiten letras";
        }
    }

    //APELLIDO
    if (empty($apellido)) {
        $errorApellido = "Apellido requerido";
    } else {
        if (preg_match("/[0-9]/", $apellido)) {
            $errorApellido = "Solo se permiten letras";
        }
    }

    //EMAIL
    if (empty($email)) {
        $errorEmail = "Email requerido";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorEmail = "Email no válido";
        }
    }

    //CONTRASEÑA
    if (empty($contraseña)) {
        $errorContraseña = "Contraseña requerida";
    } else {
        if (strlen($contraseña) < 5) {
            $errores[] = "La contraseña debe tener al menos 5 caracteres";
        }
        if (!preg_match("/[A-Z]/", $contraseña)) {
            $errores[] = "La contraseña debe de tener al menos una letra mayúscula";
        }
        if (!preg_match("/[a-z]/", $contraseña)) {
            $errores[] = "La contraseña debe de tener al menos una letra minúscula";
        }
        if (!preg_match("/[0-9]/", $contraseña)) {
            $errores[] = "La contraseña debe de tener al menos un número";
        }
        if (!empty($errores)) {
            $errorContraseña = implode("<br>", $errores);
        }
    }

    //CONFIRMACIÓN DE CONTRASEÑA
    if (empty($confirmar)) {
        $errorConfirmacion = "Confirmación requerida";
    } else {
        if ($contraseña !== $confirmar) {
            $errorConfirmacion = "Las contraseñas no coinciden";
        }
    }

    //NÚMERO DE TARJETA
    if (!empty($numTarjeta)) {
        if (strlen($numTarjeta) !== 16) {
            $errorNumTarjeta = "El número de tarjeta debe tener 16 dígitos";
        }
    }

    //FECHA DE CADUCIDAD
    if (!empty($numTarjeta) && empty($errorNumTarjeta)) {
        if (empty($fechaCaducidad)) {
            $errorFechaCaducidad = "Este campo es obligatorio";
        } else {
            $fechaActual = date('Y-m-d');
            $fechaCad = strtotime($fechaCaducidad);
            $fechaAct = strtotime($fechaActual);    

            if ($fechaCad <= $fechaAct) {
                $errorFechaCaducidad = "La fecha de caducidad debe ser mayor a la fecha actual";
            }
        }
    } elseif (empty($numTarjeta) && empty($errorNumTarjeta)) {
        $fechaActual = date('Y-m-d');
        $fechaCad = strtotime($fechaCaducidad);
        $fechaAct = strtotime($fechaActual);

        if ($fechaCad <= $fechaAct) {
            $errorFechaCaducidad = "La fecha de caducidad debe ser mayor a la fecha actual";
        }
    }

    //CÓDIGO DE SEGURIDAD
    if (!empty($numTarjeta) && empty($errorNumTarjeta)) {
        if (empty($codigoSeguridad)) {
            $errorCodigoSeguridad = "Este campo es obligatorio";
        } else {
            if (strlen($codigoSeguridad) !== 3) {
                $errorCodigoSeguridad = "El código de seguridad debe tener 3 dígitos";
            }
        }
    } elseif (empty($numTarjeta) && empty($errorNumTarjeta)) {
        if (strlen($codigoSeguridad) !== 3) {
            $errorCodigoSeguridad = "El código de seguridad debe tener 3 dígitos";
        }
    }

    if (empty($errorNombre) && empty($errorApellido) && empty($errorEmail) && empty($errorContraseña) && empty($errorConfirmacion) && empty($errorNumTarjeta) && empty($errorCodigoSeguridad) && empty($errorFechaCaducidad)) {
        
        $contraEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);

        $sql = "CREATE TABLE IF NOT EXISTS LOGS (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(30) NOT NULL,
            apellido VARCHAR(30) NOT NULL,
            email VARCHAR(30) NOT NULL,
            contraseña VARCHAR(255) NOT NULL,
            direccion_envio VARCHAR(255),
            num_tarjeta VARCHAR(16),
            fecha_caducidad DATE,
            codigo_seguridad VARCHAR(3)
        )";

        if ($conn->query($sql) === TRUE) {
            echo "Tabla creada correctamente";
        } else {
            echo "Error al crear la tabla: " . $conn->error;
        
        }

        echo "<br>";

        $sql2 = "INSERT INTO `LOGS` (`nombre`, `apellido`, `email`, `contraseña`, `direccion_envio`, `num_tarjeta`, `fecha_caducidad`, `codigo_seguridad`)
        VALUES ('$nombre', '$apellido', '$email', '$contraEncriptada', '$direccionEnvio', '$numTarjeta', '$fechaCaducidad', '$codigoSeguridad')";


        if ($conn->query($sql2) === true) {
            echo "Usuario agregado";
            $last_id = $conn->insert_id;
            echo "<br>";
            echo "ID del ultimo usuario: " . $last_id;
            $_SESSION['user_id'] = $last_id;

        } else {
            echo "Error al agregar usuario: " . $conn->error;
        }
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>