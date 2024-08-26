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

    <style>
        /* External or global CSS for background */
        .bg-reset-password {
            background: url('{{ asset('images/bg-loginPage.png') }}') center/cover no-repeat;
        }
    </style>
</head>

<body class="bg-reset-password flex items-center justify-center min-h-screen">
<div class="w-full max-w-4xl bg-white rounded-lg shadow-lg border border-blue-600 p-8 relative">
    <div class="absolute top-4 left-6">
        <img src="{{ asset('images/nearus.png') }}" alt="Logo" class="w-40" />
    </div>
    <div class="border-t-4 border-blue-400 mt-8 mb-8"></div>
    <h1 class="text-2xl font-bold text-black mb-6">Silahkan Masukkan Kata Sandi Baru Anda</h1>

    <form method="POST" action="{{ url('/api/reset') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-6">
            <label for="password" class="block text-neutral-500 text-xl font-medium mb-2">Kata Sandi</label>
            <input id="password" name="password" type="password" class="w-full text-black text-opacity-80 text-lg font-semibold border-b border-black outline-none py-2 px-3" placeholder="Masukkan Kata Sandi Baru Anda" required />
        </div>

        <div class="mb-6 relative">
            <label for="confirm_password" class="block text-neutral-500 text-xl font-medium mb-2">Konfirmasi Kata Sandi</label>
            <input id="confirm_password" name="confirm_password" type="password" class="w-full text-black text-opacity-80 text-lg font-semibold border-b border-black outline-none py-2 px-3" placeholder="Konfirmasi Masukkan Kata Sandi Baru Anda" />
            <span id="error-message" class="absolute text-red-500 text-sm font-medium hidden">Kata sandi yang anda masukkan harus sesuai</span>
        </div>

        <button type="submit" id="submit-btn" class="w-full bg-gradient-to-r from-sky-300 to-blue-500 text-white text-xl font-bold py-3 px-6 rounded-md shadow transition-transform transform hover:scale-105">
            Ubah Password
        </button>
    </form>
</div>

<script>
    document.getElementById('submit-btn').addEventListener('click', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
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
            event.preventDefault(); // Prevent form submission
            alert("Kata sandi yang Anda masukkan tidak sesuai. Silakan coba lagi.");
            errorMessage.textContent = "Kata sandi yang anda masukkan harus sesuai";
            errorMessage.classList.remove('hidden');
            document.getElementById('password').value = '';
            document.getElementById('confirm_password').value = '';
        } else if (!isValidPassword(password)) {
            event.preventDefault(); // Prevent form submission
            alert("Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.");
            errorMessage.textContent = "Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.";
            errorMessage.classList.remove('hidden');
            document.getElementById('password').value = '';
            document.getElementById('confirm_password').value = '';
        } else {
            errorMessage.classList.add('hidden');
            // Form will be submitted if valid
        }
    });
</script>
</body>
</html>
