<?php
namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::orderBy('name')->get();
        return view('pages.airlines', ['airlines' => $airlines]);
    }
}