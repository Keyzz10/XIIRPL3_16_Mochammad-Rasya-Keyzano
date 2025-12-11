<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - FlowTask</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at top left, #2563eb 0%, #1d4ed8 40%, #0b1120 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-wrapper {
            max-width: 1100px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.55);
            overflow: hidden;
            display: flex;
            min-height: 520px;
        }

        .auth-left {
            flex: 1.1;
            background: radial-gradient(circle at top left, #2563eb 0%, #1d4ed8 35%, #1e3a8a 70%, #020617 100%);
            color: #f9fafb;
            padding: 48px 40px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-left h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .auth-left p {
            font-size: 15px;
            max-width: 320px;
            color: #e5e7eb;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.45);
            font-size: 12px;
            margin-bottom: 18px;
            gap: 8px;
        }

        .auth-badge i {
            color: #38bdf8;
        }

        .shape-circle,
        .shape-dots,
        .shape-wave {
            position: absolute;
            opacity: 0.25;
        }

        .shape-circle {
            width: 140px;
            height: 140px;
            border-radius: 999px;
            border: 2px solid rgba(248, 250, 252, 0.35);
            top: 40px;
            right: 40px;
        }

        .shape-dots {
            width: 80px;
            height: 120px;
            right: 40px;
            bottom: 40px;
            background-image: radial-gradient(circle, #e5e7eb 2px, transparent 2px);
            background-size: 12px 12px;
        }

        .shape-wave {
            left: -40px;
            bottom: -40px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(248, 250, 252, 0.16), transparent 60%);
        }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .auth-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.6);
        }

        .auth-logo-title {
            display: flex;
            flex-direction: column;
        }

        .auth-logo-title span:first-child {
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .auth-logo-title span:last-child {
            font-size: 12px;
            color: #e5e7eb;
        }

        .auth-right {
            flex: 1;
            padding: 40px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #f9fafb;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }

        .auth-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        .form-control {
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            padding: 10px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
            background-color: #ffffff;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        .input-group-text {
            border-radius: 999px 0 0 999px;
            border: 1px solid #e5e7eb;
            border-right: none;
            background: #f9fafb;
            color: #6b7280;
        }

        .input-group .form-control {
            border-radius: 0 999px 999px 0;
            border-left: none;
        }

        #togglePassword {
            border-radius: 0 999px 999px 0;
            border: 1px solid #e5e7eb;
            border-left: none;
            background: #f9fafb;
            color: #6b7280;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e3a8a 100%);
            border: none;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 12px 30px rgba(79, 70, 229, 0.45);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 40px rgba(79, 70, 229, 0.6);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.5);
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 14px;
        }

        .auth-footer-text {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 16px;
        }

        .auth-footer-text a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .auth-wrapper {
                max-width: 95%;
            }
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-left {
                padding: 32px 24px;
                text-align: center;
            }

            .auth-left p {
                margin-left: auto;
                margin-right: auto;
            }

            .shape-circle,
            .shape-dots,
            .shape-wave {
                display: none;
            }

            .auth-right {
                padding: 28px 24px 32px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="auth-logo">
                <div class="auth-logo-icon">
                    <img src="uploads/images (2).png" alt="FlowTask logo" style="width: 26px; height: 26px; border-radius: 8px; object-fit: cover;">
                </div>
                <div class="auth-logo-title">
                    <span>FlowTask</span>
                    <span>Sistem Manajemen Proyek</span>
                </div>
            </div>

            <div class="auth-badge">
                <i class="fas fa-bolt"></i>
                <span>Tetap produktif, kelola proyek dengan rapi</span>
            </div>

            <h1>Welcome back!</h1>
            <p>Masuk untuk melanjutkan pekerjaan Anda, memantau progres tugas, dan berkolaborasi dengan tim.</p>

            <div class="shape-circle"></div>
            <div class="shape-dots"></div>
            <div class="shape-wave"></div>
        </div>

        <div class="auth-right">
            <div class="mb-3">
                <div class="auth-title">Login</div>
            </div>

            <?php if (isset($errors['login'])): ?>
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo $errors['login']; ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="loginForm" class="mb-2">
                <div class="mb-3">
                    <label for="email" class="form-label small text-muted mb-1">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="email"
                               class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                               id="email"
                               name="email"
                               placeholder="Masukkan email Anda"
                               value="<?php echo $_POST['email'] ?? ''; ?>"
                               required>
                    </div>
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback d-block">
                            <?php echo $errors['email']; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small text-muted mb-1">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password"
                               class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>"
                               id="password"
                               name="password"
                               placeholder="Masukkan kata sandi Anda"
                               required>
                        <button class="btn" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="invalid-feedback d-block">
                            <?php echo $errors['password']; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-1">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                alert('Mohon isi semua field');
                return false;
            }
            
            if (!validateEmail(email)) {
                e.preventDefault();
                alert('Mohon masukkan alamat email yang valid');
                return false;
            }
        });
        
        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
        
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
    
    <!-- Auth redirect script -->
    <script src="app/views/layouts/auth_redirect.js"></script>
</body>
</html>