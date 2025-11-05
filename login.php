<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validaciones
    $errors = [];
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email válido es requerido";
    }
    
    if (empty($password)) {
        $errors[] = "La contraseña es requerida";
    }
    
    // Verificar credenciales
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Credenciales correctas, iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                
                // Actualizar último acceso
                $update_stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
                $update_stmt->execute([$user['id']]);
                
                // Redirigir al dashboard o página principal
                header("Location: dashboard.php");
                exit();
                
            } else {
                $errors[] = "Email o contraseña incorrectos";
            }
            
        } catch(PDOException $e) {
            $errors[] = "Error al iniciar sesión";
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