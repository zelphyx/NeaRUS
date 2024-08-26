<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Background image style */
        .bg-reset-password {
            background: url('{{ asset('images/bg-loginPage.png') }}') center/cover no-repeat;
        }

        /* Loading animation */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

    <form id="reset-password-form" method="POST" action="{{ url('/api/reset') }}">
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

<!-- Loading overlay -->
<div id="loading-overlay" class="loading-overlay">
    <div class="loading-spinner"></div>
</div>

<!-- Modal for Error Messages -->
<div id="error-modal" class="fixed inset-0 flex items-center justify-center modal-overlay modal-overlay-hide">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full modal modal-hide">
        <h2 id="modal-title" class="text-xl font-bold mb-4">Error</h2>
        <p id="modal-message" class="text-lg mb-4">Error message goes here.</p>
        <button id="modal-close-btn" class="bg-blue-500 text-white py-2 px-4 rounded-md">Close</button>
    </div>
</div>

<script>
    document.getElementById('reset-password-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        const form = event.target;

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
            showModal("Password Mismatch", "Kata sandi yang Anda masukkan tidak sesuai. Silakan coba lagi.");
            return;
        } else if (!isValidPassword(password)) {
            showModal("Invalid Password", "Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.");
            return;
        }

        // Show loading spinner
        document.getElementById('loading-overlay').style.display = 'flex';

        // Simulate form submission and redirection
        setTimeout(() => {
            form.submit(); // Submit the form

            // Redirect to the completion page after a short delay
            setTimeout(() => {
                window.location.href = "{{ url('/complete') }}";
            }, 1000); // Adjust the delay as needed

        }, 1000); // Simulate network delay
    });

    const errorModal = document.getElementById('error-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const modalContent = errorModal.querySelector('div');

    function showModal(title, message) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        errorModal.classList.remove('modal-overlay-hide');
        errorModal.classList.add('modal-overlay-show');
        modalContent.classList.remove('modal-hide');
        modalContent.classList.add('modal-show');
    }

    function hideModal() {
        modalContent.classList.remove('modal-show');
        modalContent.classList.add('modal-hide');
        errorModal.classList.remove('modal-overlay-show');
        errorModal.classList.add('modal-overlay-hide');
    }

    modalCloseBtn.addEventListener('click', function() {
        hideModal();
    });

    // Close modal on overlay click
    errorModal.addEventListener('click', function(event) {
        if (event.target === errorModal) {
            hideModal();
        }
    });
</script>
</body>
</html>
