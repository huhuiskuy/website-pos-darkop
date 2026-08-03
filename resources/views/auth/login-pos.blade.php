<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login POS - DariKopi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Background estetik dengan gradasi soft (Sama persis dengan Back Office) */
        body { 
            background: radial-gradient(circle at center, #F5EFE9 0%, #E6D9CC 100%);
            font-family: 'Poppins', sans-serif; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        /* Styling Card Login */
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 10px 40px rgba(138, 90, 54, 0.05); 
            margin: 20px;
        }

        /* Branding Text */
        .brand-title {
            font-size: 22px;
            font-weight: 700;
            color: #795238; 
            line-height: 1.2;
            text-align: center;
            margin-bottom: 2px;
        }
        .brand-subtitle {
            font-size: 11px;
            color: #887B72;
            text-align: center;
            margin-bottom: 32px;
            font-weight: 500;
        }

        /* Heading Text */
        .welcome-title {
            font-size: 28px;
            font-weight: 800;
            color: #382A22; 
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .welcome-subtitle {
            font-size: 13px;
            color: #5C524B;
            text-align: center;
            margin-bottom: 32px;
        }

        /* Styling Form & Input */
        .form-label-custom {
            font-size: 12px;
            font-weight: 700;
            color: #382A22;
            margin-bottom: 8px;
            display: block;
        }
        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
        }
        .form-control-custom {
            width: 100%;
            border: 1px solid #EBE3DB;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 13px;
            color: #2b2d42;
            transition: all 0.2s ease;
            background: #ffffff;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #8A6044;
            box-shadow: 0 0 0 4px rgba(138, 96, 68, 0.1);
        }
        .form-control-custom::placeholder {
            color: #AFA69D;
            font-weight: 400;
        }

        /* Ikon Mata Password */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #AFA69D;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        .password-toggle:hover { color: #8A6044; }
        .password-toggle:focus { outline: none; }

        /* Tombol Masuk */
        .btn-login {
            background: #8A6044; 
            color: white;
            border: none;
            padding: 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.2s;
            width: 100%;
            margin-top: 8px;
        }
        .btn-login:hover {
            background: #734F37;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(138, 96, 68, 0.2);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logo / Brand sesuai Mockup -->
        <div class="brand-title">DariKopi</div>
        <div class="brand-subtitle">Point of Sales</div>

        <!-- Judul sesuai Mockup -->
        <div class="welcome-title">Welcome</div>
        <div class="welcome-subtitle">Login Kasir POS — Silakan login untuk melanjutkan</div>

        <!-- Form Login tetep diarahkan ke auth controller yang sama -->
        <form action="{{ route('login.admin.post') }}" method="POST">
            @csrf
            
            <!-- INPUT HIDDEN: Ini ngasih tau backend kalo yang login ini mau ke POS -->
            <input type="hidden" name="login_source" value="pos">

            <!-- Pesan Error -->
            @error('username')
                <div class="alert alert-danger" style="font-size: 13px; padding: 10px; border-radius: 8px;">
                    {{ $message }}
                </div>
            @enderror

            <!-- Username -->
            <label class="form-label-custom">Username</label>
            <div class="input-group-custom">
                <input type="text" class="form-control-custom" placeholder="Masukkan username" name="username" value="{{ old('username') }}" required>
            </div>

            <!-- Password -->
            <label class="form-label-custom">Password</label>
            <div class="input-group-custom">
                <input type="password" class="form-control-custom" id="passwordInput" placeholder="Masukkan password" name="password" style="padding-right: 48px;" required>
                <!-- Tombol Mata (Toggle Password) -->
                <button type="button" class="password-toggle" id="togglePasswordBtn">
                    <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>

            <!-- Tombol Submit sesuai Mockup -->
            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>

    <!-- Script Javascript untuk Fitur Intip Password -->
    <script>
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordBtn.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    </script>
</body>
</html>
