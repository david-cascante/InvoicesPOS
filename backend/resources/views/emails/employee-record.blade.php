<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Acceso | InvoicesPOS</title>
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
        
        .credentials {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .credential-item {
            display: flex;
            margin-bottom: 15px;
        }
        
        .credential-label {
            font-weight: 600;
            width: 150px;
            color: #4f46e5;
        }
        
        .credential-value {
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
                    <i class="fas fa-user-shield"></i> Credenciales de Acceso para empleado
                </h2>
                
                <p>Hola <strong>{{ $employeeName }}</strong>,</p>
                <p>Te damos la bienvenida a <strong>InvoicesPOS</strong>. A continuación encontrarás tus credenciales de acceso al sistema:</p>
                
                <div class="credentials">
                    <div class="credential-item">
                        <div class="credential-label">Comercio:</div>
                        <div class="credential-value">{{ $shopName }}</div>
                    </div>
                    
                    <div class="credential-item">
                        <div class="credential-label">Nombre:</div>
                        <div class="credential-value">{{ $employeeName }}</div>
                    </div>
                    
                    <div class="credential-item">
                        <div class="credential-label">Cédula:</div>
                        <div class="credential-value">{{ $employeeDocumentId }}</div>
                    </div>
                    
                    <div class="credential-item">
                        <div class="credential-label">Contraseña:</div>
                        <div class="credential-value">{{ $employeeDocumentId }}</div>
                    </div>
                </div>
                
                <div class="warning">
                    <p><i class="fas fa-exclamation-triangle"></i> <strong>Por seguridad, te recomendamos cambiar tu contraseña</strong> después de iniciar sesión por primera vez.</p>
                </div>
                
                <p>Para acceder al sistema, haz clic en el siguiente botón:</p>
                
                <div style="text-align: center;">
                    <a href="{{ url('https://empleado.invoicespos.com') }}" class="button">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                </div>
            </div>
            
            <div class="card">
                <h2 class="title">
                    <i class="fas fa-question-circle"></i> ¿Necesitas ayuda?
                </h2>
                
                <p>Si tienes problemas para acceder al sistema o necesitas asistencia, no dudes en contactar a nuestro equipo de soporte:</p>
                
                <ul style="list-style: none; margin: 15px 0;">
                    <li style="margin-bottom: 10px;"><i class="fas fa-envelope" style="color: #4f46e5; width: 20px;"></i> soporte@invoicespos.com</li>
                    <li style="margin-bottom: 10px;"><i class="fas fa-clock" style="color: #4f46e5; width: 20px;"></i> Lunes a Viernes, 8am - 5pm</li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} InvoicesPOS. Todos los derechos reservados.</p>
            
            <div class="social-links">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
            
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
        </div>
    </div>
</body>
</html>