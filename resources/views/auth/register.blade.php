<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join ColoControll - Start Your Colocation Journey</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|inter:400,500,600" rel="stylesheet" />
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated background shapes */
        .shape {
            position: fixed;
            filter: blur(80px);
            opacity: 0.3;
            border-radius: 50%;
            z-index: 0;
            animation: float 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            background: #ff6b6b;
            top: -200px;
            right: -200px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 600px;
            height: 600px;
            background: #4ecdc4;
            bottom: -300px;
            left: -200px;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 400px;
            height: 400px;
            background: #ffe66d;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, 30px) scale(1.1); }
            50% { transform: translate(20px, -20px) scale(0.9); }
            75% { transform: translate(-30px, 10px) scale(1.05); }
        }

        /* Main container */
        .register-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Glass card effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 3rem;
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        /* Header with logo on left */
        .brand-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .brand-icon svg {
            width: 30px;
            height: 30px;
            color: white;
        }

        .brand-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-subtitle {
            text-align: center;
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .brand-subtitle span {
            color: #ff6b6b;
            font-weight: 600;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #444;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #ff6b6b;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 1.5rem;
            color: #333;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff6b6b;
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
        }

        .form-input:focus + .input-icon {
            color: #4ecdc4;
        }

        /* Password strength meter */
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #ff6b6b, #ffb347, #4ecdc4);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            color: #666;
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 2rem;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
        }

        /* Login link */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            color: #666;
        }

        .login-link a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
            position: relative;
        }

        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            transition: width 0.3s ease;
        }

        .login-link a:hover::after {
            width: 100%;
        }

        /* Error messages */
        .error-message {
            color: #ff6b6b;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Animated background shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="register-container">
        <div class="glass-card">
            <!-- Brand Header with Logo on left -->
            <div class="brand-header">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12h3l3-9 3 18 3-9h3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h1>ColoControll</h1>
            </div>
            
            <div class="brand-subtitle">
                Start your <span>colocation journey</span> today
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label class="form-label" for="name">Full name</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="12" cy="7" r="4" stroke-width="2"/>
                        </svg>
                        <input class="form-input" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                    </div>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="2" y="4" width="20" height="16" rx="2" stroke-width="2"/>
                            <path d="m22 7-10 7L2 7" stroke-width="2"/>
                        </svg>
                        <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-width="2"/>
                        </svg>
                        <input class="form-input" id="password" type="password" name="password" required placeholder="Create a strong password">
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText">Enter a password</div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-width="2"/>
                            <path d="M12 16v2" stroke-width="2"/>
                        </svg>
                        <input class="form-input" id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm your password">
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    Create account
                </button>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password strength meter
        const password = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        password.addEventListener('input', function() {
            const val = this.value;
            let strength = 0;
            
            if (val.length >= 8) strength += 25;
            if (val.match(/[a-z]+/)) strength += 25;
            if (val.match(/[A-Z]+/)) strength += 25;
            if (val.match(/[0-9]+/)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength <= 25) {
                strengthText.textContent = 'Weak password';
                strengthBar.style.background = '#ff6b6b';
            } else if (strength <= 50) {
                strengthText.textContent = 'Fair password';
                strengthBar.style.background = '#ffb347';
            } else if (strength <= 75) {
                strengthText.textContent = 'Good password';
                strengthBar.style.background = '#4ecdc4';
            } else {
                strengthText.textContent = 'Strong password';
                strengthBar.style.background = '#4ecdc4';
            }
        });
    </script>
</body>
</html>