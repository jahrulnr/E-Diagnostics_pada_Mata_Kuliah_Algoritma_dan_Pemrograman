<!DOCTYPE html>
<html>
<head>
    <title>Reset Password | {{ config('app.name') }}</title>
    <style>
        div {
            margin: 0.1rem !important;
            padding: 0.1rem 0.1rem;
        }

        a {
            display: block !important;
            text-align: center !important;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            color: #fff !important;
            background-color: #0d6efd;
            border-color: #0d6efd !important;
            width: auto;
        }

    </style>
</head>
<body>
    <div>
        <h1>{{ $msg['title'] }}</h1>
        <p>
            Halo {{ $msg['name'] }}!<br/>            
            Kamu sedang melakukan reset Password.<br/>
            Silakan klik tombol di bawah untuk melanjutkan.
        </p>
        <hr/>
        <a href="{{ $msg['body'] }}">Reset Sandi</a>
    </div>
</body>
</html>