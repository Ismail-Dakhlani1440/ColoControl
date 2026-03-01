<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation - ColoControll</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .shape { position: fixed; filter: blur(80px); opacity: 0.2; border-radius: 50%; z-index: 0; animation: float 20s infinite ease-in-out; }
        .shape-1 { width: 500px; height: 500px; background: #ff6b6b; top: -200px; right: -200px; }
        .shape-2 { width: 600px; height: 600px; background: #4ecdc4; bottom: -300px; left: -200px; animation-delay: -5s; }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25%  { transform: translate(50px, 30px) scale(1.1); }
            50%  { transform: translate(20px, -20px) scale(0.9); }
            75%  { transform: translate(-30px, 10px) scale(1.05); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    @php $isOwner = auth()->id() === $invitation->flatShare->owner_id; @endphp

    <div class="relative z-10 w-full max-w-lg">

        <a href="{{ route('flatshares.index') }}"
           class="inline-flex items-center gap-2 text-white/80 hover:text-white mb-6 transition text-sm font-medium">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to Flatshare
        </a>

        <div class="bg-white/95 backdrop-blur rounded-3xl shadow-2xl p-8">

            <!-- Header -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, rgba(255,107,107,0.15), rgba(78,205,196,0.15))">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff6b6b" stroke-width="2">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        @if($isOwner) Your Invitation @else You've been invited! @endif
                    </h1>
                    <p class="text-gray-500 text-sm">{{ $invitation->flatShare->name }}</p>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Status</p>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold
                    {{ $invitation->isPending() ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-600' }}">
                    <span class="w-2 h-2 rounded-full {{ $invitation->isPending() ? 'bg-amber-500' : 'bg-red-500' }}"></span>
                    {{ ucfirst($invitation->status) }}
                </span>
            </div>

            @if($isOwner)
                {{-- OWNER: token --}}
                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Token</p>
                    <div class="flex gap-2">
                        <div class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 font-mono text-sm text-gray-700 break-all">
                            {{ $invitation->id }}
                        </div>
                        <button onclick="copyToken()"
                                class="px-4 py-3 rounded-xl text-white text-sm font-medium transition hover:opacity-90 shrink-0"
                                style="background: linear-gradient(135deg, #ff6b6b, #4ecdc4)">
                            Copy
                        </button>
                    </div>
                    <p id="tokenConfirm" class="text-green-600 text-xs mt-2 hidden">✓ Token copied!</p>
                </div>

            @else
                {{-- GUEST: flatshare info + accept/reject --}}
                <div class="mb-6 p-4 rounded-2xl" style="background: linear-gradient(135deg, rgba(255,107,107,0.08), rgba(78,205,196,0.08))">
                    <p class="text-sm text-gray-600">
                        You have been invited to join <span class="font-semibold text-gray-800">{{ $invitation->flatShare->name }}</span>.
                        It currently has
                        <span class="font-semibold text-gray-800">{{ $invitation->flatShare->activeUsers()->count() }}/{{ $invitation->flatShare->max_flatmate }}</span>
                        members.
                    </p>
                </div>

                @if($invitation->isPending())
                    <div class="flex gap-3">
                        <form action="{{ route('invitations.reject', $invitation) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-600 font-semibold hover:border-red-300 hover:text-red-600 hover:bg-red-50 transition">
                                Decline
                            </button>
                        </form>
                        <form action="{{ route('invitations.accept', $invitation) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full px-4 py-3 rounded-xl text-white font-semibold hover:opacity-90 transition"
                                    style="background: linear-gradient(135deg, #ff6b6b, #4ecdc4)">
                                Accept & Join
                            </button>
                        </form>
                    </div>
                @else
                    <div class="p-4 bg-red-50 rounded-xl text-red-600 text-sm font-medium text-center">
                        This invitation has expired and is no longer valid.
                    </div>
                @endif
            @endif

            <!-- Meta -->
            <div class="border-t border-gray-100 mt-6 pt-5 flex justify-between text-xs text-gray-400">
                <span>Created {{ $invitation->created_at->format('M d, Y · H:i') }}</span>
                <span>{{ $invitation->flatShare->activeUsers()->count() }}/{{ $invitation->flatShare->max_flatmate }} members</span>
            </div>

        </div>
    </div>

    <script>
        function copyToken() {
            navigator.clipboard.writeText('{{ $invitation->id }}').then(() => {
                document.getElementById('tokenConfirm').classList.remove('hidden');
                setTimeout(() => document.getElementById('tokenConfirm').classList.add('hidden'), 3000);
            });
        }
    </script>

</body>
</html>