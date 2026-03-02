<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — ColoControll</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet"/>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg:       #0f1117;
            --surface:  #1a1d27;
            --border:   #2a2d3a;
            --accent:   #ff6b6b;
            --teal:     #4ecdc4;
            --text:     #e8eaf0;
            --muted:    #6b7280;
            --danger:   #ef4444;
            --success:  #22c55e;
            --warning:  #f59e0b;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Layout ── */
        .layout { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            padding: 2rem 1.25rem;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
        }
        .brand-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 12px var(--accent);
        }
        .admin-badge {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--accent);
            background: rgba(255,107,107,.1);
            border: 1px solid rgba(255,107,107,.3);
            padding: .2rem .6rem;
            border-radius: 999px;
            margin-left: auto;
        }
        .sidebar-nav { display: flex; flex-direction: column; gap: .25rem; }
        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .7rem 1rem;
            border-radius: .75rem;
            color: var(--muted);
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            transition: all .2s;
        }
        .nav-item:hover { background: rgba(255,255,255,.05); color: var(--text); }
        .nav-item.active { background: rgba(255,107,107,.12); color: var(--accent); }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
            font-size: .8rem;
            color: var(--muted);
        }
        .sidebar-footer strong { display: block; color: var(--text); font-size: .85rem; margin-bottom: .2rem; }

        /* ── Main ── */
        .main { flex: 1; margin-left: 240px; padding: 2.5rem; max-width: 1400px; }

        /* ── Header ── */
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.75rem; font-weight: 700; }
        .page-header p { color: var(--muted); font-size: .9rem; margin-top: .25rem; }

        /* ── Stats grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--accent-color, var(--accent));
        }
        .stat-label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); margin-bottom: .6rem; }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--text); line-height: 1; }
        .stat-sub { font-size: .78rem; color: var(--muted); margin-top: .35rem; }

        /* ── Table ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .section-title { font-size: 1rem; font-weight: 700; }
        .user-count { font-size: .8rem; color: var(--muted); }

        .table-wrap {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            overflow: hidden;
        }

        /* Search */
        .table-toolbar {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            gap: .75rem;
            align-items: center;
        }
        .search-input {
            flex: 1;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: .75rem;
            padding: .6rem 1rem;
            color: var(--text);
            font-family: 'Space Grotesk', sans-serif;
            font-size: .88rem;
            outline: none;
            transition: border-color .2s;
        }
        .search-input:focus { border-color: var(--accent); }
        .search-input::placeholder { color: var(--muted); }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: .875rem 1.25rem;
            text-align: left;
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.02); }
        td { padding: .875rem 1.25rem; font-size: .88rem; vertical-align: middle; }

        /* Avatar */
        .user-cell { display: flex; align-items: center; gap: .75rem; }
        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: .9rem;
            color: white;
            flex-shrink: 0;
        }
        .user-name { font-weight: 600; color: var(--text); }
        .user-email { font-size: .78rem; color: var(--muted); }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .25rem .7rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .03em;
        }
        .badge-admin   { background: rgba(255,107,107,.15); color: var(--accent); border: 1px solid rgba(255,107,107,.3); }
        .badge-user    { background: rgba(78,205,196,.1);   color: var(--teal);   border: 1px solid rgba(78,205,196,.25); }
        .badge-banned  { background: rgba(239,68,68,.1);    color: var(--danger); border: 1px solid rgba(239,68,68,.25); }
        .badge-active  { background: rgba(34,197,94,.1);    color: var(--success);border: 1px solid rgba(34,197,94,.25); }

        /* Role select */
        .role-select {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: .6rem;
            color: var(--text);
            font-family: 'Space Grotesk', sans-serif;
            font-size: .82rem;
            padding: .35rem .75rem;
            outline: none;
            cursor: pointer;
            transition: border-color .2s;
        }
        .role-select:focus { border-color: var(--accent); }
        .role-select:disabled { opacity: .4; cursor: not-allowed; }

        /* Action buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .4rem .9rem;
            border-radius: .6rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-ban   { background: rgba(239,68,68,.12);  color: var(--danger);  border: 1px solid rgba(239,68,68,.25); }
        .btn-unban { background: rgba(34,197,94,.1);   color: var(--success); border: 1px solid rgba(34,197,94,.25); }
        .btn-ban:hover   { background: rgba(239,68,68,.25); }
        .btn-unban:hover { background: rgba(34,197,94,.2); }
        .btn:disabled { opacity: .35; cursor: not-allowed; }

        .actions-cell { display: flex; align-items: center; gap: .5rem; }

        /* Alert */
        .alert {
            padding: .875rem 1.25rem;
            border-radius: .875rem;
            margin-bottom: 1.5rem;
            font-size: .88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .alert-success { background: rgba(34,197,94,.1);  color: var(--success); border: 1px solid rgba(34,197,94,.25); }
        .alert-error   { background: rgba(239,68,68,.1);  color: var(--danger);  border: 1px solid rgba(239,68,68,.25); }

        /* You tag */
        .you-tag {
            font-size: .65rem;
            font-weight: 700;
            color: var(--muted);
            background: var(--border);
            padding: .15rem .45rem;
            border-radius: 999px;
            margin-left: .4rem;
        }
    </style>
</head>
<body>
<div class="layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-dot"></div>
            ColoControll
            <span class="admin-badge">Admin</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('flatshares.index') }}" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                My Flatshare
            </a>
        </nav>

        <div class="sidebar-footer">
            <strong>{{ auth()->user()->name }}</strong>
            {{ auth()->user()->email }}
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="main">

        <div class="page-header">
            <h1>Admin Dashboard</h1>
            <p>Global overview & user management</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card" style="--accent-color: #4ecdc4">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $stats['totalUsers'] }}</div>
                <div class="stat-sub">{{ $stats['bannedUsers'] }} banned</div>
            </div>
            <div class="stat-card" style="--accent-color: #ff6b6b">
                <div class="stat-label">Flatshares</div>
                <div class="stat-value">{{ $stats['totalFlatShares'] }}</div>
                <div class="stat-sub">active colocs</div>
            </div>
            <div class="stat-card" style="--accent-color: #a78bfa">
                <div class="stat-label">Expenses</div>
                <div class="stat-value">{{ $stats['totalExpenses'] }}</div>
                <div class="stat-sub">all time</div>
            </div>
            <div class="stat-card" style="--accent-color: #f59e0b">
                <div class="stat-label">Total Spent</div>
                <div class="stat-value">${{ number_format($stats['totalSpent'], 0) }}</div>
                <div class="stat-sub">across all flats</div>
            </div>
            <div class="stat-card" style="--accent-color: #ef4444">
                <div class="stat-label">Banned</div>
                <div class="stat-value">{{ $stats['bannedUsers'] }}</div>
                <div class="stat-sub">{{ $stats['totalUsers'] > 0 ? round($stats['bannedUsers'] / $stats['totalUsers'] * 100) : 0 }}% of users</div>
            </div>
        </div>

        {{-- USER TABLE --}}
        <div class="section-header">
            <span class="section-title">Users</span>
            <span class="user-count">{{ $users->count() }} total</span>
        </div>

        <div class="table-wrap">
            <div class="table-toolbar">
                <input type="text" class="search-input" placeholder="Search by name or email..." id="searchInput">
            </div>

            <table id="userTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Flatshares</th>
                        <th>Expenses</th>
                        <th>Joined</th>
                        <th>Change Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @php
                            $colors  = ['#ff6b6b','#4ecdc4','#667eea','#f59e0b','#a78bfa','#22c55e'];
                            $color   = $colors[$user->id % count($colors)];
                            $isMe    = $user->id === auth()->id();
                            $isAdmin = $user->isAdmin();
                        @endphp
                        <tr>
                            {{-- User --}}
                            <td>
                                <div class="user-cell">
                                    <div class="avatar" style="background: {{ $color }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="user-name">
                                            {{ $user->name }}
                                            @if($isMe)<span class="you-tag">you</span>@endif
                                        </div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Role badge --}}
                            <td>
                                <span class="badge {{ $isAdmin ? 'badge-admin' : 'badge-user' }}">
                                    {{ $user->role?->title ?? 'user' }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge {{ $user->is_banned ? 'badge-banned' : 'badge-active' }}">
                                    {{ $user->is_banned ? 'Banned' : 'Active' }}
                                </span>
                            </td>

                            {{-- Flatshares --}}
                            <td>{{ $user->owned_flat_shares_count }}</td>

                            {{-- Expenses --}}
                            <td>{{ $user->created_expenses_count }}</td>

                            {{-- Joined --}}
                            <td style="color: var(--muted)">{{ $user->created_at->format('M d, Y') }}</td>

                            {{-- Change role --}}
                            <td>
                                <form action="{{ route('admin.updateRole', $user) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role_id" class="role-select"
                                        onchange="this.form.submit()"
                                        {{ $isMe ? 'disabled' : '' }}>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ ucfirst($role->title) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            {{-- Ban / Unban --}}
                            <td>
                                <div class="actions-cell">
                                    @if($user->is_banned)
                                        <form action="{{ route('admin.unban', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-unban" {{ $isMe ? 'disabled' : '' }}>
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                                Unban
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.ban', $user) }}" method="POST"
                                            onsubmit="return confirm('Ban {{ addslashes($user->name) }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-ban" {{ ($isMe || $isAdmin) ? 'disabled' : '' }}>
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                                Ban
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('#userTable tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
</script>
</body>
</html>