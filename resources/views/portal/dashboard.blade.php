@extends('portal.layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="space-y-3.5 sm:space-y-5">

    <!-- Executive Dark Glassmorphism Hero Card -->
    <div id="tour-step-hero" class="hero-network-card p-4 sm:p-6 lg:p-7 relative overflow-hidden rounded-2xl sm:rounded-3xl border border-sky-500/30 shadow-xl shadow-sky-950/20">
        <!-- Ambient Glowing Tech Lighting Orbs (Optimized GPU Containment) -->
        <div class="absolute -top-16 -right-16 w-56 h-56 bg-cyan-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-sky-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(rgba(56,189,248,0.08)_1px,transparent_1px)] [background-size:22px_22px] pointer-events-none"></div>
        
        <div class="relative z-10 space-y-3 sm:space-y-4">
            
            <!-- Top Row: ID, Status Badges & Membership Tenure (Fits on one neat line on mobile) -->
            <div class="flex items-center justify-between gap-2">
                <!-- Left: Single-Row Status Badges -->
                <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto no-scrollbar py-0.5 max-w-full">
                    <!-- Customer ID with Click-to-Copy -->
                    <button 
                        type="button"
                        onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')" 
                        class="group inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl bg-white/[0.08] hover:bg-white/[0.15] border border-white/15 text-sky-200 font-mono text-[10.5px] sm:text-xs font-bold transition-all shadow-2xs active:scale-95 cursor-pointer backdrop-blur-md shrink-0"
                        title="Klik untuk menyalin ID Pelanggan"
                    >
                        <iconify-icon icon="solar:hashtag-bold" class="text-sky-400 text-xs shrink-0"></iconify-icon>
                        <span>ID: {{ $customer->customer_id }}</span>
                        <iconify-icon icon="solar:copy-linear" class="text-sky-300/60 group-hover:text-sky-300 text-xs shrink-0 transition-colors"></iconify-icon>
                    </button>

                    <!-- Registration / Connection Status Pill -->
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl border text-[10.5px] sm:text-xs font-semibold {{ $customer->status_reg_badge_class }} backdrop-blur-md shadow-2xs shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full {{ $customer->status_reg_dot_class }} shrink-0"></span>
                        <span>{{ $customer->status_reg_label }}</span>
                    </span>

                    <!-- Email Verification Status Badge / Trigger -->
                    @if(!empty($customer->email))
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl border text-[10.5px] sm:text-xs font-semibold bg-emerald-500/15 border-emerald-400/35 text-emerald-300 backdrop-blur-md shadow-2xs shrink-0" title="{{ $customer->email }}">
                            <iconify-icon icon="solar:verified-check-bold" class="text-emerald-400 text-xs shrink-0"></iconify-icon>
                            <span>Terverifikasi</span>
                        </span>
                    @else
                        <a 
                            href="{{ route('portal.profile') }}"
                            class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl border text-[10.5px] sm:text-xs font-semibold bg-amber-500/15 border-amber-400/35 text-amber-300 hover:bg-amber-500/25 transition-all backdrop-blur-md shadow-2xs cursor-pointer shrink-0"
                            title="Klik untuk melengkapi email di profil"
                        >
                            <iconify-icon icon="solar:letter-bold" class="text-amber-400 text-xs shrink-0"></iconify-icon>
                            <span>Verifikasi Email</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                        </a>
                    @endif
                </div>

                <!-- Right: Desktop Membership Tenure Pill -->
                @if($customer->berlangganan_sejak !== '-')
                    <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/[0.06] border border-white/10 text-cyan-200 text-xs font-medium backdrop-blur-md shadow-2xs shrink-0" title="Total durasi aktif: {{ $customer->subscription_duration_text }}">
                        <iconify-icon icon="solar:calendar-date-bold" class="text-cyan-400 text-xs shrink-0"></iconify-icon>
                        <span>Langganan Sejak {{ $customer->berlangganan_sejak }}</span>
                        <span class="text-cyan-400/40">•</span>
                        <span class="text-emerald-300 font-mono font-semibold">{{ $customer->subscription_duration_text }}</span>
                    </div>
                @endif
            </div>

            <!-- Middle & Action Row -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5 sm:gap-4 pt-0.5 sm:pt-1">
                
                <!-- Left: Greeting & Description -->
                <div class="space-y-1 sm:space-y-1.5">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-heading font-extrabold text-white tracking-tight drop-shadow-sm">
                        Halo, {{ $customer->name }}! 👋
                    </h1>

                    <!-- Mobile-Only Membership Tenure Subtitle -->
                    @if($customer->berlangganan_sejak !== '-')
                        <div class="sm:hidden flex items-center gap-1.5 text-xs text-cyan-300/90 font-medium pt-0.5">
                            <iconify-icon icon="solar:calendar-date-bold" class="text-cyan-400 text-xs shrink-0"></iconify-icon>
                            <span>Sejak {{ $customer->berlangganan_sejak }}</span>
                            <span class="text-white/30">•</span>
                            <span class="text-emerald-300 font-mono font-semibold">{{ $customer->subscription_duration_text }}</span>
                        </div>
                    @endif
                    
                    <p class="text-xs sm:text-sm text-slate-300/85 max-w-xl leading-relaxed">
                        Pantau performa koneksi internet broadband dan rincian layanan Anda secara real-time.
                    </p>
                </div>

                <!-- Right: High-Impact Action CTAs (Side by Side on Mobile & Symmetrical) -->
                <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-2.5 shrink-0 pt-0.5 lg:pt-0">
                    <!-- Primary CTA: Lapor Gangguan -->
                    <a href="{{ route('portal.tickets.create') }}" class="h-10 sm:h-11 inline-flex items-center justify-center gap-1.5 px-3 sm:px-4 rounded-xl bg-gradient-to-r from-sky-500 via-sky-600 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-heading font-bold text-xs sm:text-sm shadow-md shadow-sky-500/25 hover:shadow-sky-500/35 active:scale-95 transition-all text-center whitespace-nowrap">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-amber-300 text-sm sm:text-base shrink-0"></iconify-icon>
                        <span>Lapor Gangguan</span>
                    </a>

                    <!-- Secondary CTA: Upgrade Paket (Soon) -->
                    <div class="h-10 sm:h-11 inline-flex items-center justify-center gap-1.5 px-3 sm:px-4 rounded-xl bg-white/[0.08] hover:bg-white/[0.12] text-slate-200 border border-white/15 font-heading font-semibold text-xs sm:text-sm shadow-xs cursor-not-allowed select-none text-center whitespace-nowrap transition-all" title="Fitur Upgrade Paket segera hadir">
                        <iconify-icon icon="solar:round-transfer-vertical-bold" class="text-slate-400 text-sm sm:text-base shrink-0"></iconify-icon>
                        <span>Upgrade Paket</span>
                        <span class="px-1.5 py-0.5 rounded-md bg-amber-400/20 border border-amber-300/30 text-amber-300 text-[8.5px] font-mono font-bold tracking-wider uppercase">SOON</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Status 4 KPI Cards Grid (Compact 2x2 on Mobile, 4 Cols on Desktop - Mockup Style) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3.5 items-stretch">
        
        <!-- Card 1: Paket Layanan (Blue) -->
        <div id="tour-step-package" class="kpi-stat-card kpi-blue group flex flex-col justify-between">
            <div>
                <!-- Top Row: Circle Icon & Status Badge -->
                <div class="flex items-center justify-between gap-1.5 h-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#2563eb] text-white flex items-center justify-center shadow-md shadow-blue-500/20 shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12.55a11 11 0 0 1 14.08 0"/>
                            <path d="M1.42 9a16 16 0 0 1 21.16 0"/>
                            <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/>
                            <line x1="12" y1="20" x2="12.01" y2="20" stroke-width="3"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10.5px] sm:text-[11px] font-semibold shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Aktif</span>
                    </span>
                </div>

                <!-- Label & Speed Value -->
                <div class="mt-2.5">
                    <div class="text-[10px] sm:text-[11px] font-heading font-bold uppercase tracking-wider text-slate-400">
                        PAKET LAYANAN
                    </div>
                    @php
                        $rawSpeed = $customer->package->speed ?? '50 Mbps';
                        preg_match('/^([0-9]+)\s*(.*)$/', trim($rawSpeed), $speedMatches);
                        $speedNum = $speedMatches[1] ?? '50';
                        $speedUnit = !empty($speedMatches[2]) ? $speedMatches[2] : 'Mbps';
                    @endphp
                    <div class="h-8 sm:h-9 flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $speedNum }}</span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-500">{{ $speedUnit }}</span>
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 font-medium truncate mt-0.5" title="{{ $customer->package->name ?? 'Broadband Internet' }}">
                        {{ $customer->package->name ?? 'Broadband Internet' }}
                    </div>
                </div>
            </div>

            <!-- Footer: Flush tinted bar with arrow button -->
            <a href="{{ route('portal.profile') }}" class="kpi-stat-footer bg-[#eff6ff]/70 hover:bg-blue-100/70 border-[#dbeafe] group/link">
                <span class="text-xs font-heading font-bold text-[#2563eb]">Rincian</span>
                <div class="w-6 h-6 sm:w-6.5 sm:h-6.5 rounded-full bg-white border border-[#bfdbfe] flex items-center justify-center text-[#2563eb] shadow-2xs group-hover/link:scale-105 group-hover/link:border-blue-400 transition-all">
                    <iconify-icon icon="solar:arrow-right-linear" class="text-xs sm:text-sm"></iconify-icon>
                </div>
            </a>
        </div>

        <!-- Card 2: Status Tagihan (Green) -->
        <div id="tour-step-billing" class="kpi-stat-card kpi-green group flex flex-col justify-between">
            <div>
                <!-- Top Row: Circle Icon & Status Badge -->
                <div class="flex items-center justify-between gap-1.5 h-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#059669] text-white flex items-center justify-center shadow-md shadow-emerald-500/20 shrink-0">
                        <iconify-icon icon="solar:card-2-bold" class="text-lg sm:text-xl text-white"></iconify-icon>
                    </div>
                    @if($customer->billing_status === 'paid')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10.5px] sm:text-[11px] font-semibold shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Lunas</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10.5px] sm:text-[11px] font-semibold shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>Menunggu</span>
                        </span>
                    @endif
                </div>

                <!-- Label & Amount -->
                <div class="mt-2.5">
                    <div class="text-[10px] sm:text-[11px] font-heading font-bold uppercase tracking-wider text-slate-400">
                        STATUS TAGIHAN
                    </div>
                    <div class="h-8 sm:h-9 flex items-baseline gap-1 mt-0.5">
                        <span class="text-xs sm:text-sm font-bold text-slate-600">Rp</span>
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none truncate">
                            {{ number_format($customer->billing_amount, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 font-medium truncate mt-0.5">
                        Tempo: Tgl {{ $customer->due_date ?? '1' }}/bln
                    </div>
                </div>
            </div>

            <!-- Footer: Flush tinted bar with arrow button -->
            <a href="{{ route('portal.billing.index') }}" class="kpi-stat-footer bg-[#f0fdf4]/70 hover:bg-emerald-100/70 border-[#d1fae5] group/link">
                <span class="text-xs font-heading font-bold text-[#059669]">
                    {{ $customer->billing_status === 'paid' ? 'Rincian' : 'Bayar' }}
                </span>
                <div class="w-6 h-6 sm:w-6.5 sm:h-6.5 rounded-full bg-white border border-[#bbf7d0] flex items-center justify-center text-[#059669] shadow-2xs group-hover/link:scale-105 group-hover/link:border-emerald-400 transition-all">
                    <iconify-icon icon="solar:arrow-right-linear" class="text-xs sm:text-sm"></iconify-icon>
                </div>
            </a>
        </div>

        <!-- Card 3: Tiket Bantuan (Orange/Amber) -->
        <div id="tour-step-tickets" class="kpi-stat-card kpi-orange group flex flex-col justify-between">
            <div>
                <!-- Top Row: Circle Icon & Resolved Badge -->
                <div class="flex items-center justify-between gap-1.5 h-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#d97706] text-white flex items-center justify-center shadow-md shadow-amber-500/20 shrink-0">
                        <iconify-icon icon="solar:headphones-round-sound-bold" class="text-lg sm:text-xl text-white"></iconify-icon>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10.5px] sm:text-[11px] font-semibold shrink-0">
                        <iconify-icon icon="solar:check-read-linear" class="text-slate-700 text-xs"></iconify-icon>
                        <span>Selesai: {{ $resolvedTicketsCount }}</span>
                    </span>
                </div>

                <!-- Label & Active Tickets -->
                <div class="mt-2.5">
                    <div class="text-[10px] sm:text-[11px] font-heading font-bold uppercase tracking-wider text-slate-400">
                        TIKET BANTUAN
                    </div>
                    <div class="h-8 sm:h-9 flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-none">
                            {{ $activeTicketsCount }}
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-500">Laporan</span>
                    </div>
                    <div class="text-[11px] sm:text-xs font-medium truncate mt-0.5 {{ $activeTicketsCount > 0 ? 'text-amber-600 font-semibold' : 'text-slate-500' }}">
                        {{ $activeTicketsCount > 0 ? 'Sedang Ditangani NOC' : 'Jaringan Normal & Stabil' }}
                    </div>
                </div>
            </div>

            <!-- Footer: Flush tinted bar with arrow button -->
            <a href="{{ route('portal.tickets.index') }}" class="kpi-stat-footer bg-[#fffbeb]/70 hover:bg-amber-100/70 border-[#fef3c7] group/link">
                <span class="text-xs font-heading font-bold text-[#d97706]">Lihat</span>
                <div class="w-6 h-6 sm:w-6.5 sm:h-6.5 rounded-full bg-white border border-[#fed7aa] flex items-center justify-center text-[#d97706] shadow-2xs group-hover/link:scale-105 group-hover/link:border-amber-400 transition-all">
                    <iconify-icon icon="solar:arrow-right-linear" class="text-xs sm:text-sm"></iconify-icon>
                </div>
            </a>
        </div>

        <!-- Card 4: Lokasi Layanan (Purple) -->
        <div class="kpi-stat-card kpi-violet group flex flex-col justify-between">
            <div>
                <!-- Top Row: Circle Icon & Registered Badge -->
                <div class="flex items-center justify-between gap-1.5 h-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#7c3aed] text-white flex items-center justify-center shadow-md shadow-purple-500/20 shrink-0">
                        <iconify-icon icon="solar:map-point-bold" class="text-lg sm:text-xl text-white"></iconify-icon>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 text-[10.5px] sm:text-[11px] font-semibold shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                        <span>Terdaftar</span>
                    </span>
                </div>

                <!-- Label & Address -->
                <div class="mt-2.5">
                    <div class="text-[10px] sm:text-[11px] font-heading font-bold uppercase tracking-wider text-slate-400">
                        LOKASI LAYANAN
                    </div>
                    <div class="h-8 sm:h-9 flex items-center mt-0.5">
                        <span class="text-[13px] sm:text-sm font-black text-slate-900 tracking-tight leading-snug line-clamp-2" title="{{ $customer->address ?: 'Alamat belum tercatat di sistem' }}">
                            {{ $customer->address ?: 'Alamat Terdaftar' }}
                        </span>
                    </div>
                    <div class="text-[11px] sm:text-xs text-slate-500 font-medium truncate mt-0.5">
                        {{ $customer->city ?? 'Area Layanan FTTH' }}
                    </div>
                </div>
            </div>

            <!-- Footer: Flush tinted bar with arrow button -->
            <a href="{{ route('portal.profile') }}" class="kpi-stat-footer bg-[#faf5ff]/70 hover:bg-purple-100/70 border-[#f3e8ff] group/link">
                <span class="text-xs font-heading font-bold text-[#7c3aed]">Detail</span>
                <div class="w-6 h-6 sm:w-6.5 sm:h-6.5 rounded-full bg-white border border-[#e9d5ff] flex items-center justify-center text-[#7c3aed] shadow-2xs group-hover/link:scale-105 group-hover/link:border-purple-400 transition-all">
                    <iconify-icon icon="solar:arrow-right-linear" class="text-xs sm:text-sm"></iconify-icon>
                </div>
            </a>
        </div>

    </div>

    <!-- Main Content Section: Recent Tickets & Diagnostics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3.5 sm:gap-5">
        
        <!-- Left 2 Cols: Recent Trouble Tickets -->
        <div class="lg:col-span-2 space-y-2.5 sm:space-y-4">
            <div class="flex items-center justify-between px-0.5">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                        <iconify-icon icon="solar:ticket-sale-bold" class="text-sm sm:text-base"></iconify-icon>
                    </div>
                    <h2 class="text-sm sm:text-base lg:text-lg font-heading font-bold text-slate-900">Riwayat Laporan Kendala</h2>
                </div>
                <a href="{{ route('portal.tickets.index') }}" class="text-[11px] sm:text-xs font-heading font-semibold text-sky-600 hover:text-sky-700 hover:underline flex items-center gap-0.5">
                    <span>Lihat Semua</span>
                    <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                </a>
            </div>

            @if($recentTickets->count() > 0)
                <div class="space-y-2.5 sm:space-y-3">
                    @foreach($recentTickets as $ticket)
                        <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-4 lg:p-5 flex flex-col justify-between gap-2.5 overflow-hidden">
                            <!-- Top Header: Ticket Number (Left) & Status Badge (Right) -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] sm:text-xs font-mono font-bold text-sky-700 bg-sky-50 border border-sky-200/80 px-2 py-0.5 rounded-md truncate">
                                    #{{ $ticket->ticket_number }}
                                </span>
                                <span class="text-[10px] sm:text-[11px] font-sans px-2.5 py-0.5 rounded-full {{ $ticket->status_badge_class }} font-semibold shrink-0">
                                    {{ $ticket->status_label }}
                                </span>
                            </div>

                            <!-- Middle Body: Subject & Description -->
                            <div class="space-y-0.5 min-w-0">
                                <h3 class="text-xs sm:text-sm lg:text-base font-heading font-bold text-slate-900 truncate">
                                    {{ $ticket->subject }}
                                </h3>
                                <p class="text-[11px] sm:text-xs text-slate-500 line-clamp-1">
                                    {{ $ticket->description }}
                                </p>
                            </div>

                            <!-- Bottom Footer: Category + Time (Left) & Action Button (Right) -->
                            <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100 text-[11px]">
                                <div class="flex items-center gap-1.5 text-slate-500 min-w-0 truncate">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border border-slate-200/70 font-medium text-[10px] shrink-0">
                                        {{ $ticket->category_label }}
                                    </span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-[10px] text-slate-400 font-mono truncate">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    @if($ticket->technician_name)
                                        <span class="hidden sm:inline text-[11px] text-slate-500">
                                            Teknisi: <strong class="text-slate-700">{{ $ticket->technician_name }}</strong>
                                        </span>
                                    @endif
                                    <a href="{{ route('portal.tickets.show', $ticket->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-600 text-slate-600 hover:text-white text-[11px] font-heading font-semibold transition-all active:scale-95" title="Lihat detail laporan kendala">
                                        <span>Detail</span>
                                        <iconify-icon icon="solar:arrow-right-linear" class="text-xs"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="portal-card rounded-xl sm:rounded-2xl p-5 sm:p-8 text-center space-y-2.5">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 mx-auto flex items-center justify-center shadow-xs">
                        <iconify-icon icon="solar:check-circle-bold" class="text-2xl sm:text-3xl"></iconify-icon>
                    </div>
                    <div class="text-sm sm:text-base font-heading font-bold text-slate-900">Tidak Ada Laporan Gangguan Aktif</div>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Koneksi internet Anda beroperasi normal. Jika Anda mengalami kendala teknis, silakan buat laporan ke tim NOC.
                    </p>
                    <div class="pt-1.5">
                        <a href="{{ route('portal.tickets.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-xs font-heading font-bold shadow-xs transition-all">
                            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Speedtest & Quick Diagnostics -->
        <div id="tour-step-help" class="space-y-2.5 sm:space-y-4">
            
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:settings-bold" class="text-sm sm:text-base"></iconify-icon>
                </div>
                <h2 class="text-sm sm:text-base lg:text-lg font-heading font-bold text-slate-900">Diagnostik & Panduan</h2>
            </div>

            <!-- Speedtest Box -->
            <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-5 space-y-2.5 sm:space-y-3">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-lg sm:text-xl"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-heading font-bold text-slate-900">Uji Kecepatan Internet</div>
                        <div class="text-[11px] sm:text-xs text-slate-500">Cek speed download & upload</div>
                    </div>
                </div>
                <a href="https://fast.com" target="_blank" class="w-full py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl bg-slate-50/80 hover:bg-sky-50 border border-slate-200 text-xs font-heading font-bold text-slate-700 hover:text-sky-700 transition-all flex items-center justify-center gap-1.5 shadow-2xs">
                    <iconify-icon icon="solar:play-circle-bold" class="text-sky-500" width="16"></iconify-icon>
                    <span>Buka Fast.com Speedtest</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-5 space-y-2.5 sm:space-y-3">
                <div class="text-xs font-heading font-bold text-slate-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:lightbulb-bolt-bold" class="text-amber-500 text-sm sm:text-base"></iconify-icon>
                    <span>Langkah Cepat Penanganan:</span>
                </div>
                
                <div class="space-y-2 text-xs">
                    <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-0.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px] sm:text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>1. Lampu LOS Modem Merah</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3 leading-relaxed">
                            Kabel patchcord fiber optic terlipat atau putus. Jangan ditarik paksa, segera laporkan ke tim teknisi NOC.
                        </p>
                    </div>

                    <div class="p-2.5 sm:p-3 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-0.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5 text-[11px] sm:text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>2. WiFi "No Internet"</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 pl-3 leading-relaxed">
                            Matikan tombol power modem ONT selama 30 detik lalu hidupkan kembali (Power Cycle) agar IP router tersegarkan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Contact Box -->
            <div class="portal-card rounded-xl sm:rounded-2xl p-3.5 sm:p-5 bg-gradient-to-br from-emerald-50/80 to-teal-50/50 border-emerald-200/80 space-y-2">
                <div class="text-xs font-heading font-bold text-emerald-900 flex items-center gap-1.5">
                    <iconify-icon icon="solar:headphones-round-sound-bold" class="text-emerald-600 text-sm sm:text-base"></iconify-icon>
                    <span>Bantuan Cepat NOC 24 Jam</span>
                </div>
                <p class="text-[11px] sm:text-xs text-emerald-800 leading-relaxed">
                    Tim NOC siap siaga melayani konsultasi dan penanganan teknis Anda.
                </p>
                <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text=Halo%20NOC%20PT%20MSN,%20saya%20pelanggan%20ID%20{{ $customer->customer_id }}%20membutuhkan%20bantuan%20teknis" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs transition-all flex items-center justify-center gap-2 shadow-xs">
                    <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                    <span>WhatsApp NOC</span>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
