<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    <!-- Include Tailwind CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .full-screen-bg {
            background-image: url('{{ asset('images/bg-login.png') }}');
            background-size: cover;
            background-position: center;
        }
        .input-wrapper {
            position: relative;
            margin-bottom: 1rem; /* Maintain spacing between fields */
        }
        .input-wrapper input {
            padding-right: 3rem; /* Add space for the icon and align text */
        }
        .input-wrapper .fa-eye,
        .input-wrapper .fa-eye-slash {
            position: absolute;
            right: 0.5rem; /* Adjust as needed */
            top: 50%; /* Center vertically */
            transform: translateY(-50%); /* Center vertically */
            pointer-events: none; /* Prevent clicks on the icon from affecting input */
        }
    </style>
</head>
<body class="full-screen-bg flex items-center justify-center min-h-screen p-4">
<div class="w-full max-w-md md:max-w-4xl bg-white rounded-lg shadow-lg p-8 relative">
    <!-- Logo Section -->
    <div class="flex items-center mb-8 relative">
        <img class="w-24 md:w-32 mb-4" src="{{ asset('images/nearus.png') }}" alt="Logo" />
        <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-400"></div>
    </div>

    <!-- Welcome Text -->
    <div class="text-2xl md:text-3xl font-bold text-black mb-2">
        Selamat Datang Kembali Admin
    </div>
    <div class="text-lg md:text-xl font-light text-black mb-6">
        Silahkan Masukkan email dan password
    </div>

    <!-- Form Section -->
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <!-- Email Input -->
        <div class="input-wrapper">
            <label for="email" class="block text-neutral-500 text-base md:text-lg font-medium mb-2">Email</label>
            <input type="email" id="email" name="email" class="block w-full border-b border-black py-2 px-3 text-black text-opacity-80 text-base md:text-lg font-semibold outline-none" placeholder="Masukkan Email Anda" required />
        </div>

        <!-- Password Input -->
        <div class="input-wrapper">
            <label for="password" class="block text-neutral-500 text-base md:text-lg font-medium mb-2">Password</label>
            <input type="password" id="password" name="password" class="block w-full border-b border-black py-2 px-3 text-black text-opacity-80 text-base md:text-lg font-semibold outline-none pr-10" placeholder="Masukkan Kata Sandi Anda" />
            <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center" onclick="togglePasswordVisibility('password')">
                <i id="eye-icon" class="fas fa-eye text-gray-500"></i>
            </button>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 bg-gradient-to-r from-sky-300 to-blue-500 text-white text-base md:text-lg font-bold rounded-md shadow-md transition-transform duration-300 hover:scale-105">
            Login
        </button>
    </form>
</div>

<script>
    function togglePasswordVisibility(id) {
        const passwordInput = document.getElementById(id);
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
