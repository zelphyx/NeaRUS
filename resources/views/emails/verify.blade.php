<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
<p>Dear {{ $user->name }},</p>

<a href="{{ route('verify.email', $token) }}">Verify Email</a>
<div class="full-screen-bg flex items-center justify-center h-screen">
    <div class="w-[1147px] h-[803px] relative">
        <div class="w-[1147px] h-[803px] absolute left-0 top-0 bg-white rounded-[15px] shadow shadow-inner border border-blue-600"></div>
        <div class="w-[1038px] h-[0px] absolute left-[55px] top-[112px] border-4 border-blue-400"></div>
        <div class="w-[172px] h-[49px] absolute left-[55px] top-[47px]">
            <img class="absolute left-0 top-0" src="{{ asset('assets/images/nearus.png') }}" />
            <div class="w-4 h-4 absolute left-[118px] top-[1px]"></div>
            <div class="w-2 h-[8.17px] absolute left-[137px] top-[5.87px] bg-sky-600 rounded-full"></div>
        </div>
        <div class="w-[849px] h-[536px] absolute left-[149px] top-[162px]">
            <div class="w-60 h-60 absolute left-[305px] top-0">
                <div class="w-[200px] h-[190px] absolute left-[20px] top-[25px]"></div>
                <div class="w-[200px] h-[190px] absolute left-[20px] top-[60px]">
                    <img class="absolute left-0 top-[-50px]" src="{{ asset('assets/images/icon-mail.png') }}" />
                    <div class="w-[200px] h-[2px] absolute left-0 bottom-[0px] bg-gray-400"></div>
                </div>
            </div>
            <div class="absolute left-0 top-[380px] text-center text-black text-xl font-medium font-montserrat leading-snug">
                Silahkan pencet tombol dibawah untuk melakukan verifikasi akun anda.
            </div>
            <div class="absolute left-0 top-[520px] text-center text-black text-[15px] font-extralight font-montserrat leading-none">
                Anda bisa menutup email ini setelah anda selesai melakukan verfikasi email
            </div>
            <button class="w-[266px] h-[54px] absolute left-[292px] top-[443px] transition duration-300 ease-in-out transform hover:scale-105 bg-gradient-to-r from-sky-300 to-blue-500 rounded-md shadow">
                <span class="absolute left-[70px] top-[15px] text-white text-xl font-bold font-montserrat">Verify Email</span>
                <span class="absolute w-6 h-6 left-[220px] top-[15px]"></span>
            </button>
            <div class="absolute left-[250px] top-[308px] text-black text-[32px] font-semibold font-['Montserrat'] leading-[34.56px]">
                Verifikasi Email Anda
            </div>
        </div>
    </div>
</div>

</body>
</html>
