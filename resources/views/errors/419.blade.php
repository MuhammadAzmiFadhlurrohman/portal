<!DOCTYPE html>
<html lang="id" class="h-full bg-[#050d1a] text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Sesi Halaman Berakhir | PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0284c7',
                            cyan: '#0ea5e9',
                            sky: '#38bdf8',
                            navy: '#07172e',
                            dark: '#050d1a',
                        }
                    },
                    fontFamily: {
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <style>
        body {
            background: radial-gradient(circle at 50% 25%, #0c2340 0%, #07172e 60%, #050d1a 100%);
            font-family: 'Inter', sans-serif;
        }
        .glass-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 35px rgba(56, 189, 248, 0.15);
        }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 relative overflow-hidden text-slate-200">

    <!-- Ambient Grid & Glow -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(56, 189, 248, 0.4) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[300px] bg-[#38bdf8]/15 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[480px] mx-auto py-8 text-center">
        
        <!-- Brand Logo Header -->
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-6 hover:opacity-90 transition-opacity">
            <img 
                src="{{ asset('images/logo/logo-msn-white.png') }}" 
                alt="PT Media Solusi Network" 
                class="h-10 sm:h-12 w-auto object-contain drop-shadow-[0_0_15px_rgba(56,189,248,0.4)]"
            >
        </a>

        <!-- Main Card -->
        <div class="glass-card rounded-3xl p-7 sm:p-9 text-center">
            
            <!-- Icon -->
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center shadow-lg shadow-amber-500/10">
                <iconify-icon icon="solar:clock-circle-bold" width="36"></iconify-icon>
            </div>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/25 text-[11px] font-mono font-bold text-amber-300 uppercase tracking-widest mb-3">
                <span>ERROR 419 • SESI KEDALUWARSA</span>
            </div>

            <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-white tracking-tight mb-2">
                Sesi Halaman Telah Berakhir
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mb-6 font-sans">
                Halaman ini telah kedaluwarsa karena tidak ada aktivitas dalam waktu tertentu demi keamanan akun Anda.
            </p>

            <div class="p-3 rounded-2xl bg-white/[0.05] border border-white/10 text-xs text-slate-400 mb-6 font-mono">
                Mengalihkan otomatis ke login dalam <span id="countdown" class="text-amber-300 font-bold">5</span> detik...
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2.5">
                <a 
                    href="{{ route('portal.login') }}" 
                    class="flex-1 py-3 px-5 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-sky-500/25 active:scale-95 flex items-center justify-center gap-1.5"
                >
                    <iconify-icon icon="solar:user-circle-bold" width="16"></iconify-icon>
                    <span>Portal Pelanggan</span>
                </a>
                <button 
                    onclick="window.location.reload()" 
                    class="py-3 px-5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 text-slate-200 font-heading font-bold text-xs uppercase tracking-wider transition-all active:scale-95 flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <iconify-icon icon="solar:restart-bold" width="16"></iconify-icon>
                    <span>Muat Ulang</span>
                </button>
            </div>

        </div>

        <div class="text-[11px] text-slate-500 font-mono mt-6">
            &copy; {{ date('Y') }} PT Media Solusi Network. All rights reserved.
        </div>

    </div>

    <script>
        let seconds = 5;
        const countdownEl = document.getElementById('countdown');
        const timer = setInterval(() => {
            seconds--;
            if (countdownEl) countdownEl.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                // Cek apakah halaman sebelumnya ada di portal pelanggan
                if (document.referrer && document.referrer.includes('/admin')) {
                    window.location.href = "{{ route('admin.login') }}";
                } else {
                    window.location.href = "{{ route('portal.login') }}";
                }
            }
        }, 1000);
    </script>
</body>
</html>
