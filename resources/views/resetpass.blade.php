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
        </div>

        <button type="submit" id="submit-btn" class="w-full bg-gradient-to-r from-sky-300 to-blue-500 text-white text-xl font-bold py-3 px-6 rounded-md shadow transition-transform transform hover:scale-105">
            Ubah Password
        </button>
    </form>
</div>

<!-- Modal for Error Messages -->
<div id="error-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 id="modal-title" class="text-xl font-bold mb-4">Error</h2>
        <p id="modal-message" class="text-lg mb-4">Error message goes here.</p>
        <button id="modal-close-btn" class="bg-blue-500 text-white py-2 px-4 rounded-md">Close</button>
    </div>
</div>

<script>
    const errorModal = document.getElementById('error-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalCloseBtn = document.getElementById('modal-close-btn');

    document.getElementById('submit-btn').addEventListener('click', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

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
            modalTitle.textContent = "Password Mismatch";
            modalMessage.textContent = "Kata sandi yang Anda masukkan tidak sesuai. Silakan coba lagi.";
            errorModal.classList.remove('hidden');
            document.getElementById('password').value = '';
            document.getElementById('confirm_password').value = '';
        } else if (!isValidPassword(password)) {
            event.preventDefault(); // Prevent form submission
            modalTitle.textContent = "Invalid Password";
            modalMessage.textContent = "Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.";
            errorModal.classList.remove('hidden');
            document.getElementById('password').value = '';
            document.getElementById('confirm_password').value = '';
        }
    });

    modalCloseBtn.addEventListener('click', function() {
        errorModal.classList.add('hidden');
    });
</script>
</body>
</html>
