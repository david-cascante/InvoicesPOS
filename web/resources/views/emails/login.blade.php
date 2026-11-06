<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Inicio de Sesión | InvoicesPOS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #374151;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .content {
            padding: 30px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #e5e7eb;
        }
        
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .title i {
            margin-right: 10px;
            color: #4f46e5;
        }
        
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 20px 0;
        }
        
        .login-info {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 15px;
        }
        
        .info-label {
            font-weight: 600;
            width: 150px;
            color: #4f46e5;
        }
        
        .info-value {
            flex: 1;
            font-weight: 500;
        }
        
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .security {
            background-color: #dcfce7;
            border-left: 4px solid #22c55e;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 15px;
            text-align: center;
        }
        
        .button:hover {
            background-color: #4338ca;
        }
        
        .footer {
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        
        .social-links {
            margin: 15px 0;
        }
        
        .social-links a {
            color: #4f46e5;
            margin: 0 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <i class="fas fa-cash-register"></i> InvoicesPOS
            </div>
            <p>Tu sistema de punto de venta confiable y eficiente</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="card">
                <h2 class="title">
                    <i class="fas fa-user-check"></i> Notificación de Inicio de Sesión
                </h2>
                
                <p>Hola,</p>
                <p>Se ha detectado un inicio de sesión en tu cuenta de <strong>InvoicesPOS</strong>. A continuación encontrarás los detalles del acceso:</p>
                
                <div class="login-info">
                    <div class="info-item">
                        <div class="info-label">Fecha y hora:</div>
                        <div class="info-value">25 de Mayo, 2023 - 14:30</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Dispositivo:</div>
                        <div class="info-value">Chrome en Windows</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Ubicación:</div>
                        <div class="info-value">Bogotá, Colombia</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Dirección IP:</div>
                        <div class="info-value">192.168.1.100</div>
                    </div>
                </div>
                
                <div class="security">
                    <p><i class="fas fa-shield-alt"></i> <strong>¿Reconoces esta actividad?</strong> Si fuiste tú, no es necesario realizar ninguna acción.</p>
                </div>
                
                <div class="warning">
                    <p><i class="fas fa-exclamation-triangle"></i> <strong>¿No reconoces este inicio de sesión?</strong> Te recomendamos cambiar tu contraseña inmediatamente y contactar a soporte.</p>
                </div>
                
                <div style="text-align: center;">
                    <a href="https://invoicespos.com/user/profile" class="button">
                        <i class="fas fa-lock"></i> Cambiar Contraseña
                    </a>
                </div>
            </div>
            
            <div class="card">
                <h2 class="title">
                    <i class="fas fa-question-circle"></i> ¿Necesitas ayuda?
                </h2>
                
                <p>Si tienes problemas con tu cuenta o necesitas reportar actividad sospechosa, no dudes en contactar a nuestro equipo de soporte:</p>
                
                <ul style="list-style: none; margin: 15px 0;">
                    <li style="margin-bottom: 10px;"><i class="fas fa-envelope" style="color: #4f46e5; width: 20px;"></i> soporte@invoicespos.com</li>
                    <li style="margin-bottom: 10px;"><i class="fas fa-clock" style="color: #4f46e5; width: 20px;"></i> Lunes a Viernes, 8am - 5pm</li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© 2023 InvoicesPOS. Todos los derechos reservados.</p>
            
            <div class="social-links">
                <a href="https://instagram.com/invoicesposcr"><i class="fab fa-instagram"></i></a>
            </div>
            
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
        </div>
    </div>
</body>
</html>