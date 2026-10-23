<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard ringkasan pelanggan
     */
    public function index()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->load(['pelanggan', 'bandwith', 'statusRegistrasi']);
        }

        $nomorInternet = $customer?->nomor_internet;

        // Cache ringkasan data dashboard selama 30 detik untuk navigasi cepat
        $cacheKey = "portal_dash_summary_{$nomorInternet}";
        $summary = \Illuminate\Support\Facades\Cache::remember($cacheKey, 30, function () use ($customer) {
            if (!$customer) {
                return [
                    'recentTickets' => collect([]),
                    'activeTicketsCount' => 0,
                    'resolvedTicketsCount' => 0,
                ];
            }

            // Ambil maksimal 5 record terbaru per kategori (bukan seluruh riwayat tahunan ke memory)
            $tickets = $customer->tickets()->take(5)->get();
            $ubah = $customer->ubahLayanan()->take(5)->get();
            $suspend = $customer->suspendLayanan()->take(5)->get();
            $terminasi = $customer->terminasiLayanan()->take(5)->get();

            $recentTickets = $tickets
                ->concat($ubah)
                ->concat($suspend)
                ->concat($terminasi)
                ->sortByDesc(function ($item) {
                    return $item->created_at ? $item->created_at->timestamp : 0;
                })->take(5)->values();

            // Hitung agregat langsung via SQL COUNT
            $activeTicketsCount = $customer->tickets()->whereIn('status', ['11', '12', 'open', 'in_progress', 'proses', 'antrian', 'konfirmasi'])->count()
                + $customer->ubahLayanan()->whereIn('status_ubah_layanan', ['11', '12', 'open', 'in_progress', 'proses'])->count()
                + $customer->suspendLayanan()->whereIn('status_suspend', ['11', '12', '18', 'open', 'in_progress'])->count()
                + $customer->terminasiLayanan()->whereIn('status_terminasi', ['11', '12', '12.1', '13', '15', 'open', 'in_progress'])->count();

            $resolvedTicketsCount = $customer->tickets()->whereIn('status', ['13', '14', 'resolved', 'done', 'close', 'closed'])->count()
                + $customer->ubahLayanan()->whereIn('status_ubah_layanan', ['13', '14', 'resolved', 'done'])->count()
                + $customer->suspendLayanan()->whereIn('status_suspend', ['13', '14', '16', 'resolved', 'done'])->count()
                + $customer->terminasiLayanan()->whereIn('status_terminasi', ['14', '16', 'resolved', 'done'])->count();

            return compact('recentTickets', 'activeTicketsCount', 'resolvedTicketsCount');
        });

        return view('portal.dashboard', array_merge(['customer' => $customer], $summary));
    }

    /**
     * Tandai tutorial onboarding telah diselesaikan oleh pelanggan (update is_login = 1)
     */
    public function completeOnboarding(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->markAsLoggedIn();
            \Illuminate\Support\Facades\Cache::put("portal_cust_is_login_{$customer->nomor_internet}", 1, 86400);
        }

        session(['is_first_login' => false]);
        session()->forget('is_first_login');

        return response()->json([
            'success' => true,
            'message' => 'Tutorial onboarding berhasil diselesaikan.',
            'is_login' => 1,
        ]);
    }
}
