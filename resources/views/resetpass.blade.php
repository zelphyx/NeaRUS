<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="full-screen-bg flex items-center justify-center h-screen">
<div class="w-[1147px] h-[803px] relative">
    <!-- Background Box -->
    <div class="w-[1147px] h-[650px] absolute bg-white rounded-[15px] shadow-inner border border-blue-600"></div>

    <!-- Blue Border -->
    <div class="w-[1038px] h-[0px] absolute border-4 border-blue-400"></div>

    <!-- Logo -->
    <div class="w-[172px] h-[49px] absolute">
        <img class="absolute" src="{{ asset('images/nearus.png') }}" alt="Logo" />
        <div class="w-4 h-4 absolute"></div>
        <div class="w-2 h-[8.17px] absolute bg-sky-600 rounded-full"></div>
    </div>

    <!-- Title -->
    <div class="w-[707px] absolute text-black text-[28px] font-bold font-montserrat leading-[41.48px] tracking-wide">
        Silahkan Masukkan Kata Sandi Baru Anda
    </div>

    <!-- Password Input -->
    <form method="POST" action="{{ url('/reset-password') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="w-[571px] h-[90px] absolute" id="PasswordInput">
            <label for="password" class="absolute text-neutral-500 text-xl font-medium font-sans leading-normal">Kata Sandi</label>
            <input id="password" name="password" class="absolute text-black text-opacity-80 text-lg font-semibold font-sans leading-tight outline-none border-b border-black w-[570px]" placeholder="Masukkan Kata Sandi Baru Anda" required/>
        </div>

        <!-- Confirm Password Input -->
        <div class="w-[571px] h-[90px] absolute" id="ConfirmPasswordInput">
            <label for="confirmPasswordInput" class="absolute text-neutral-500 text-xl font-medium font-sans leading-normal">Konfirmasi Kata Sandi</label>
            <input id="confirmPasswordInput" name="confirm_password" type="password" class="absolute text-black text-opacity-80 text-lg font-semibold font-sans leading-tight outline-none border-b border-black w-[570px]" placeholder="Konfirmasi Masukkan Kata Sandi Baru Anda" />
            <span id="error-message" class="absolute text-red-500 text-sm font-medium hidden">Kata sandi yang anda masukkan harus sesuai</span>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submit-btn" class="w-[266px] h-[54px] absolute transition duration-300 ease-in-out transform hover:scale-105 bg-gradient-to-r from-sky-300 to-blue-500 rounded-md shadow">
            <span class="absolute text-white text-xl font-bold font-montserrat">Ubah Password</span>
            <span class="absolute w-6 h-6"></span>
        </button>
    </form>
</div>

<!-- Inline JavaScript -->
<script>
    document.getElementById('submit-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPasswordInput').value;
        const errorMessage = document.getElementById('error-message');

        const isValidPassword = (pwd) => {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(pwd);
            const hasLowerCase = /[a-z]/.test(pwd);
            const hasNumbers = /[0-9]/.test(pwd);
            const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(pwd);
            return pwd.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChars;
        };

        if (password !== confirmPassword) {
            errorMessage.textContent = "Kata sandi yang anda masukkan harus sesuai";
            errorMessage.classList.remove('hidden');
            document.getElementById('password').value = '';
            document.getElementById('confirmPasswordInput').value = '';
        } else if (!isValidPassword(password)) {
            errorMessage.textContent = "Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.";
            errorMessage.classList.remove('hidden');
            document.getElementById('password').value = '';
            document.getElementById('confirmPasswordInput').value = '';
        } else {
            errorMessage.classList.add('hidden');
            // Submit the form programmatically if validation passes
            document.querySelector('form').submit();
        }
    });
</script>

<!-- Inline Styles -->
<style>
    .full-screen-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: url('{{ asset('images/bg-loginPage.png') }}') center/cover no-repeat;
    }
</style>
</body>
</html>
