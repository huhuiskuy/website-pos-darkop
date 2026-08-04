<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun - DariKopi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #F9F6F0; font-family: 'Poppins', sans-serif; color: #2b2d42; }
        
        /* ================= SIDEBAR ================= */
        .sidebar { width: 240px; height: 100vh; background-color: #ffffff; border-right: 1px solid #EBE3DB; position: fixed; display: flex; flex-direction: column; padding: 24px 0; z-index: 100;}
        .sidebar-brand { font-size: 24px; font-weight: 700; color: #8a5a36; padding: 0 24px; line-height: 1.2;}
        .sidebar-subtitle { font-size: 11px; color: #94a3b8; padding: 0 24px; margin-bottom: 24px; }
        .sidebar-divider { border-top: 1px solid #EBE3DB; margin: 0 24px 24px 24px; }
        
        .nav-menu { display: flex; flex-direction: column; gap: 16px; padding: 0 12px; }
        .nav-menu a { display: flex; align-items: center; padding: 12px; color: #64748b; text-decoration: none; font-size: 15px; font-weight: 500; border-radius: 12px; transition: all 0.2s ease; position: relative; margin: 0 12px; }
        .nav-menu a svg { flex-shrink: 0; margin-right: 12px; }
        .nav-menu a:hover { color: #8a5a36; background-color: #faf7f5; }
        
        .nav-menu .active { background-color: #EBE1D7; color: #8a5a36; font-weight: 600; padding-left: 30px; }
        .nav-menu .active::before { content: ""; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 4px; height: 24px; background-color: #8a5a36; border-radius: 10px; }

        .user-card { background: #ffffff; border: 1px solid #f1f5f9; border-radius: 12px; padding: 12px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px; }
        .user-name { font-size: 13px; font-weight: 700; color: #2b2d42; margin-bottom: 2px;}
        .user-role { font-size: 11px; color: #94a3b8; }
        
        .btn-logout { display: flex; justify-content: left; align-items: center; gap: 12px; width: 100%; padding: 12px; border-radius: 12px; background: transparent; border: 1px solid #E8DDD2; color: #8a5a36; font-weight: 600; font-size: 15px; text-decoration: none; transition: 0.2s; }
        .btn-logout:hover { background: #faf7f5; border-color: #8a5a36; color: #8a5a36; }
        
        /* ================= MAIN CONTENT ================= */
        .main-content { margin-left: 240px; padding: 24px 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; background-color: #ffffff; padding: 20px 32px; margin: -24px -32px 32px -32px; border-bottom: 1px solid #EBE3DB; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 24px; font-weight: 700; color: #262626; margin: 0; }
        .clock-badge { display: flex; align-items: center; gap: 8px; padding: 8px 16px; background-color: #ffffff; border: 1px solid #E8DDD2; border-radius: 12px; color: #262626; font-weight: 500; font-size: 14px; }
        
        /* ================= KONTEN AKUN ================= */
        .akun-card { background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB; }
        .akun-card-title { font-size: 22px; font-weight: 700; color: #2b2d42; margin-bottom: 24px; }
        
        .info-section-title { font-size: 16px; font-weight: 700; color: #2b2d42; }
        .btn-edit { font-size: 13px; font-weight: 600; color: #8a5a36; text-decoration: none; border-bottom: 1px solid transparent; transition: 0.2s; }
        .btn-edit:hover { color: #734a2c; border-bottom: 1px solid #734a2c; }

        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #f1f5f9; }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-label { font-size: 14px; font-weight: 600; color: #2b2d42; }
        .info-value { font-size: 14px; font-weight: 600; color: #1e1e1e; }

        .form-label-custom { font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px; display: block;}
        .form-control-custom { width: 100%; border: 1px solid #EBE3DB; border-radius: 12px; padding: 12px 16px; font-size: 14px; color: #2b2d42; transition: 0.2s; background: #ffffff; margin-bottom: 20px;}
        .form-control-custom:focus { outline: none; border-color: #8a5a36; box-shadow: 0 0 0 4px rgba(138, 90, 54, 0.1); }
        .form-control-custom::placeholder { color: #cbd5e1; font-weight: 400; }
        
        .btn-submit { background: #8a5a36; color: white; border: none; padding: 12px 24px; font-size: 14px; font-weight: 600; border-radius: 8px; transition: 0.2s; margin-top: 4px;}
        .btn-submit:hover { background: #734a2c; color: white; }

        /* Ikon Mata Password */
        .input-group-custom { position: relative; width: 100%; }
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
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <div class="sidebar-brand">DariKopi</div>
        <div class="sidebar-subtitle">Back Office</div>
    </div>
    <div class="sidebar-divider"></div>
    <div class="nav-menu">
        <a href="{{ route('dashboard.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 17.5V10.8333C12.5 10.6123 12.4122 10.4004 12.2559 10.2441C12.0996 10.0878 11.8877 9.99999 11.6667 9.99999H8.33333C8.11232 9.99999 7.90036 10.0878 7.74408 10.2441C7.5878 10.4004 7.5 10.6123 7.5 10.8333V17.5M2.5 8.33333C2.49994 8.09088 2.55278 7.85135 2.65482 7.63142C2.75687 7.4115 2.90566 7.21649 3.09083 7.05999L8.92417 2.05999C9.22499 1.80575 9.60613 1.66626 10 1.66626C10.3939 1.66626 10.775 1.80575 11.0758 2.05999L16.9092 7.05999C17.0943 7.21649 17.2431 7.4115 17.3452 7.63142C17.4472 7.85135 17.5001 8.09088 17.5 8.33333V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Dashboard</a>
        <a href="{{ route('menu.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 4.99992L16.6667 16.6666M9.99999 4.99992V16.6666M6.66666 6.66659V16.6666M3.33333 3.33325V16.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Menu</a>
        <a href="{{ route('bahan-baku.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 18.3334V10.0001M10 10.0001L2.74167 5.83341M10 10.0001L17.2583 5.83341M6.25 3.55841L13.75 7.85008M9.16667 18.1084C9.42003 18.2547 9.70744 18.3317 10 18.3317C10.2926 18.3317 10.58 18.2547 10.8333 18.1084L16.6667 14.7751C16.9198 14.6289 17.13 14.4188 17.2763 14.1658C17.4225 13.9127 17.4997 13.6257 17.5 13.3334V6.66675C17.4997 6.37448 17.4225 6.08742 17.2763 5.83438C17.13 5.58134 16.9198 5.37122 16.6667 5.22508L10.8333 1.89175C10.58 1.74547 10.2926 1.66846 10 1.66846C9.70744 1.66846 9.42003 1.74547 9.16667 1.89175L3.33333 5.22508C3.08022 5.37122 2.86998 5.58134 2.72372 5.83438C2.57745 6.08742 2.5003 6.37448 2.5 6.66675V13.3334C2.5003 13.6257 2.57745 13.9127 2.72372 14.1658C2.86998 14.4188 3.08022 14.6289 3.33333 14.7751L9.16667 18.1084Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Bahan Baku</a>
        <a href="{{ route('laporan.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 2.5V15.8333C2.5 16.2754 2.67559 16.6993 2.98816 17.0118C3.30072 17.3244 3.72464 17.5 4.16667 17.5H17.5M5.83333 13.3333H12.5M5.83333 9.16667H15.8333M5.83333 5H8.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Laporan</a>
        <a href="{{ route('akun.index') }}" class="active"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Akun</a>
    </div>
    <div class="mt-auto px-4">
        <div class="user-card"><div class="user-name">{{ auth()->user()->name }}</div></div>
        <div style="border-top: 1px solid #EBE3DB; margin: 0 8px 16px 8px;"></div>
        <!-- TOMBOL LOGOUT BARU -->
        <a href="#" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 5.83333L17.5 10L13.3333 14.1667M17.5 10H7.5M7.5 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Keluar
        </a>

        <!-- Form tersembunyi buat eksekusi POST Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="topbar">
        <h2 class="topbar-title">Akun</h2>
        <div class="clock-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6V12L16 14" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span id="realtime-clock">--:-- WIB</span>
        </div>
    </div>

    <!-- Header Page -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="color: #2b2d42; font-size: 32px;">Akun</h1>
        <p class="text-muted" style="font-size: 15px;">Kelola informasi akun dan ubah password</p>
    </div>

    <!-- Container Grid untuk membatasi lebar form biar estetik kayak di mockup -->
    <div class="row">
        <div class="col-lg-6 col-md-8">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; font-size: 14px; font-weight: 500;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; font-size: 14px; font-weight: 500;">
                Terdapat beberapa kesalahan. Silakan periksa kembali.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <!-- CARD 1: INFORMASI AKUN -->
            <div class="akun-card mb-4">
                <h3 class="akun-card-title">Akun</h3>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="info-section-title">Informasi Akun</div>
                    <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit</a>
                </div>
                
                <!-- Data Table -->
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-value">{{ auth()->user()->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Username</span>
                    <span class="info-value">{{ auth()->user()->username }}</span>
                </div>
            </div>

            <!-- CARD 2: UBAH PASSWORD -->
            <div class="akun-card">
                <h3 class="akun-card-title mb-1">Ubah Password</h3>
                <p class="text-muted mb-4" style="font-size: 14px;">Pastikan password baru mudah diingat namun tetap aman</p>
                
                <form action="{{ route('akun.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label class="form-label-custom">Password Saat Ini</label>
                        <div class="input-group-custom">
                            <input type="password" class="form-control-custom mb-1" id="currentPasswordInput" placeholder="Masukkan password saat ini" name="current_password" style="padding-right: 48px;" required>
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('currentPasswordInput', 'eyeIconCurrent')">
                                <svg id="eyeIconCurrent" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label-custom">Password Baru</label>
                        <div class="input-group-custom">
                            <input type="password" class="form-control-custom mb-1" id="newPasswordInput" placeholder="Masukkan password baru" name="new_password" style="padding-right: 48px;" required>
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('newPasswordInput', 'eyeIconNew')">
                                <svg id="eyeIconNew" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label-custom">Konfirmasi Password Baru</label>
                        <div class="input-group-custom">
                            <input type="password" class="form-control-custom mb-1" id="confirmPasswordInput" placeholder="Ulangi password baru" name="new_password_confirmation" style="padding-right: 48px;" required>
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('confirmPasswordInput', 'eyeIconConfirm')">
                                <svg id="eyeIconConfirm" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-submit">Ubah Password</button>
                </form>
            </div>

        </div>
    </div>

</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 20px 24px;">
                <h5 class="modal-title fw-bold" id="editProfileModalLabel" style="color: #2b2d42;">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('akun.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 24px;">
                    <div class="form-group mb-3">
                        <label class="form-label-custom">Nama</label>
                        <input type="text" class="form-control-custom mb-1" name="name" value="{{ auth()->user()->name }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label-custom">Username</label>
                        <input type="text" class="form-control-custom mb-1" name="username" value="{{ auth()->user()->username }}" required>
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                    <button type="submit" class="btn btn-submit" style="margin-top: 0;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-Update Jam -->
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('realtime-clock').textContent = `${hours}:${minutes} WIB`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);
        
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }
</script>

</body>
</html>
