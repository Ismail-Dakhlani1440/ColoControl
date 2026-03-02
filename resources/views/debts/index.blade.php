<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who Owes Who - ColoControll</title>
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

        /* Nav */
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

        /* Main */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem
        }

        .content-wrapper {
            max-width: 900px;
            margin: 0 auto
        }

        .page-header {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .1)
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

        /* All settled */
        .settled-card {
            background: rgba(255, 255, 255, .95);
            border-radius: 2rem;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .1)
        }

        .settled-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem
        }

        .settled-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: .5rem
        }

        .settled-sub {
            color: #888;
            font-size: .95rem
        }

        /* Debt cards */
        .debts-list {
            display: flex;
            flex-direction: column;
            gap: 1rem
        }

        .debt-card {
            background: rgba(255, 255, 255, .95);
            border-radius: 1.75rem;
            padding: 1.5rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: transform .2s, box-shadow .2s
        }

        .debt-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .12)
        }

        .debt-card.mine {
            border-left: 5px solid #ff6b6b
        }

        .debt-card.owed-to-me {
            border-left: 5px solid #4ecdc4
        }

        /* Person bubbles */
        .person {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            min-width: 80px
        }

        .avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0
        }

        .person-name {
            font-size: .78rem;
            font-weight: 600;
            color: #555;
            text-align: center;
            max-width: 80px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .person-you {
            font-size: .7rem;
            color: #aaa;
            font-weight: 500
        }

        /* Arrow area */
        .arrow-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem
        }

        .arrow-track {
            width: 100%;
            height: 3px;
            background: #f0f0f0;
            border-radius: 2px;
            position: relative;
            display: flex;
            align-items: center
        }

        .arrow-fill {
            height: 100%;
            border-radius: 2px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            position: relative;
            animation: fillIn .8s ease forwards
        }

        @keyframes fillIn {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        .arrow-head {
            width: 0;
            height: 0;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-left: 10px solid #4ecdc4;
            flex-shrink: 0;
            margin-left: -1px
        }

        .amount-bubble {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            padding: .35rem 1rem;
            border-radius: 2rem;
            box-shadow: 0 4px 12px rgba(255, 107, 107, .3)
        }

        .owes-label {
            font-size: .75rem;
            color: #aaa;
            font-weight: 500
        }
    </style>
</head>

<body>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="dashboard-container">

        {{-- NAV --}}
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
                <a href="{{ route('expenses.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                        <path d="M12 6v2M12 16v2" />
                    </svg>
                    Expenses
                </a>
                <a href="{{ route('debts.index') }}" class="nav-link active">
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

        {{-- MAIN --}}
        <main class="main-content">
            <div class="content-wrapper">

                <div class="page-header">
                    <h1 class="page-title">Who Owes Who</h1>
                    <p class="page-subtitle">{{ $flatShare->name }} · Net balances across all expenses</p>
                </div>

                @php
                    $colors = ['#ff6b6b', '#4ecdc4', '#667eea', '#f6c90e', '#a78bfa', '#fb923c'];
                    $memberColors = [];
                    foreach ($members as $id => $member) {
                        $memberColors[$id] = $colors[$id % count($colors)];
                    }
                @endphp

                @if(empty($netDebts))
                    <div class="settled-card">
                        <div class="settled-icon">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <div class="settled-title">Everyone is settled up! 🎉</div>
                        <div class="settled-sub">No outstanding debts in {{ $flatShare->name }}</div>
                    </div>
                @else
                    <div class="debts-list">
                        @foreach($netDebts as $debt)
                            @php
                                $isMe = $debt['from']->id === auth()->id();
                                $owedToMe = $debt['to']->id === auth()->id();
                            @endphp
                            <div class="debt-card {{ $isMe ? 'mine' : ($owedToMe ? 'owed-to-me' : '') }}">

                                {{-- FROM person --}}
                                <div class="person">
                                    <div class="avatar" style="background: {{ $memberColors[$debt['from']->id] }}">
                                        {{ substr($debt['from']->name, 0, 1) }}
                                    </div>
                                    <div class="person-name">{{ $debt['from']->name }}</div>
                                    @if($isMe)
                                    <div class="person-you">you</div>@endif
                                </div>

                                {{-- Arrow + amount --}}
                                <div class="arrow-section">
                                    <div class="owes-label">owes</div>
                                    <div class="amount-bubble">${{ number_format($debt['amount'], 2) }}</div>
                                    <div style="width:100%;display:flex;align-items:center">
                                        <div class="arrow-track" style="flex:1">
                                            <div class="arrow-fill"></div>
                                        </div>
                                        <div class="arrow-head"></div>
                                    </div>
                                </div>

                                {{-- TO person --}}
                                <div class="person">
                                    <div class="avatar" style="background: {{ $memberColors[$debt['to']->id] }}">
                                        {{ substr($debt['to']->name, 0, 1) }}
                                    </div>
                                    <div class="person-name">{{ $debt['to']->name }}</div>
                                    @if($owedToMe)
                                    <div class="person-you">you</div>@endif
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