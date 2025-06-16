<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        // Logika query tetap sama seperti sebelumnya
        $direction = $request->input('direction', 'departure');
        
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $globalSearchResult = Flight::query()
                ->where(fn($q) => $q->where('flight_number', 'like', $searchTerm)->orWhere('city', 'like', $searchTerm)->orWhereHas('airline', fn($aq) => $aq->where('name', 'like', $searchTerm)))
                ->first();
            if ($globalSearchResult) {
                $direction = $globalSearchResult->direction;
            }
        }

        $query = Flight::query()->with('airline')->where('direction', 'like', $direction);

        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = '%' . $request->input('search') . '%';
            $q->where(fn($sq) => $sq->where('flight_number', 'like', $searchTerm)->orWhere('city', 'like', $searchTerm)->orWhereHas('airline', fn($aq) => $aq->where('name', 'like', $searchTerm)));
        });

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->input('status'));
        });

        $flights = $query->orderBy('scheduled_time', 'asc')->paginate(15);

        // --- INI PERUBAHANNYA ---
        // Jika permintaan adalah AJAX, kirim hanya bagian tabelnya saja.
        if ($request->ajax()) {
            return view('partials.flights-table', [
                'flights' => $flights,
                'direction' => $direction,
            ])->render(); // .render() mengubah Blade menjadi string HTML
        }

        // Jika bukan, kirim halaman lengkap seperti biasa.
        return view('pages.flights', [
            'flights' => $flights,
            'direction' => $direction,
            'filters' => $request->only(['search', 'status']),
        ]);
    }
}
