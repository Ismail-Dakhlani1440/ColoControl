<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense - ColoControll</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Space Grotesk',sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh}
        .shape{position:fixed;filter:blur(80px);opacity:.2;border-radius:50%;z-index:0;animation:float 20s infinite ease-in-out}
        .shape-1{width:500px;height:500px;background:#ff6b6b;top:-200px;right:-200px}
        .shape-2{width:600px;height:600px;background:#4ecdc4;bottom:-300px;left:-200px;animation-delay:-5s}
        @keyframes float{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(50px,30px) scale(1.1)}50%{transform:translate(20px,-20px) scale(.9)}75%{transform:translate(-30px,10px) scale(1.05)}}
        .dashboard-container{position:relative;z-index:10;display:flex;min-height:100vh}
        .side-nav{width:280px;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);padding:2rem 1.5rem;box-shadow:4px 0 20px rgba(0,0,0,.1);position:fixed;height:100vh;overflow-y:auto}
        .nav-brand{display:flex;align-items:center;gap:.75rem;margin-bottom:3rem;padding-bottom:1rem;border-bottom:2px solid #f0f0f0}
        .nav-brand-icon{width:40px;height:40px;background:linear-gradient(135deg,#ff6b6b,#4ecdc4);border-radius:12px;display:flex;align-items:center;justify-content:center}
        .nav-brand h2{font-size:1.5rem;font-weight:700;background:linear-gradient(135deg,#ff6b6b,#4ecdc4);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .nav-links{display:flex;flex-direction:column;gap:.5rem}
        .nav-link{display:flex;align-items:center;gap:1rem;padding:.875rem 1rem;border-radius:1rem;color:#666;text-decoration:none;transition:all .3s ease;font-weight:500}
        .nav-link svg{width:20px;height:20px}
        .nav-link:hover{background:linear-gradient(135deg,rgba(255,107,107,.1),rgba(78,205,196,.1));color:#ff6b6b;transform:translateX(5px)}
        .nav-link.active{background:linear-gradient(135deg,#ff6b6b,#4ecdc4);color:white;box-shadow:0 10px 20px rgba(255,107,107,.2)}
        .nav-divider{height:1px;background:#f0f0f0;margin:1rem 0}
        .user-info{padding:1rem;background:#f8f9fa;border-radius:1rem;display:flex;align-items:center;gap:.75rem}
        .user-avatar{width:40px;height:40px;background:linear-gradient(135deg,#ff6b6b,#4ecdc4);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600}
        .user-details{flex:1}
        .user-name{font-weight:600;color:#333;font-size:.95rem}
        .user-email{color:#666;font-size:.8rem}
        .logout-btn{color:#ff6b6b}
        .main-content{flex:1;margin-left:280px;padding:2rem;display:flex;justify-content:center;align-items:flex-start}
        .form-card{background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-radius:2rem;padding:2.5rem;box-shadow:0 20px 40px rgba(0,0,0,.1);width:100%;max-width:620px;margin-top:2rem}
        .form-title{font-size:1.75rem;font-weight:700;background:linear-gradient(135deg,#ff6b6b,#4ecdc4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:.4rem}
        .form-subtitle{color:#666;font-size:.95rem;margin-bottom:2rem}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
        .form-group{margin-bottom:1.25rem}
        .form-group.full{grid-column:1/-1}
        .form-label{display:block;font-size:.78rem;font-weight:600;color:#444;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.4rem}
        .form-input,.form-select,.form-textarea{width:100%;padding:.875rem 1.125rem;background:#f8f9fa;border:2px solid #e5e7eb;border-radius:1rem;font-family:'Space Grotesk',sans-serif;font-size:.95rem;color:#333;transition:border-color .2s;outline:none;appearance:none}
        .form-input:focus,.form-select:focus,.form-textarea:focus{border-color:#ff6b6b;background:white}
        .form-textarea{resize:vertical;min-height:80px}
        .form-error{color:#dc2626;font-size:.78rem;margin-top:.3rem}
        .form-actions{display:flex;gap:1rem;margin-top:2rem}
        .btn-primary{flex:1;padding:.875rem;background:linear-gradient(135deg,#ff6b6b,#4ecdc4);border:none;border-radius:1.25rem;color:white;font-weight:600;font-size:.95rem;cursor:pointer;transition:all .3s;font-family:'Space Grotesk',sans-serif}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(255,107,107,.3)}
        .btn-cancel{flex:1;padding:.875rem;border:2px solid #e5e7eb;border-radius:1.25rem;color:#666;font-weight:600;font-size:.95rem;text-decoration:none;text-align:center;transition:all .2s;background:white}
        .btn-cancel:hover{border-color:#ff6b6b;color:#ff6b6b}
        .section-divider{font-size:.78rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.1em;margin:1.5rem 0 1rem;padding-bottom:.5rem;border-bottom:1px solid #f0f0f0;grid-column:1/-1}
    </style>
</head>
<body>
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="dashboard-container">
    <nav class="side-nav">
        <div class="nav-brand">
            <div class="nav-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h3l3-9 3 18 3-9h3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h2>ColoControll</h2>
        </div>
        <div class="nav-links">
            <a href="{{ route('flatshares.index') }}" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Flatshare
            </a>
            <a href="{{ route('expenses.index') }}" class="nav-link active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 6v2M12 16v2"/></svg>
                Expenses
            </a>
            <a href="#" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="M16.5 16.5L21 21"/><path d="M21 16.5L16.5 21"/></svg>
                Who Owes Who
            </a>
            @if(auth()->id() === $flatShare->owner_id)
                <a href="{{ route('categories.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Categories
                </a>
            @endif
        </div>
        <div class="nav-divider"></div>
        <div class="user-info">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-email">{{ auth()->user()->email }}</div>
            </div>
            <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </nav>

    <main class="main-content">
        <div class="form-card">
            <h1 class="form-title">Add Expense</h1>
            <p class="form-subtitle">{{ $flatShare->name }}</p>

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="form-grid">

                    <div class="section-divider">Details</div>

                    <div class="form-group full">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-input"
                               value="{{ old('title') }}" placeholder="e.g. Groceries, Electric bill..." autofocus>
                        @error('title')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="description">Description <span style="color:#aaa;font-weight:400">(optional)</span></label>
                        <textarea id="description" name="description" class="form-textarea"
                                  placeholder="Any extra details...">{{ old('description') }}</textarea>
                        @error('description')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ammount">Amount ($)</label>
                        <input type="number" id="ammount" name="ammount" class="form-input"
                               value="{{ old('ammount') }}" step="0.01" min="0.01" placeholder="0.00">
                        @error('ammount')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-input"
                               value="{{ old('date', now()->format('Y-m-d')) }}">
                        @error('date')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="section-divider">Who & What</div>

                    <div class="form-group">
                        <label class="form-label" for="payer_id">Paid by</label>
                        <select id="payer_id" name="payer_id" class="form-select">
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('payer_id', auth()->id()) == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}{{ $member->id === auth()->id() ? ' (you)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('payer_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category_id">Category <span style="color:#aaa;font-weight:400">(optional)</span></label>
                        <select id="category_id" name="category_id" class="form-select">
                            <option value="">— None —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $categories->first()?->id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('expenses.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-primary">Save Expense</button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>