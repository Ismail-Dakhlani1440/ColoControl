<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Category - ColoControll</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Space Grotesk', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .shape { position: fixed; filter: blur(80px); opacity: 0.2; border-radius: 50%; z-index: 0; animation: float 20s infinite ease-in-out; }
        .shape-1 { width: 500px; height: 500px; background: #ff6b6b; top: -200px; right: -200px; }
        .shape-2 { width: 600px; height: 600px; background: #4ecdc4; bottom: -300px; left: -200px; animation-delay: -5s; }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, 30px) scale(1.1); }
            50% { transform: translate(20px, -20px) scale(0.9); }
            75% { transform: translate(-30px, 10px) scale(1.05); }
        }
        .dashboard-container { position: relative; z-index: 10; display: flex; min-height: 100vh; }
        .side-nav { width: 280px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 2rem 1.5rem; box-shadow: 4px 0 20px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 3rem; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0; }
        .nav-brand-icon { width: 40px; height: 40px; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .nav-brand h2 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; flex-direction: column; gap: 0.5rem; }
        .nav-link { display: flex; align-items: center; gap: 1rem; padding: 0.875rem 1rem; border-radius: 1rem; color: #666; text-decoration: none; transition: all 0.3s ease; font-weight: 500; }
        .nav-link svg { width: 20px; height: 20px; }
        .nav-link:hover { background: linear-gradient(135deg, rgba(255,107,107,0.1), rgba(78,205,196,0.1)); color: #ff6b6b; transform: translateX(5px); }
        .nav-link.active { background: linear-gradient(135deg, #ff6b6b, #4ecdc4); color: white; box-shadow: 0 10px 20px rgba(255,107,107,0.2); }
        .nav-divider { height: 1px; background: #f0f0f0; margin: 1rem 0; }
        .user-info { padding: 1rem; background: #f8f9fa; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; }
        .user-avatar { width: 40px; height: 40px; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .user-details { flex: 1; }
        .user-name { font-weight: 600; color: #333; font-size: 0.95rem; }
        .user-email { color: #666; font-size: 0.8rem; }
        .logout-btn { color: #ff6b6b; }
        .main-content { flex: 1; margin-left: 280px; padding: 2rem; display: flex; align-items: flex-start; justify-content: center; }
        .form-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 2rem; padding: 2.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); width: 100%; max-width: 560px; margin-top: 2rem; }
        .form-title { font-size: 1.75rem; font-weight: 700; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem; }
        .form-subtitle { color: #666; font-size: 0.95rem; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #444; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .form-input { width: 100%; padding: 0.875rem 1.125rem; background: #f8f9fa; border: 2px solid #e5e7eb; border-radius: 1rem; font-family: 'Space Grotesk', sans-serif; font-size: 0.95rem; color: #333; transition: border-color 0.2s; outline: none; }
        .form-input:focus { border-color: #ff6b6b; background: white; }
        .color-row { display: flex; align-items: center; gap: 1rem; }
        .color-input { width: 56px; height: 48px; padding: 4px; border: 2px solid #e5e7eb; border-radius: 1rem; cursor: pointer; background: #f8f9fa; transition: border-color 0.2s; }
        .color-input:focus { border-color: #ff6b6b; outline: none; }
        .color-hex { flex: 1; }
        .color-preview { width: 32px; height: 32px; border-radius: 50%; border: 2px solid #e5e7eb; flex-shrink: 0; transition: background 0.2s; }
        .form-error { color: #dc2626; font-size: 0.8rem; margin-top: 0.375rem; }
        .form-actions { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn-primary { flex: 1; padding: 0.875rem; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); border: none; border-radius: 1.25rem; color: white; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s; font-family: 'Space Grotesk', sans-serif; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,107,107,0.3); }
        .btn-cancel { flex: 1; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 1.25rem; color: #666; font-weight: 600; font-size: 0.95rem; text-decoration: none; text-align: center; transition: all 0.2s; background: white; }
        .btn-cancel:hover { border-color: #ff6b6b; color: #ff6b6b; }
    </style>
</head>
<body>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="dashboard-container">
        <nav class="side-nav">
            <div class="nav-brand">
                <div class="nav-brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12h3l3-9 3 18 3-9h3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2>ColoControll</h2>
            </div>
            <div class="nav-links">
                <a href="{{ route('flatshares.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Flatshare
                </a>
                <a href="#" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                    Expenses
                </a>
                <a href="#" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                        <path d="M16.5 16.5L21 21"/><path d="M21 16.5L16.5 21"/>
                    </svg>
                    Who Owes Who
                </a>
                <a href="{{ route('categories.index') }}" class="nav-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Categories
                </a>
            </div>
            <div class="nav-divider"></div>
            <div class="user-info">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </nav>

        <main class="main-content">
            <div class="form-card">
                <h1 class="form-title">New Category</h1>
                <p class="form-subtitle">{{ $flatShare->name }}</p>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title"
                               class="form-input"
                               value="{{ old('title') }}"
                               placeholder="e.g. Groceries, Utilities, Rent..."
                               autofocus>
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <div class="color-row">
                            <input type="color" id="colorPicker" value="{{ old('color', '#ff6b6b') }}"
                                   class="color-input"
                                   oninput="syncColor(this.value)">
                            <input type="text" id="colorHex" name="color"
                                   class="form-input color-hex"
                                   value="{{ old('color', '#ff6b6b') }}"
                                   placeholder="#ff6b6b"
                                   oninput="syncHex(this.value)">
                            <div id="colorPreview" class="color-preview" style="background: {{ old('color', '#ff6b6b') }}"></div>
                        </div>
                        @error('color')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('categories.index') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function syncColor(val) {
            document.getElementById('colorHex').value = val;
            document.getElementById('colorPreview').style.background = val;
        }
        function syncHex(val) {
            if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                document.getElementById('colorPicker').value = val;
                document.getElementById('colorPreview').style.background = val;
            }
        }
    </script>
</body>
</html>