<?php
require_once 'config.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hosting Creativos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .welcome-msg h1 {
            color: #667eea;
            font-size: 2rem;
        }

        .welcome-msg p {
            color: #666;
            margin-top: 10px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card h3 {
            color: #667eea;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .dashboard-card p {
            color: #666;
            line-height: 1.6;
        }

        .card-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .card-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <div class="welcome-msg">
                <h1>¡Bienvenido, <?php echo htmlspecialchars($user_name); ?>!</h1>
                <p>Email: <?php echo htmlspecialchars($user_email); ?></p>
            </div>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Mis Servidores</h3>
                <p>Administra tus servidores de hosting, configúralos y monitorea su rendimiento.</p>
                <a href="#" class="card-button">Ver Servidores</a>
            </div>

            <div class="dashboard-card">
                <h3>Planes de Hosting</h3>
                <p>Explora nuestros planes de hosting y actualiza tu suscripción actual.</p>
                <a href="index.html" class="card-button">Ver Planes</a>
            </div>

            <div class="dashboard-card">
                <h3>Facturación</h3>
                <p>Consulta tus facturas, historial de pagos y métodos de pago guardados.</p>
                <a href="#" class="card-button">Ver Facturas</a>
            </div>

            <div class="dashboard-card">
                <h3>Soporte Técnico</h3>
                <p>¿Necesitas ayuda? Contacta con nuestro equipo de soporte técnico 24/7.</p>
                <a href="#" class="card-button">Contactar Soporte</a>
            </div>

            <div class="dashboard-card">
                <h3>Configuración de Cuenta</h3>
                <p>Actualiza tu información personal, cambia tu contraseña y configura la seguridad.</p>
                <a href="#" class="card-button">Configurar Cuenta</a>
            </div>

            <div class="dashboard-card">
                <h3>Estadísticas</h3>
                <p>Monitorea el uso de recursos, tráfico y rendimiento de tus servidores.</p>
                <a href="#" class="card-button">Ver Estadísticas</a>
            </div>
        </div>
    </div>
</body>
</html>