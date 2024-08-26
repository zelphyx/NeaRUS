<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style scoped>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .wrapper {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-sizing: border-box;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            margin-bottom: 20px;
        }
        .header img {
            width: 150px;
            height: auto;
        }
        .content {
            margin-bottom: 20px;
        }
        .content i {
            font-size: 80px;
            color: #38BDF8;
            margin: 0 auto 20px;
        }
        .content h1 {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .content p {
            color: #4a5568;
            font-size: 16px;
            font-weight: 400;
            margin-bottom: 20px;
        }
        .content button {
            transition: transform 0.3s ease-in-out;
            background: linear-gradient(to right, #38BDF8, #1E3A8A);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 30px;
            cursor: pointer;
        }
        .content button:hover {
            transform: scale(1.05);
        }
        .footer {
            text-align: center;
        }
        .bottom-text {
            margin-top: 20px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 300;
        }

        @media (max-width: 768px) {
            .wrapper {
                padding: 15px;
            }
            .content i {
                font-size: 60px;
            }
            .content button {
                padding: 10px 20px;
                font-size: 16px;
            }
            .header img {
                width: 120px;
            }
        }

        @media (max-width: 480px) {
            .content p {
                font-size: 14px;
            }
            .content button {
                padding: 8px 16px;
                font-size: 14px;
            }
            .header img {
                width: 100px;
            }
        }
    </style>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <div class="header">
        <img src="{{ asset('images/nearus.png') }}" alt="Logo Nearus" />
    </div>
    <div class="content">
        <i class="fas fa-check-circle"></i>
        <h1>Password Berhasil Diubah</h1>
        <p>
            Password Anda telah berhasil diubah. Silakan klik tombol di bawah untuk kembali ke halaman login dan masuk dengan password baru Anda.
        </p>
        <a href="https://nearus.id/login">
            <button>
                Kembali ke Login
            </button>
        </a>
        <p class="bottom-text">
            Jika Anda tidak melakukan perubahan password, harap segera hubungi dukungan kami.
        </p>
    </div>
</div>
</body>
</html>
