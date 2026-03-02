<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - ColoControll</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|inter:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Space Grotesk', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; position: relative; }
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
        .nav-brand-icon svg { width: 24px; height: 24px; color: white; }
        .nav-brand h2 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; flex-direction: column; gap: 0.5rem; }
        .nav-link { display: flex; align-items: center; gap: 1rem; padding: 0.875rem 1rem; border-radius: 1rem; color: #666; text-decoration: none; transition: all 0.3s ease; font-weight: 500; }
        .nav-link svg { width: 20px; height: 20px; transition: all 0.3s ease; }
        .nav-link:hover { background: linear-gradient(135deg, rgba(255,107,107,0.1), rgba(78,205,196,0.1)); color: #ff6b6b; transform: translateX(5px); }
        .nav-link.active { background: linear-gradient(135deg, #ff6b6b, #4ecdc4); color: white; box-shadow: 0 10px 20px rgba(255,107,107,0.2); }
        .nav-link.active svg { color: white; }
        .nav-divider { height: 1px; background: #f0f0f0; margin: 1rem 0; }
        .user-info { margin-top: auto; padding: 1rem; background: #f8f9fa; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; }
        .user-avatar { width: 40px; height: 40px; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.1rem; }
        .user-details { flex: 1; }
        .user-name { font-weight: 600; color: #333; font-size: 0.95rem; }
        .user-email { color: #666; font-size: 0.8rem; }
        .logout-btn { color: #ff6b6b; transition: color 0.3s ease; }
        .main-content { flex: 1; margin-left: 280px; padding: 2rem; }
        .content-wrapper { max-width: 1200px; margin: 0 auto; }
        .page-header { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 2rem; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .page-title { font-size: 2rem; font-weight: 700; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .page-subtitle { color: #666; font-size: 1rem; margin-top: 0.25rem; }
        .btn-primary { padding: 0.875rem 1.75rem; background: linear-gradient(135deg, #ff6b6b, #4ecdc4); border: none; border-radius: 2rem; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; text-decoration: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,107,107,0.3); }
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .category-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 1.5rem; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; border-left: 5px solid transparent; }
        .category-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .category-header { display: flex; align-items: center; gap: 0.875rem; margin-bottom: 1rem; }
        .color-dot { width: 16px; height: 16px; border-radius: 50%; flex-shrink: 0; }
        .category-title { font-size: 1.1rem; font-weight: 700; color: #333; flex: 1; }
        .category-meta { color: #888; font-size: 0.85rem; margin-bottom: 1.25rem; }
        .category-actions { display: flex; gap: 0.75rem; }
        .btn-edit { flex: 1; padding: 0.625rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.875rem; color: #555; font-weight: 600; font-size: 0.85rem; text-decoration: none; text-align: center; transition: all 0.2s ease; }
        .btn-edit:hover { border-color: #ff6b6b; color: #ff6b6b; background: rgba(255,107,107,0.05); }
        .btn-delete { flex: 1; padding: 0.625rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.875rem; color: #555; font-weight: 600; font-size: 0.85rem; background: none; cursor: pointer; transition: all 0.2s ease; }
        .btn-delete:hover:not(:disabled) { border-color: #ff6b6b; color: #ff6b6b; background: rgba(255,107,107,0.05); }
        .btn-delete:disabled { opacity: 0.4; cursor: not-allowed; }
        .empty-state { background: rgba(255,255,255,0.95); border-radius: 2rem; padding: 4rem 2rem; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .empty-state h3 { font-size: 1.5rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .empty-state p { color: #666; margin-bottom: 2rem; }
        .alert { padding: 1rem 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem; font-weight: 500; font-size: 0.9rem; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
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
                <a href="{{ route('expenses.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Expenses
                </a>
                <a href="{{ route('debts.index') }}" class="nav-link">
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

            @if(auth()->user()->isAdmin())
                <div class="nav-divider"></div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color:#ff6b6b">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Admin Panel
                </a>
            @endif

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
            <div class="content-wrapper">

                @if(session('success'))
                    <div class="alert alert-success">✓ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                <div class="page-header">
                    <div>
                        <h1 class="page-title">Categories</h1>
                        <p class="page-subtitle">{{ $flatShare->name }} · {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}</p>
                    </div>
                    <a href="{{ route('categories.create') }}" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        New Category
                    </a>
                </div>

                @if($categories->isEmpty())
                    <div class="empty-state">
                        <h3>No categories yet</h3>
                        <p>Create your first category to start organising expenses.</p>
                        <a href="{{ route('categories.create') }}" class="btn-primary" style="display: inline-flex;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Create Category
                        </a>
                    </div>
                @else
                    <div class="categories-grid">
                        @foreach($categories as $category)
                            <div class="category-card" style="border-left-color: {{ $category->color }}">
                                <div class="category-header">
                                    <span class="color-dot" style="background: {{ $category->color }}"></span>
                                    <span class="category-title">{{ $category->title }}</span>
                                </div>
                                <div class="category-meta">
                                    {{ $category->expenses_count }} {{ Str::plural('expense', $category->expenses_count) }}
                                </div>
                                <div class="category-actions">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn-edit">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn-delete"
                                                {{ $category->expenses_count > 0 ? 'disabled' : '' }}
                                                title="{{ $category->expenses_count > 0 ? 'Cannot delete: category is used in expenses' : 'Delete category' }}"
                                                @if($category->expenses_count === 0)
                                                    onclick="return confirm('Delete \'{{ $category->title }}\'?')"
                                                @endif>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </main>
    </div>
</body>
</html>