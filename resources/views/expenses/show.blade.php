<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $expense->title }} - ColoControll</title>
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
            font-weight: 600;
            font-size: 1rem
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
            max-width: 780px;
            margin: 0 auto
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            transition: color .2s
        }

        .back-link:hover {
            color: white
        }

        .card {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .1);
            margin-bottom: 1.5rem
        }

        .expense-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap
        }

        .expense-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: .4rem
        }

        .expense-desc {
            color: #666;
            font-size: .95rem;
            margin-top: .5rem
        }

        .amount-pill {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: white;
            padding: .875rem 1.75rem;
            border-radius: 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            white-space: nowrap
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem
        }

        .meta-item {}

        .meta-label {
            font-size: .72rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .25rem
        }

        .meta-value {
            font-size: .95rem;
            font-weight: 600;
            color: #333
        }

        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .25rem .75rem;
            border-radius: 2rem;
            font-size: .82rem;
            font-weight: 600
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .payment-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: .875rem 1rem;
            border-radius: 1rem;
            margin-bottom: .5rem;
            background: #f8f9fa;
            transition: background .2s
        }

        .payment-row:last-child {
            margin-bottom: 0
        }

        .payment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: .9rem;
            flex-shrink: 0
        }

        .payment-name {
            flex: 1;
            font-weight: 600;
            color: #333;
            font-size: .95rem
        }

        .payment-sub {
            font-size: .78rem;
            color: #888;
            margin-top: .1rem
        }

        .payment-amount {
            font-weight: 700;
            color: #333;
            font-size: .95rem;
            white-space: nowrap
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .25rem .75rem;
            border-radius: 2rem;
            font-size: .78rem;
            font-weight: 700
        }

        .status-paid {
            background: #f0fdf4;
            color: #15803d
        }

        .status-paid::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #15803d
        }

        .status-owed {
            background: #fff7ed;
            color: #ea580c
        }

        .status-owed::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ea580c
        }

        .status-payer {
            background: linear-gradient(135deg, rgba(255, 107, 107, .1), rgba(78, 205, 196, .1));
            color: #333
        }

        .btn-mark {
            padding: .4rem .875rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: .75rem;
            color: white;
            font-weight: 600;
            font-size: .78rem;
            cursor: pointer;
            font-family: 'Space Grotesk', sans-serif;
            transition: all .2s;
            white-space: nowrap
        }

        .btn-mark:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, .3)
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

        .settled-banner {
            background: linear-gradient(135deg, rgba(78, 205, 196, .1), rgba(78, 205, 196, .2));
            border: 1px solid rgba(78, 205, 196, .3);
            border-radius: 1rem;
            padding: .875rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .5rem;
            color: #0f766e;
            font-weight: 600;
            font-size: .9rem;
            margin-top: 1rem
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
                @if($isOwner)
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

                <a href="{{ route('expenses.index') }}" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Back to Expenses
                </a>

                @if(session('success'))
                    <div class="alert alert-success">✓ {{ session('success') }}</div>
                @endif

                {{-- EXPENSE DETAILS CARD --}}
                <div class="card" @if($expense->categorie)
                style="border-left:5px solid {{ $expense->categorie->color }}" @endif>
                    <div class="expense-header">
                        <div>
                            <h1 class="expense-title">{{ $expense->title }}</h1>
                            @if($expense->categorie)
                                <span class="cat-badge"
                                    style="background:{{ $expense->categorie->color }}22;color:{{ $expense->categorie->color }}">
                                    <span
                                        style="width:7px;height:7px;border-radius:50%;background:{{ $expense->categorie->color }};display:inline-block;flex-shrink:0"></span>
                                    {{ $expense->categorie->title }}
                                </span>
                            @endif
                            @if($expense->description)
                                <p class="expense-desc">{{ $expense->description }}</p>
                            @endif
                        </div>
                        <div class="amount-pill">${{ number_format($expense->ammount, 2) }}</div>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Date</div>
                            <div class="meta-value">{{ $expense->date->format('M d, Y') }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Split per person</div>
                            <div class="meta-value">${{ number_format($expense->getSplitAmount(), 2) }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Paid by</div>
                            <div class="meta-value">
                                {{ $expense->payer->name }}{{ $expense->payer_id === auth()->id() ? ' (you)' : '' }}
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Created by</div>
                            <div class="meta-value">
                                {{ $expense->creator->name }}{{ $expense->creator_id === auth()->id() ? ' (you)' : '' }}
                            </div>
                        </div>
                    </div>

                    @php
                        $allPaid = $expense->payments->every(fn($p) => $p->payed);
                    @endphp
                    @if($allPaid)
                        <div class="settled-banner">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Fully settled
                        </div>
                    @endif


                </div>

                {{-- PAYMENTS CARD --}}
                <div class="card">
                    <div class="section-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff6b6b" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        Payment breakdown
                    </div>

                    @foreach($expense->payments as $payment)
                        @php
                            $isPayer = $payment->user_id === $expense->payer_id;
                            $isMe = $payment->user_id === auth()->id();
                            $canMark = $isOwner || $isMe;
                            $colors = ['#ff6b6b', '#4ecdc4', '#667eea', '#f6c90e', '#a78bfa', '#fb923c'];
                            $avatarColor = $colors[$payment->user_id % count($colors)];
                        @endphp
                        <div class="payment-row">
                            <div class="payment-avatar" style="background:{{ $avatarColor }}">
                                {{ substr($payment->user->name, 0, 1) }}
                            </div>
                            <div style="flex:1">
                                <div class="payment-name">
                                    {{ $payment->user->name }}{{ $isMe ? ' (you)' : '' }}
                                </div>
                                <div class="payment-sub">
                                    @if($isPayer)
                                        Originally paid the full amount
                                    @else
                                        Owes ${{ number_format($expense->getSplitAmount(), 2) }} to {{ $expense->payer->name }}
                                    @endif
                                </div>
                            </div>

                            @if($isPayer)
                                <span class="status-badge status-payer">Payer</span>
                            @elseif($payment->payed)
                                <span class="status-badge status-paid">Settled</span>
                            @else
                                <span class="status-badge status-owed">Owes
                                    ${{ number_format($expense->getSplitAmount(), 2) }}</span>
                            @endif

                            @if(!$isPayer && !$payment->payed && $canMark)
                                <form action="{{ route('expenses.markPaid', $expense) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $payment->user_id }}">
                                    <button type="submit" class="btn-mark">Mark as Paid</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </main>
    </div>
</body>

</html>