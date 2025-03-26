<?php


namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Watchlist;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class ItineraryController extends Controller
{

    public function index() {
        return Itinerary::with('destinations')->get();
    }


    public function show($id) {
        return Itinerary::with('destinations')->findOrFail($id);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|integer',
            'image' => 'nullable|string',
            'destinations' => 'required|array|min:2',
            'destinations.*.name' => 'required|string',
            'destinations.*.lodging' => 'required|string',
            'destinations.*.places_to_visit' => 'required|array|min:1',
            'destinations.*.activities' => 'required|array|min:1',
            'destinations.*.foods_to_try' => 'required|array|min:1',
        ]);

        $data['user_id'] = $request->user()->id;
        $itinerary = Itinerary::create($data);

        foreach ($data['destinations'] as $destination) {
            Destination::create(array_merge($destination, ['itinerary_id' => $itinerary->id]));
        }

        return response()->json($itinerary->load('destinations'), 201);
    }


    public function update(Request $request, $id) {
        $itinerary = Itinerary::where('user_id', $request->user()->id)->findOrFail($id);
        $itinerary->update($request->all());

        return response()->json($itinerary);
    }


    public function destroy(Request $request, $id) {
        $itinerary = Itinerary::where('user_id', $request->user()->id)->findOrFail($id);
        $itinerary->delete();

        return response()->json(['message' => 'Itinerary deleted']);
    }


    public function search(Request $request) {
        $query = Itinerary::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('duration')) {
            $query->where('duration', '<=', $request->duration);
        }

        if ($request->has('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        return $query->with('destinations')->get();
    }

    public function addWatchlist($id){

        $watchlist = DB::table('watchlists')->where('user_id',Auth::user()->id)->where('itinerary_id',$id)->get();

        if(Count($watchlist) > 0){
            return response()->json([
                'message' => "already added to watchlist"
            ],403);
        }

        Watchlist::create([
            'user_id' => Auth::user()->id,
            'itinerary_id' => $id
        ]);

        return response()->json([
            "message" => "Added successfuly to watchlist"
        ],200);
    }

    public function getWatchlist(){
        return Watchlist::all();
    }
}
