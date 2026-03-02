<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses - ColoControll</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh
        }

        .shape {
            position: fixed;
            filter: blur(80px);
            opacity: .2;
            border-radius: 50%;
            z-index: 0;
            animation: float 20s infinite ease-in-out
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            background: #ff6b6b;
            top: -200px;
            right: -200px
        }

        .shape-2 {
            width: 600px;
            height: 600px;
            background: #4ecdc4;
            bottom: -300px;
            left: -200px;
            animation-delay: -5s
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1)
            }

            25% {
                transform: translate(50px, 30px) scale(1.1)
            }

            50% {
                transform: translate(20px, -20px) scale(.9)
            }

            75% {
                transform: translate(-30px, 10px) scale(1.05)
            }
        }

        .dashboard-container {
            position: relative;
            z-index: 10;
            display: flex;
            min-height: 100vh
        }

        .side-nav {
            width: 280px;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(10px);
            padding: 2rem 1.5rem;
            box-shadow: 4px 0 20px rgba(0, 0, 0, .1);
            position: fixed;
            height: 100vh;
            overflow-y: auto
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0
        }

        .nav-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .nav-brand h2 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: .5rem
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: .875rem 1rem;
            border-radius: 1rem;
            color: #666;
            text-decoration: none;
            transition: all .3s ease;
            font-weight: 500
        }

        .nav-link svg {
            width: 20px;
            height: 20px
        }

        .nav-link:hover {
            background: linear-gradient(135deg, rgba(255, 107, 107, .1), rgba(78, 205, 196, .1));
            color: #ff6b6b;
            transform: translateX(5px)
        }

        .nav-link.active {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: white;
            box-shadow: 0 10px 20px rgba(255, 107, 107, .2)
        }

        .nav-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 1rem 0
        }

        .user-info {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            gap: .75rem
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600
        }

        .user-details {
            flex: 1
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: .95rem
        }

        .user-email {
            color: #666;
            font-size: .8rem
        }

        .logout-btn {
            color: #ff6b6b
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem
        }

        .content-wrapper {
            max-width: 1100px;
            margin: 0 auto
        }

        .page-header {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .1);
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .page-subtitle {
            color: #666;
            font-size: .95rem;
            margin-top: .25rem
        }

        .btn-primary {
            padding: .875rem 1.75rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 2rem;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all .3s ease;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-size: .95rem;
            text-decoration: none
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, .3)
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            font-size: .9rem
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca
        }

        .expense-list {
            display: flex;
            flex-direction: column;
            gap: 1rem
        }

        .expense-card {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            transition: all .3s ease;
            text-decoration: none;
            display: block;
            border-left: 5px solid #e5e7eb
        }

        .expense-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .12)
        }

        .expense-row {
            display: flex;
            align-items: center;
            gap: 1rem
        }

        .expense-main {
            flex: 1
        }

        .expense-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #333;
            margin-bottom: .25rem
        }

        .expense-meta {
            font-size: .82rem;
            color: #888;
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-wrap: wrap
        }

        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .2rem .6rem;
            border-radius: 2rem;
            font-size: .75rem;
            font-weight: 600
        }

        .expense-amount {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            white-space: nowrap
        }

        .expense-amount span {
            font-size: .8rem;
            color: #888;
            font-weight: 500;
            display: block;
            text-align: right
        }

        .settlement-bar {
            display: flex;
            gap: .3rem;
            margin-top: .75rem;
            flex-wrap: wrap
        }

        .pip {
            width: 10px;
            height: 10px;
            border-radius: 50%
        }

        .pip.paid {
            background: #4ecdc4
        }

        .pip.unpaid {
            background: #e5e7eb
        }

        .empty-state {
            background: rgba(255, 255, 255, .95);
            border-radius: 2rem;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .1)
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: .75rem
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem
        }
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
                        <path d="M3 12h3l3-9 3 18 3-9h3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <h2>ColoControll</h2>
            </div>
            <div class="nav-links">
                <a href="{{ route('flatshares.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Flatshare
                </a>
                <a href="{{ route('expenses.index') }}" class="nav-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                        <path d="M12 6v2M12 16v2" />
                    </svg>
                    Expenses
                </a>
                <a href="#" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M21 12V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14" />
                        <path d="M16.5 16.5L21 21" />
                        <path d="M21 16.5L16.5 21" />
                    </svg>
                    Who Owes Who
                </a>
                @if(auth()->id() === $flatShare->owner_id)
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                        </svg>
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
                <a href="{{ route('logout') }}" class="logout-btn"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
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
                        <h1 class="page-title">Expenses</h1>
                        <p class="page-subtitle">{{ $flatShare->name }} · {{ $expenses->count() }}
                            {{ Str::plural('expense', $expenses->count()) }}</p>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
                        <form method="GET" action="{{ route('expenses.index') }}"
                            style="display:flex;align-items:center;gap:.5rem">
                            <input type="month" name="month" value="{{ $month }}"
                                style="padding:.625rem 1rem;background:white;border:2px solid #e5e7eb;border-radius:1rem;font-family:'Space Grotesk',sans-serif;font-size:.88rem;color:#333;outline:none;cursor:pointer"
                                onchange="this.form.submit()">
                            @if($month)
                                <a href="{{ route('expenses.index') }}"
                                    style="padding:.625rem 1rem;border:2px solid #e5e7eb;border-radius:1rem;color:#888;font-size:.85rem;font-weight:600;text-decoration:none;white-space:nowrap;transition:all .2s"
                                    onmouseover="this.style.borderColor='#ff6b6b';this.style.color='#ff6b6b'"
                                    onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#888'">
                                    Clear
                                </a>
                            @endif
                        </form>
                        <a href="{{ route('expenses.create') }}" class="btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add Expense
                        </a>
                    </div>
                </div>

                @if($expenses->isEmpty())
                    <div class="empty-state">
                        <h3>No expenses yet</h3>
                        <p>Add your first expense to start tracking costs.</p>
                        <a href="{{ route('expenses.create') }}" class="btn-primary" style="display:inline-flex">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add Expense
                        </a>
                    </div>
                @else
                    <div class="expense-list">
                        @foreach($expenses as $expense)
                            @php
                                $paidCount = $expense->payments->where('payed', true)->count();
                                $totalCount = $expense->payments->count();
                                $catColor = $expense->categorie?->color ?? '#e5e7eb';
                            @endphp
                            <a href="{{ route('expenses.show', $expense) }}" class="expense-card"
                                style="border-left-color: {{ $catColor }}">
                                <div class="expense-row">
                                    <div class="expense-main">
                                        <div class="expense-title">{{ $expense->title }}</div>
                                        <div class="expense-meta">
                                            <span>{{ $expense->date->format('M d, Y') }}</span>
                                            <span>Paid by <strong>{{ $expense->payer->name }}</strong></span>
                                            <span>Created by {{ $expense->creator->name }}</span>
                                            @if($expense->categorie)
                                                <span class="cat-badge"
                                                    style="background: {{ $expense->categorie->color }}22; color: {{ $expense->categorie->color }}">
                                                    <span
                                                        style="width:7px;height:7px;border-radius:50%;background:{{ $expense->categorie->color }};display:inline-block;flex-shrink:0"></span>
                                                    {{ $expense->categorie->title }}
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Settlement pips -->
                                        <div class="settlement-bar">
                                            @foreach($expense->payments as $payment)
                                                <div class="pip {{ $payment->payed ? 'paid' : 'unpaid' }}"
                                                    title="{{ $payment->user->name }}: {{ $payment->payed ? 'Paid' : 'Owes' }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="expense-amount">
                                        ${{ number_format($expense->ammount, 2) }}
                                        <span>{{ $paidCount }}/{{ $totalCount }} settled</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
        </main>
    </div>
</body>

</html>