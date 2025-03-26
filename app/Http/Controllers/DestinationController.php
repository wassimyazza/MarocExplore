<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    // Get all destinations for an itinerary
    public function index($itineraryId) {
        return Destination::where('itinerary_id', $itineraryId)->get();
    }

    // Add a destination to an itinerary
    public function store(Request $request, $itineraryId) {
        $request->validate([
            'name' => 'required|string',
            'lodging' => 'required|string',
            'places_to_visit' => 'required|array|min:1',
            'activities' => 'required|array|min:1',
            'foods_to_try' => 'required|array|min:1',
        ]);

        $itinerary = Itinerary::findOrFail($itineraryId);

        $destination = Destination::create([
            'itinerary_id' => $itinerary->id,
            'name' => $request->name,
            'lodging' => $request->lodging,
            'places_to_visit' => $request->places_to_visit,
            'activities' => $request->activities,
            'foods_to_try' => $request->foods_to_try,
        ]);

        return response()->json($destination, 201);
    }
}
