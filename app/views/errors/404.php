<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found - FlowTask</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 60px;
            text-align: center;
            max-width: 600px;
        }
        
        .error-number {
            font-size: 8rem;
            font-weight: 900;
            color: #2563eb;
            margin: 0;
            line-height: 1;
        }
        
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1e293b;
            margin: 20px 0;
        }
        
        .error-description {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }
        
        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="error-container">
                    <div class="error-number">404</div>
                    <h1 class="error-title">Page Not Found</h1>
                    <p class="error-description">
                        Oops! The page you're looking for doesn't exist.<br>
                        It might have been moved, deleted, or you entered the wrong URL.
                    </p>
                    
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>
                            Go Home
                        </a>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Go Back
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-muted mb-0">
                            If you believe this is a mistake, please contact the administrator.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>