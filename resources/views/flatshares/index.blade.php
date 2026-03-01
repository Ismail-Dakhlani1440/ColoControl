<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flatshare - ColoControll</title>
    
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

        /* Dashboard container */
        .dashboard-container {
            position: relative;
            z-index: 10;
            display: flex;
            min-height: 100vh;
        }

        /* Side Navigation */
        .side-nav {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 2rem 1.5rem;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .nav-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-brand-icon svg {
            width: 24px;
            height: 24px;
            color: white;
        }

        .nav-brand h2 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            border-radius: 1rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(78, 205, 196, 0.1));
            color: #ff6b6b;
            transform: translateX(5px);
        }

        .nav-link:hover svg {
            color: #ff6b6b;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: white;
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.2);
        }

        .nav-link.active svg {
            color: white;
        }

        .nav-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 1rem 0;
        }

        .user-info {
            margin-top: auto;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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
            font-size: 1.1rem;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .user-email {
            color: #666;
            font-size: 0.8rem;
        }

        .logout-btn {
            color: #ff6b6b;
            transition: color 0.3s ease;
        }

        .logout-btn:hover {
            color: #ff5252;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Welcome section */
        .welcome-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        .flatshare-badge {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .flatshare-badge svg {
            width: 20px;
            height: 20px;
        }

        /* Empty state */
        .empty-state {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .empty-state-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(78, 205, 196, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .empty-state-icon svg {
            width: 60px;
            height: 60px;
            color: #ff6b6b;
        }

        .empty-state h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #333;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-state-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Buttons */
        .btn-primary {
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 2rem;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
        }

        .btn-secondary {
            padding: 1rem 2rem;
            background: white;
            border: 2px solid #ff6b6b;
            border-radius: 2rem;
            color: #ff6b6b;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.2);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(78, 205, 196, 0.1));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
            color: #ff6b6b;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }

        .stat-value.positive {
            color: #4ecdc4;
        }

        .stat-value.negative {
            color: #ff6b6b;
        }

        .stat-helper {
            color: #888;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Roommates Section */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .section-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid #ff6b6b;
            color: #ff6b6b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            background: #ff6b6b;
            color: white;
            transform: rotate(90deg);
        }

        .btn-icon:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-icon:disabled:hover {
            transform: none;
            background: white;
            color: #ff6b6b;
        }

        .roommates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .roommate-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .roommate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .roommate-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .roommate-badge.owner {
            background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
            color: white;
        }

        .roommate-badge.member {
            background: #e9ecef;
            color: #666;
        }

        .roommate-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .roommate-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .roommate-info {
            flex: 1;
        }

        .roommate-name {
            font-weight: 600;
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .roommate-meta {
            display: flex;
            gap: 1rem;
            color: #666;
            font-size: 0.85rem;
        }

        .reputation-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.35rem 1rem;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(78, 205, 196, 0.1));
            border-radius: 2rem;
            color: #ff6b6b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .reputation-badge svg {
            width: 16px;
            height: 16px;
        }

        .reputation-badge.high {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 165, 0, 0.1));
            color: #ff8c00;
        }

        /* Modal Styles */
    </style>
</head>
<body>
    <!-- Animated background shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="dashboard-container">
        <!-- Side Navigation -->
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
                <!-- Flatshare (Active) -->
                <a href="{{ route('flatshares.index') }}" class="nav-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Flatshare
                </a>
                
                <!-- Expenses -->
                <a href="#" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Expenses
                </a>
                
                <!-- Who Owes Who -->
                <a href="#" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                        <path d="M16.5 16.5L21 21"/>
                        <path d="M21 16.5L16.5 21"/>
                    </svg>
                    Who Owes Who
                </a>
                
                <!-- Categories - Owner only -->
                @if($flatShare && auth()->id() === $flatShare->owner_id)
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        Categories
                    </a>
                @endif
            </div>

            <div class="nav-divider"></div>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
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
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </nav>

        <!-- Main Content -->       
        <main class="main-content">
            <div class="content-wrapper">
                @if(!$flatShare)
                    <!-- No Flatshare - Show Create/Join Options -->
                    <div class="welcome-section">
                        <div class="welcome-text">
                            <h1 class="welcome-title">Welcome to ColoControll, {{ auth()->user()->name }}! 👋</h1>
                            <p class="welcome-subtitle">Start your colocation journey today.</p>
                        </div>
                    </div>

                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M3 12h3l3-9 3 18 3-9h3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>You're not part of any flatshare yet</h3>
                        <p>Create a new flatshare and invite your roommates, or join an existing one with an invite token.</p>
                        
                        <div class="empty-state-actions">
                            <a href="{{ route('flatshares.create') }}" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Create Flatshare
                            </a>
                            
                            <button onclick="openTokenModal()" class="btn-secondary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 12h20M12 2v20M4.93 4.93l14.14 14.14M4.93 19.07l14.14-14.14"/>
                                </svg>
                                Join with Token
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Has Flatshare - Show Stats and Roommates -->
                    <div class="welcome-section">
                        <div class="welcome-text">
                            <h1 class="welcome-title">{{ $flatShare->name }}</h1>
                            <p class="welcome-subtitle">Manage your colocation, track expenses, and stay organized.</p>
                        </div>
                        <div class="flatshare-badge">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            {{ $stats['roommate_count'] }} {{ Str::plural('Roommate', $stats['roommate_count']) }}
                        </div>
                    </div>

                    <div class="stats-grid">
                        <!-- Total Spendings -->
                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                                        <path d="M12 6v2M12 16v2"/>
                                    </svg>
                                </div>
                                <span class="stat-label">Total Spent</span>
                            </div>
                            <div class="stat-value">${{ number_format($stats['total_spent'], 2) }}</div>
                            <div class="stat-helper">All time expenses</div>
                        </div>
                        
                        <!-- User Balance -->
                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 12v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7"/>
                                        <polyline points="15 5 20 5 20 10"/>
                                        <line x1="10" y1="14" x2="20" y2="4"/>
                                    </svg>
                                </div>
                                <span class="stat-label">Your Balance</span>
                            </div>
                            <div class="stat-value {{ $stats['user_balance'] >= 0 ? 'positive' : 'negative' }}">
                                ${{ number_format(abs($stats['user_balance']), 2) }}
                            </div>
                            <div class="stat-helper">
                                @if($stats['user_balance'] > 0)
                                    You are owed money
                                @elseif($stats['user_balance'] < 0)
                                    You owe money
                                @else
                                    You're all settled up
                                @endif
                            </div>
                        </div>

                        <!-- Roommates Count -->
                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <span class="stat-label">Fair Share</span>
                            </div>
                            <div class="stat-value">${{ number_format($stats['total_spent'] / $stats['roommate_count'], 2) }}</div>
                            <div class="stat-helper">Per person ({{ $stats['roommate_count'] }} people)</div>
                        </div>
                    </div>

                    <!-- Roommates Section -->
                    <div class="section-header">
                        <h2 class="section-title">Your Roommates</h2>
                        <div class="section-actions">
                            @if(auth()->id() === $flatShare->owner_id && $flatShare->hasAvailableSpace())
                                <form action="{{ route('invitations.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-icon" title="Invite new roommate">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"/>
                                            <line x1="5" y1="12" x2="19" y2="12"/>
                                        </svg>
                                    </button>
                                </form>
                            @elseif(auth()->id() === $flatShare->owner_id && !$flatShare->hasAvailableSpace())
                                <button disabled class="btn-icon opacity-50 cursor-not-allowed" title="No space available">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="roommates-grid">
                        @foreach($stats['roommates'] as $roommate)
                            <div class="roommate-card">
                                <div class="roommate-badge {{ $roommate['badge'] }}">
                                    {{ $roommate['badge'] }}
                                </div>
                                <div class="roommate-header">
                                    <div class="roommate-avatar">
                                        {{ substr($roommate['name'], 0, 1) }}
                                    </div>
                                    <div class="roommate-info">
                                        <div class="roommate-name">{{ $roommate['name'] }}</div>
                                        <div class="roommate-meta">
                                            <span>Joined {{ \Carbon\Carbon::parse($roommate['joined_date'])->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="reputation-badge {{ $roommate['reputation'] >= 4 ? 'high' : '' }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    {{ $roommate['reputation'] }} Reputation
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Join with Token Modal -->
    <div id="tokenModal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center"
         style="background: rgba(0,0,0,0.5)">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md mx-4">

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Join a Flatshare</h3>
                <button onclick="closeTokenModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <p class="text-sm text-gray-500 mb-5">
                Paste the invitation token shared with you to view and accept the invitation.
            </p>

            <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        Invitation Token
                    </label>
                    <input type="text"
                           id="tokenInput"
                           placeholder="Paste your token here..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#ff6b6b] transition">
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeTokenModal()"
                            class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="button" onclick="goToInvitation()"
                            class="flex-1 px-4 py-3 rounded-xl text-white font-semibold hover:opacity-90 transition"
                            style="background: linear-gradient(135deg, #ff6b6b, #4ecdc4)">
                        View Invitation
                    </button>
                </div>

        </div>
    </div>

    <script>
        function openTokenModal() {
            document.getElementById('tokenModal').classList.remove('hidden');
        }
        function closeTokenModal() {
            document.getElementById('tokenModal').classList.add('hidden');
        }
        function goToInvitation() {
            const token = document.getElementById('tokenInput').value.trim();
            if (!token) return;
            window.location.href = '/invitations/' + token;
        }
        document.getElementById('tokenModal').addEventListener('click', function(e) {
            if (e.target === this) closeTokenModal();
        });
    </script>
</body>
</html>