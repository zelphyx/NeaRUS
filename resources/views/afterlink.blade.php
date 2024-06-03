<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style scoped>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

        .full-screen-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: url('{{ asset('images/bg-image.png') }}') center/cover no-repeat;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body>
<div class="full-screen-bg flex items-center justify-center h-screen">
    <div class="w-[1147px] h-[803px] relative">
        <div class="w-[1147px] h-[803px] absolute left-0 top-0 bg-white rounded-[15px] shadow-inner border border-blue-600"></div>
        <div class="w-[1038px] h-[0px] absolute left-[55px] top-[112px] border-4 border-blue-400"></div>
        <div class="w-[172px] h-[49px] absolute left-[55px] top-[47px]">
            <img class="absolute left-0 top-0" src="{{ asset('images/nearus.png') }}" />
            <div class="w-2 h-[8.17px] absolute left-[137px] top-[5.87px] bg-sky-600 rounded-full"></div>
        </div>
        <div class="w-[849px] h-[536px] absolute left-[149px] top-[162px] flex flex-col items-center">
            <div class="w-60 h-60 relative flex items-center justify-center">
                <img class="absolute top-0" src="{{ asset('images/icon-mail.png') }}" />
            </div>
            <div class="w-[200px] h-[2px] mt-8 bg-gray-400"></div>
            <div class="mt-8 text-center text-black text-2xl font-semibold">
                Verifikasi Email Berhasil
            </div>
            <div class="w-[200px] h-[2px] mt-8 bg-gray-400"></div>
            <div class="mt-8 text-center text-black text-xl font-medium">
                Email Anda sudah diverifikasi.
            </div>
            <div class="w-[200px] h-[2px] mt-8 bg-gray-400"></div>
            <div class="mt-8 text-center text-black text-base font-extralight">
                Terima kasih telah melakukan verifikasi email.
            </div>
            <a href="http://localhost:5173/login" class="mt-8">
                <button class="w-[266px] h-[54px] transition duration-300 ease-in-out transform hover:scale-105 bg-gradient-to-r from-sky-300 to-blue-500 rounded-md shadow">
                    <span class="text-white text-xl font-bold">Go Back to Login Page</span>
                </button>
            </a>
            <a href="https://samehadaku.email" class="mt-4 text-blue-500 text-base font-extralight hover:underline">
                Klik di sini untuk mengunjungi website lain
            </a>
        </div>
    </div>
</div>
</body>
</html>
