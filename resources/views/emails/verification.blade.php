<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        echo \Illuminate\Support\Env::get('APP_TESTING')
            ? "@vite('resources/css/app.css')"
            : '<link rel="stylesheet" href="'.asset_vite('resources/css/app.css').'">';
    @endphp
    <title>Verification</title>
</head>
<body>
<section class="flex flex-col gap-7 p-[6.25rem]">
    <div class="flex flex-col gap-9 w-fit">
        <img src="{{asset('images/logo.svg')}}" alt="logo" class="w-1/4">
        <h1 class="text-[2.5rem] font-semibold">Verify Your Email to<br> Get Started!</h1>
    </div>
    <div class="flex flex-col gap-6">
        <p class="text-2xl font-semibold text-neutral-500">Hi <span class="text-primary">{{$user}},</span></p>
        <p class="text-2xl font-semibold text-neutral-500">Welcome to <span class="text-primary">GuruStudios!</span> 🎉
        </p>
    </div>
    <div class="flex flex-col gap-6">
        <p class="text-neutral-500 font-semibold text-xl">Anda hampir sampai. Untuk menyelesaikan pendaftaran Anda,
            silakan verifikasi alamat email Anda dengan
            mengeklik tombol di bawah ini:</p>
        <a href="{{$verificationUrl}}"
           class="p-3 rounded-lg text-white font-semibold text-2xl bg-primary w-fit cursor-pointer">Verifikasi
            Email</a>
        <p class="text-neutral-500 text-[1.125rem] font-semibold">Tautan ini akan kedaluwarsa dalam 1 jam, jadi jangan
            menunggu terlalu lama!</p>
    </div>
    <div class="flex flex-col gap-4">
        <p class="text-xl font-semibold text-neutral-950">💡 Kesulitan melakukan verifikasi?</p>
        <p class="font-semibold text-neutral-500">Jika tombol tidak berfungsi, Anda dapat menyalin dan menempelkan
            tautan di bawah ini ke dalam peramban Anda:<br>
            <a href="{{$verificationUrl}}" class="text-primary cursor-pointer underline">{{$verificationUrl}}</a></p>
        <p class="font-medium text-neutral-500">Jika Anda memiliki masalah, jangan ragu untuk menghubungi kami di <span
                class="text-primary">emailexample@gmail.com</span>.</p>
    </div>
</section>
</body>
</html>
