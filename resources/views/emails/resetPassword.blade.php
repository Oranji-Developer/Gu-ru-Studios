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
    <title>Reset Password</title>
</head>

<body>
<section class="flex flex-col gap-7 p-[6.25rem]">
    <div class="flex flex-col gap-9 w-fit">
        <img src="{{ asset('images/logo.svg') }}" alt="logo" class="w-1/4">
        <h1 class="text-[2.5rem] font-semibold">Reset Your Password</h1>
    </div>
    <div class="flex flex-col gap-6">
        <p class="text-2xl font-semibold text-neutral-500">Hi <span class="text-primary">{{ $user }},</span>
        </p>
        <p class="text-2xl font-semibold text-neutral-500">You're receiving this email because we received a
            password
            reset request for your account.</p>
    </div>
    <div class="flex flex-col gap-6">
        <p class="text-neutral-500 font-semibold text-xl">Click the button below to reset your password:</p>
        <a href="{{ $resetPasswordUrl }}"
           class="p-3 rounded-lg text-white font-semibold text-2xl bg-primary w-fit cursor-pointer">Reset
            Password</a>
        <p class="text-neutral-500 text-[1.125rem] font-semibold">This password reset link will expire in 60
            minutes.
        </p>
    </div>
    <div class="flex flex-col gap-4">
        <p class="text-xl font-semibold text-neutral-950">💡 Having trouble with the button?</p>
        <p class="font-semibold text-neutral-500">If you're having trouble clicking the "Reset Password" button,
            copy
            and paste the URL below into your web browser:<br>
            <a href="{{ $resetPasswordUrl }}"
               class="text-primary cursor-pointer underline">{{ $resetPasswordUrl }}</a>
        </p>
        <p class="font-medium text-neutral-500">If you have any questions, feel free to contact us at <span
                class="text-primary">emailexample@gmail.com</span>.</p>
</section>
</body>

</html>
