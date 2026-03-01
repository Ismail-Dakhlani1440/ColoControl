<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Flatshare - ColoControll</title>
    
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
            position: relative;
        }

        /* Animated background shapes */
        .shape {
            position: fixed;
            filter: blur(80px);
            opacity: 0.2;
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

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, 30px) scale(1.1); }
            50% { transform: translate(20px, -20px) scale(0.9); }
            75% { transform: translate(-30px, 10px) scale(1.05); }
        }

        /* Main container */
        .create-container {
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
            max-width: 550px;
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

        /* Header */
        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .header-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: morph 8s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
        }

        @keyframes morph {
            0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            25% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
            50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
            75% { border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%; }
        }

        .header-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .form-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-header p {
            color: #666;
            font-size: 1rem;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 2rem;
            position: relative;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            color: #444;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .label-icon {
            color: #ff6b6b;
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

        /* Number input specific styling */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            opacity: 1;
            height: 24px;
            position: absolute;
            right: 10px;
        }

        /* Helper text */
        .helper-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            color: #888;
            font-size: 0.85rem;
        }

        .helper-text svg {
            width: 16px;
            height: 16px;
        }

        /* Max flatmate slider */
        .slider-container {
            margin-top: 1rem;
        }

        .slider-value {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .slider-value span:first-child {
            color: #666;
            font-size: 0.9rem;
        }

        .slider-value span:last-child {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .slider {
            width: 100%;
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            outline: none;
            -webkit-appearance: none;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
        }

        .slider::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }

        .slider::-moz-range-thumb {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
            border: none;
        }

        .slider::-moz-range-thumb:hover {
            transform: scale(1.15);
        }

        /* Quick select chips */
        .quick-select {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .quick-chip {
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 2rem;
            color: #666;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quick-chip:hover {
            border-color: #ff6b6b;
            color: #ff6b6b;
        }

        /* Buttons */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-primary {
            flex: 2;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            flex: 1;
            padding: 1rem;
            background: white;
            border: 2px solid #ff6b6b;
            border-radius: 2rem;
            color: #ff6b6b;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.2);
        }

        /* Preview card */
        .preview-card {
            margin-top: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05), rgba(78, 205, 196, 0.05));
            border-radius: 1.5rem;
            border: 2px dashed #ff6b6b;
        }

        .preview-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .preview-content {
            display: flex;
            align-items: center;
            justify-content: space-around;
            text-align: center;
        }

        .preview-item {
            flex: 1;
        }

        .preview-label {
            color: #888;
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .preview-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }

        .preview-value span {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .preview-divider {
            width: 1px;
            height: 30px;
            background: #e9ecef;
        }

        /* Error message */
        .error-message {
            color: #ff6b6b;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Animated background shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="create-container">
        <div class="glass-card">
            <!-- Header -->
            <div class="form-header">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <h1>Create Your Flatshare</h1>
                <p>Set up your colocation and invite your roommates</p>
            </div>

            <!-- Create Form -->
            <form method="POST" action="{{ route('flatshares.store') }}">
                @csrf

                <!-- Flatshare Name -->
                <div class="form-group">
                    <label class="form-label" for="name">
                        <svg class="label-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Flatshare Name
                    </label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <input class="form-input" id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., Sunny Apartments, Beach House" autofocus>
                    </div>
                    <div class="helper-text">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="12" x2="12" y2="16"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <span>Choose a name that your roommates will recognize</span>
                    </div>
                    @error('name')
                        <div class="error-message">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Max Flatmates -->
                <div class="form-group">
                    <label class="form-label" for="max_flatmate">
                        <svg class="label-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        Maximum Roommates
                    </label>
                    
                    <!-- Slider for visual selection -->
                    <div class="slider-container">
                        <div class="slider-value">
                            <span>Number of people (including you)</span>
                            <span id="maxValueDisplay">4</span>
                        </div>
                        <input type="range" id="maxSlider" class="slider" min="2" max="10" value="{{ old('max_flatmate', 4) }}" step="1">
                    </div>

                    <!-- Actual input (hidden, updated by JS) -->
                    <input type="number" id="max_flatmate" name="max_flatmate" value="{{ old('max_flatmate', 4) }}" min="2" max="10" required hidden>

                    <!-- Quick select chips -->
                    <div class="quick-select">
                        <span class="quick-chip" onclick="setMaxValue(2)">2 people</span>
                        <span class="quick-chip" onclick="setMaxValue(3)">3 people</span>
                        <span class="quick-chip" onclick="setMaxValue(4)">4 people</span>
                        <span class="quick-chip" onclick="setMaxValue(5)">5 people</span>
                        <span class="quick-chip" onclick="setMaxValue(6)">6 people</span>
                    </div>

                    <div class="helper-text">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="12" x2="12" y2="16"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <span>Maximum number of roommates allowed in this flatshare</span>
                    </div>
                    @error('max_flatmate')
                        <div class="error-message">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Preview Card -->
                <div class="preview-card">
                    <div class="preview-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <span>Preview your flatshare</span>
                    </div>
                    <div class="preview-content">
                        <div class="preview-item">
                            <div class="preview-label">Flatshare Name</div>
                            <div class="preview-value" id="previewName">—</div>
                        </div>
                        <div class="preview-divider"></div>
                        <div class="preview-item">
                            <div class="preview-label">Max Roommates</div>
                            <div class="preview-value" id="previewMax">4</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="btn-secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Create Flatshare
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Elements
        const nameInput = document.getElementById('name');
        const maxSlider = document.getElementById('maxSlider');
        const maxInput = document.getElementById('max_flatmate');
        const maxDisplay = document.getElementById('maxValueDisplay');
        const previewName = document.getElementById('previewName');
        const previewMax = document.getElementById('previewMax');

        // Update max value from slider
        function updateMaxValue() {
            const val = maxSlider.value;
            maxInput.value = val;
            maxDisplay.textContent = val;
            previewMax.innerHTML = `<span>${val}</span>`;
        }

        // Set max value from quick chips
        window.setMaxValue = function(val) {
            maxSlider.value = val;
            updateMaxValue();
        };

        // Update preview name
        nameInput.addEventListener('input', function() {
            if (this.value.trim()) {
                previewName.innerHTML = `<span>${this.value}</span>`;
            } else {
                previewName.textContent = '—';
            }
        });

        // Slider event
        maxSlider.addEventListener('input', updateMaxValue);

        // Initialize
        updateMaxValue();
    </script>
</body>
</html>