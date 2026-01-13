<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestor de Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        .auth-wrapper {
            display: flex;
            height: 100vh;
        }

        /* Left side - Illustration */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 50%, #0a4fb0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            filter: blur(40px);
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: 10%;
            width: 350px;
            height: 350px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            filter: blur(40px);
        }

        .illustration {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
        }

        .illustration svg {
            width: 100%;
            max-width: 280px;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
        }

        .illustration h2 {
            margin-top: 2rem;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .illustration p {
            margin-top: 0.5rem;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        /* Right side - Form */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: white;
        }

        .form-container {
            width: 100%;
            max-width: 380px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f0f7ff 0%, #e8f2ff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }

        .form-icon svg {
            width: 35px;
            height: 35px;
            stroke: #0d6efd;
            stroke-width: 2;
            fill: none;
        }

        .form-header h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }

        .form-header p {
            color: #888;
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0d6efd;
            background: white;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #0d6efd;
        }

        .form-checkbox label {
            margin: 0;
            cursor: pointer;
            color: #666;
            font-weight: 500;
        }

        .forgot-password {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #0b5ed7;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 110, 253, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .form-footer p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }

        .form-footer a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .form-footer a:hover {
            color: #0b5ed7;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            body {
                height: auto;
                overflow: auto;
            }

            .auth-left {
                min-height: 220px;
                padding: 2rem 1rem;
                flex: 0;
            }

            .auth-right {
                min-height: auto;
                padding: 1.5rem;
                flex: 0;
            }

            .illustration svg {
                max-width: 200px;
            }

            .illustration h2 {
                font-size: 1.3rem;
                margin-top: 1.2rem;
            }

            .illustration p {
                font-size: 0.8rem;
                margin-top: 0.4rem;
            }

            .form-container {
                max-width: 100%;
            }

            .form-header {
                margin-bottom: 1.5rem;
            }

            .form-header h1 {
                font-size: 1.2rem;
            }

            .form-icon {
                width: 50px;
                height: 50px;
                margin: 0 auto 0.8rem;
            }

            .form-icon svg {
                width: 30px;
                height: 30px;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .btn-login {
                padding: 0.8rem;
                font-size: 0.95rem;
            }

            .form-options {
                margin-bottom: 1.2rem;
                font-size: 0.85rem;
            }

            .form-footer {
                margin-top: 1.2rem;
            }

            .form-footer p {
                font-size: 0.85rem;
            }

            .form-footer a {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .auth-left {
                min-height: 180px;
                padding: 1.5rem 1rem;
            }

            .auth-right {
                padding: 1rem;
                min-height: auto;
            }

            .illustration svg {
                max-width: 150px;
            }

            .illustration h2 {
                font-size: 1.1rem;
                margin-top: 1rem;
            }

            .illustration p {
                font-size: 0.75rem;
            }

            .form-container {
                max-width: 100%;
                padding: 0;
            }

            .form-header {
                margin-bottom: 1.2rem;
            }

            .form-header h1 {
                font-size: 1.1rem;
            }

            .form-header p {
                font-size: 0.75rem;
                margin-top: 0.2rem;
            }

            .form-icon {
                width: 45px;
                height: 45px;
                margin: 0 auto 0.6rem;
            }

            .form-icon svg {
                width: 25px;
                height: 25px;
            }

            .form-group {
                margin-bottom: 0.9rem;
            }

            .form-group label {
                font-size: 0.8rem;
                margin-bottom: 0.4rem;
            }

            .form-group input {
                padding: 0.65rem 0.8rem;
                font-size: 16px;
                border-radius: 6px;
            }

            .form-options {
                margin-bottom: 1rem;
                font-size: 0.8rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .form-checkbox {
                gap: 0.4rem;
            }

            .form-checkbox input {
                width: 16px;
                height: 16px;
            }

            .btn-login {
                padding: 0.7rem;
                font-size: 0.9rem;
                margin-bottom: 0.8rem;
            }

            .form-footer {
                margin-top: 1rem;
            }

            .form-footer p {
                font-size: 0.8rem;
            }

            .form-footer a {
                font-size: 0.8rem;
            }

            .forgot-password {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Left Side - Illustration -->
        <div class="auth-left">
            <div class="illustration">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="lockGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ffffff;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#e8f2ff;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <!-- Monitor frame -->
                    <rect x="30" y="30" width="140" height="90" rx="6" fill="none" stroke="white" stroke-width="3"/>
                    <rect x="35" y="35" width="130" height="80" rx="4" fill="#e8f2ff" opacity="0.2"/>
                    <!-- Monitor stand -->
                    <rect x="80" y="120" width="40" height="8" fill="white"/>
                    <polygon points="75,128 125,128 115,140 85,140" fill="white"/>
                    <!-- Lock icon on screen -->
                    <g transform="translate(100, 75)">
                        <rect x="-20" y="-10" width="40" height="35" rx="3" fill="none" stroke="white" stroke-width="2.5"/>
                        <path d="M -10 -10 Q -10 -20 0 -20 Q 10 -20 10 -10" fill="none" stroke="white" stroke-width="2.5"/>
                        <circle cx="0" cy="10" r="2.5" fill="white"/>
                    </g>
                </svg>
                <h2>Acesso Seguro</h2>
                <p>Gestor de Stock</p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="form-container">
                <div class="form-header">
                    <div class="form-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M 4 20 Q 4 14 12 14 Q 20 14 20 20"/>
                        </svg>
                    </div>
                    <h1>USER LOGIN</h1>
                    <p>Bem-vindo de volta</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0.25rem 0;">{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.login.post') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="seu@email.com">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>

                    <div class="form-options">
                        <div class="form-checkbox">
                            <input type="checkbox" id="remember" name="remember" value="1">
                            <label for="remember">Lembrar-me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Esqueci a password</a>
                    </div>

                    <button type="submit" class="btn-login">LOGIN</button>
                </form>

                <div class="form-footer">
                    <p>Não tens conta? <a href="{{ route('auth.register') }}">Registar agora</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
