<!-- resources/views/password_reset.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    @vite('resources/css/app.css')
</head>

<body class="full-screen-bg flex items-center justify-center h-screen">
<div class="w-[1147px] h-[803px] relative">
    <div class="w-[1147px] h-[650px] left-0 top-0 absolute bg-white rounded-[15px] shadow-inner border border-blue-600"></div>
    <div class="w-[1038px] h-[0px] left-[55px] top-[112px] absolute border-4 border-blue-400"></div>
    <div class="w-[172px] h-[49px] left-[55px] top-[47px] absolute">
        <img class="left-0 top-0 absolute" src="{{ asset('images/nearus.png') }}" alt="Logo" />
        <div class="w-4 h-4 left-[118px] top-[1px] absolute"></div>
        <div class="w-2 h-[8.17px] left-[137px] top-[5.87px] absolute bg-sky-600 rounded-full"></div>
    </div>
    <div class="w-[707px] left-[55px] top-[160px] absolute text-black text-[28px] font-bold font-montserrat leading-[41.48px] tracking-wide">
        Silahkan Masukkan Kata Sandi Baru Anda
    </div>
    <form method="POST" action="{{ url('/reset-password') }}">
        @csrf
        <input type="hidden" name="token" value="">


        <div class="w-[571px] h-[90px] left-[55px] top-[250px] absolute" id="PasswordInput">
            <label for="passwordInput" class="left-0 top-0 absolute text-neutral-500 text-xl font-medium font-sans leading-normal">Kata Sandi</label>
            <input id="password" name="password" class="left-[1px] top-[60px] absolute text-black text-opacity-80 text-lg font-semibold font-sans leading-tight outline-none border-b border-black w-[570px]" placeholder="Masukkan Kata Sandi Baru Anda" required/>
        </div>

        <div class="w-[571px] h-[90px] left-[55px] top-[380px] absolute" id="ConfirmPasswordInput">
            <label for="confirmPasswordInput" class="left-0 top-0 absolute text-neutral-500 text-xl font-medium font-sans leading-normal">Konfirmasi Kata Sandi</label>
            <input id="confirmPasswordInput" name="confirm_password" type="password" class="left-[1px] top-[60px] absolute text-black text-opacity-80 text-lg font-semibold font-sans leading-tight outline-none border-b border-black w-[570px]" placeholder="Konfirmasi Masukkan Kata Sandi Baru Anda" />
            <span id="error-message" class="absolute left-[1px] top-[90px] text-red-500 text-sm font-medium hidden">Kata sandi yang anda masukkan harus sesuai</span>
        </div>

        <button type="submit" id="submit-btn" class="w-[266px] h-[54px] left-[55px] top-[520px] absolute transition duration-300 ease-in-out transform hover:scale-105 bg-gradient-to-r from-sky-300 to-blue-500 rounded-md shadow">
            <span class="absolute left-[50px] top-[15px] text-white text-xl font-bold font-montserrat">Ubah Password</span>
            <span class="absolute w-6 h-6 left-[220px] top-[15px]"></span>
        </button>
    </form>
</div>

<script>
    document.getElementById('submit-btn').addEventListener('click', function() {
        const password = document.getElementById('passwordInput').value;
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
            alert("Kata sandi yang Anda masukkan tidak sesuai. Silakan coba lagi.");
            errorMessage.textContent = "Kata sandi yang anda masukkan harus sesuai";
            errorMessage.classList.remove('hidden');
            document.getElementById('passwordInput').value = '';
            document.getElementById('confirmPasswordInput').value = '';
        } else if (!isValidPassword(password)) {
            alert("Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.");
            errorMessage.textContent = "Kata sandi tidak valid. Kata sandi harus memiliki panjang minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.";
            errorMessage.classList.remove('hidden');
            document.getElementById('passwordInput').value = '';
            document.getElementById('confirmPasswordInput').value = '';
        } else {
            errorMessage.classList.add('hidden');
            // Submit form or perform any other action
        }
    });
</script>
<style scoped>
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
