@extends('layouts.auth')

@section('title', 'Register - Dapur Aunty Fahira')

@section('form')
    <form id="register-form" method="POST" action="{{ route('register') }}">
        @csrf

        @if ($errors->has('register'))
            <div class="alert alert-danger">{{ $errors->first('register') }}</div>
        @endif

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone') }}" required pattern="[0-9]{10,15}" inputmode="numeric" maxlength="15"
                placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control" required>
                <span class="input-group-text">
                    <i class="bi bi-eye-slash" id="togglePasswordConfirmation" style="cursor: pointer;"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-maroon w-100 mb-2">Daftar</button>
        <div class="text-center">
            <small>Sudah punya akun? <a href="{{ route('showLogin') }}" class="form-toggle">Login di sini</a></small>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#passwordConfirmation');

        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
@endpush
