<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Federation;
use App\Models\Event;
use App\Models\News;
use App\Models\MatchBracket;
use App\Models\Bracket;
use App\Models\TariffInscription;

class OrganizationController extends Controller
{
    public function federations() {
        try {
            $data = Federation::where('status', true)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function federation($federation_id) {
        try {
            $data = Federation::where('status', true)
                ->findOrFail($federation_id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function events($federation_id) {
        try {
            $data = Event::with('federation', 'association', 'status_event', 'type_event')
                ->where('federation_id', $federation_id)
                ->orderBy('initial_date', 'desc')
                ->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function event_detail($event_id) {
        try {
            $data = Event::with('media_event', 'location', 'federation', 'association')->findOrFail($event_id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function news($federation_id) {
        try {
            $data = News::with('category_new', 'media_new_list')
                // ->where("status", "activo")
                ->where('federation_id', $federation_id)
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function new_detail($new_id) {
        try {
            $data = News::with('category_new', 'media_new_detail')
                ->findOrFail($new_id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function matchBrackets($event_id){
        try {
            $data = MatchBracket::with('bracket', 'athleteOne', 'athleteTwo','typeVictory')
                ->where('event_id', $event_id)
                ->get();    
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function groupBrackets($event_id) {
        try {
            $data = MatchBracket::groupBrackets($event_id);   
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function athletesInscription($event_id) {
        try {
            $data = TariffInscription::with('entry_category', 'inscriptions.athlete')
                ->get()
                ->where('entry_category.event_id', $event_id)
                ->groupBy(['entry_category.minor_category','entry_category.gender','entry_category.belt.color', 'entry_category.name'])
                ->sortByDesc('belt.color');   
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
