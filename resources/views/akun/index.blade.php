@extends('layouts.backoffice')

@section('title', 'Akun - DariKopi')
@section('page_title', 'Akun')

@push('styles')
    <style>
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

        @media (max-width: 768px) {
            .akun-card { padding: 24px; }
            .info-row { flex-direction: column; align-items: flex-start; gap: 8px; }
        }
    </style>
@endpush

@section('content')
    <!-- Header Page -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="color: #2b2d42; font-size: 32px;">Akun</h1>
        <p class="text-muted" style="font-size: 15px;">Kelola informasi akun dan ubah password</p>
    </div>

    <!-- Container Grid untuk membatasi lebar form biar estetik kayak di mockup -->
    <div class="row">
        
        <!-- KOLOM KIRI: OWNER -->
        <div class="col-lg-6 mb-4">
            <h2 class="fw-bold mb-3" style="font-size: 20px; color: #2b2d42;">Pengaturan Owner</h2>
            
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
                    <span class="info-value">{{ auth('owner')->user()->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Username</span>
                    <span class="info-value">{{ auth('owner')->user()->username }}</span>
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
                    
                    <button type="submit" class="btn btn-submit w-100">Ubah Password</button>
                </form>
            </div>


        </div>

        <!-- KOLOM KANAN: BARISTA -->
        <div class="col-lg-6 mb-4">
            <h2 class="fw-bold mb-3" style="font-size: 20px; color: #2b2d42;">Pengaturan Kasir (Barista)</h2>
            
            <div class="akun-card">
                <h3 class="akun-card-title mb-1">Kredensial Barista</h3>
                <p class="text-muted mb-4" style="font-size: 14px;">Ubah username dan password untuk akun yang digunakan di mesin kasir</p>
                
                <form action="{{ route('akun.barista.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label class="form-label-custom">Username Barista</label>
                        <input type="text" class="form-control-custom mb-1" name="barista_username" value="{{ $barista ? $barista->username : '' }}" required>
                        @error('barista_username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label-custom">Password Baru Barista (Opsional)</label>
                        <div class="input-group-custom">
                            <input type="password" class="form-control-custom mb-1" id="baristaPasswordInput" placeholder="Kosongkan jika tidak ingin mengubah password" name="barista_password" style="padding-right: 48px;">
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('baristaPasswordInput', 'eyeIconBarista')">
                                <svg id="eyeIconBarista" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('barista_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-submit w-100">Simpan Perubahan Barista</button>
                </form>
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
                            <input type="text" class="form-control-custom mb-1" name="name" value="{{ auth('owner')->user()->name }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label-custom">Username</label>
                            <input type="text" class="form-control-custom mb-1" name="username" value="{{ auth('owner')->user()->username }}" required>
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
@endsection

@push('scripts')
<script>
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
@endpush
