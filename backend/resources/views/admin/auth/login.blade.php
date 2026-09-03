<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ao webtech</title>
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #161616;
            padding: 20px;
            color: #00e5ff;
        }
        .login-card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 50px;
            width: 100%;
            max-width: 420px;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-card .logo img {
            max-width: 150px;
        }
        .login-card h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 500;
            color: #00e5ff;
        }
        .login-card p {
            text-align: center;
            color: #00e5ff;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #00e5ff;
        }
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: #222;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: #00e5ff;
            font-size: 15px;
            font-family: inherit;
        }
        .form-group input::placeholder {
            color: #00e5ff;
            opacity: 0.6;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff8743;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #ff8743;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: #e6763a;
        }
        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
        .alert-error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="logo">
                <img src="{{ asset('https://res.cloudinary.com/dqi7g7lky/image/upload/v1788465385/swlfie_oc610k.png') }}" alt="Ao webtech">
            </div>
            <h2>Welcome Back</h2>
            <p>Sign in to your admin account</p>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-login">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
