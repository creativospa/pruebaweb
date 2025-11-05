<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validaciones
    $errors = [];
    
    if (empty($nombre)) {
        $errors[] = "El nombre es requerido";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email válido es requerido";
    }
    
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Las contraseñas no coinciden";
    }
    
    // Verificar si el email ya existe
    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Este email ya está registrado";
        }
    } catch(PDOException $e) {
        $errors[] = "Error al verificar el email";
    }
    
    // Si no hay errores, registrar el usuario
    if (empty($errors)) {
        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, fecha_registro) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$nombre, $email, $password_hash]);
            
            // Obtener el ID del usuario registrado
            $user_id = $pdo->lastInsertId();
            
            // Iniciar sesión automáticamente
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_email'] = $email;
            
            // Redirigir con mensaje de éxito
            header("Location: index.html?registro=exitoso");
            exit();
            
        } catch(PDOException $e) {
            $errors[] = "Error al registrar usuario: " . $e->getMessage();
        }
    }
    
    // Si hay errores, mostrarlos
    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script>
                alert('$error_message');
                window.history.back();
              </script>";
    }
} else {
    header("Location: index.html");
    exit();
}
?>