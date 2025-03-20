<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Federation;
use App\Models\Event;
use App\Models\News;
use App\Models\MatchBracket;
use App\Models\Bracket;
use App\Models\TariffInscription;
use App\Models\EntryCategory;
use App\Models\Athlete;
use App\Models\Ranking;
use Carbon\Carbon;

class OrganizationController extends Controller
{
    public function federations()
    {
        try {
            $data = Federation::where('status', true)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function federation($federation_id)
    {
        try {
            $data = Federation::where('status', true)
                ->findOrFail($federation_id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function events($federation_id)
    {
        try {
            $data = Event::with('federation', 'association', 'status_event', 'type_event', 'location.city.country', 'media_event')
                ->where('federation_id', $federation_id)
                ->whereHas('status_event', function ($query) {
                    $query->where('description', 'En curso')->orWhere('description', 'Finalizado');
                })
                ->orderBy('initial_date', 'desc')
                ->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function event_detail($event_id)
    {
        try {
            $data = Event::with('media_event', 'location.city.country', 'federation', 'association', 'status_event', 'type_event', 'entry_category')
                ->findOrFail($event_id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function news($federation_id)
    {
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

    public function new_detail($new_id)
    {
        try {
            $data = News::with('category_new', 'media_new_detail')
                ->findOrFail($new_id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function matchBrackets(Request $request, $event_id)
    {
        try {
            $data = MatchBracket::with('bracket', 'athleteOne.academy', 'athleteTwo.academy', 'typeVictory', 'entry_category')
                ->where('event_id', $event_id)
                ->where('entry_category_id', $request->input('entry_category_id'))
                ->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function groupBrackets(Request $request, $event_id)
    {
        try {
            $data = MatchBracket::groupBrackets($event_id, $request->input('entry_category_id'));
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function athletesInscription($event_id)
    {
        try {
            $data = TariffInscription::with('entry_category', 'inscriptions.athlete')
                ->get()
                ->where('entry_category.event_id', $event_id)
                ->groupBy(['entry_category.minor_category', 'entry_category.gender', 'entry_category.belt.color', 'entry_category.name'])
                ->sortByDesc('belt.color');
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function schedules($event_id)
    {
        try {
            // $data = MatchBracket::with('entry_category')
            //     ->get()
            //     ->where('entry_category.event_id', $event_id)
            //     ->groupBy(['quadrilateral']);
            $data = EntryCategory::where('event_id', $event_id)
                ->get()
                ->groupBy(['minor_category', 'gender', 'name']);

            // $data = MatchBracket::with('bracket', 'athleteOne', 'athleteTwo', '')
            //     ->where('event_id', $event_id)
            //     ->get();  

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getAthleteWinMedalsInformation()
    {
        try {
            $athletes = Athlete::getAthleteWinLoseInformation();
            return response()->json($athletes, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteWinLoseDifference()
    {
        try {
            $athletes = Athlete::getAthleteWinLoseDifference();
            return response()->json($athletes, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteMostActive()
    {
        try {
            $athletes = Athlete::getAthleteMostActive();
            return response()->json($athletes, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteProfileWinLose($id)
    {
        try {
            $athlete = Athlete::getAthleteProfileWinLose($id);
            return response()->json($athlete, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteEventMatchWinLoseInformation($athlete_id)
    {
        try {
            $matchbracketdetail = Athlete::getAthleteEventMatchWinLoseInformation($athlete_id);
            return response()->json($matchbracketdetail, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteRanking(Request $request)
    {
        try {

            $rankings = EntryCategory::with([
                'belt',
                'ranking.athlete',
                'ranking'
            ])
                ->where('event_id', $request->input('event_id'))
                ->get();

            return response()->json($rankings, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function pastEvents($federation_id)
    {
        try {
            $data = Event::with('federation', 'association', 'status_event', 'type_event')
                ->where('federation_id', $federation_id)
                ->latest('id')
                ->take(5)
                ->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getAthleteAllProfile($athlete_id)
    {
        $athlete = Athlete::with([
            'country',
            'belt',
            'inscriptions.event',
            'inscriptions.tariff_inscription.entry_category.matchBracket' => function ($query) use ($athlete_id) {
                $query->where(function ($q) use ($athlete_id) {
                    $q->where('one_athlete_id', $athlete_id)
                      ->orWhere('two_athlete_id', $athlete_id);
                });
            },                
            'inscriptions.tariff_inscription.entry_category.matchBracket.bracket',
            'inscriptions.tariff_inscription.entry_category.matchBracket.typeVictory',
            'inscriptions.tariff_inscription.entry_category.matchBracket.athleteOne',
            'inscriptions.tariff_inscription.entry_category.matchBracket.athleteTwo',
            'inscriptions.tariff_inscription.entry_category.matchBracket.athleteWinner',
            'inscriptions.tariff_inscription.entry_category.matchBracket.athleteLoser'
        ])
            ->where('id', $athlete_id)
            ->firstOrFail();


        return [
            'name' => $athlete->name,
            'gender' => $athlete->gender,
            'birthdate' => $athlete->birthdate,
            'profile_image' => $athlete->profile_image,
            'country' => $athlete->country->description,
            'belt' => $athlete->belt->color,
            'inscriptions' => $athlete->inscriptions->map(function ($inscription) {
                return [
                    'event' => [
                        'description' => $inscription->event->description,
                        'initial_date' => Carbon::parse($inscription->event->initial_date)->format('d-m-Y'),
                        'entry_category' => [
                            'name' => $inscription->tariff_inscription->entry_category->name,
                            'min_age' => $inscription->tariff_inscription->entry_category->min_age,
                            'max_age' => $inscription->tariff_inscription->entry_category->max_age,
                            'min_weight' => $inscription->tariff_inscription->entry_category->min_weight,
                            'max_weight' => $inscription->tariff_inscription->entry_category->max_weight,
                            'gender' => $inscription->tariff_inscription->entry_category->gender,
                            'clothes' => $inscription->tariff_inscription->entry_category->clothes,
                            // 'match_brackets' => $inscription->tariff_inscription->entry_category->matchBracket,
                            'match_bracket' => $inscription->tariff_inscription->entry_category->matchBracket->map(function ($matchBracket) {
                                return [
                                    'athlete_winner' => $matchBracket->athleteWinner->name ?? null,
                                    'athlete_loser' => $matchBracket->athleteLoser->name ?? null,
                                    'match_time' => $matchBracket->match_time,
                                    'match_date' => $matchBracket->match_date,
                                    'score_one_athlete' => $matchBracket->score_one_athlete,
                                    'score_two_athlete' => $matchBracket->score_two_athlete,
                                    'athlete_id_winner' => $matchBracket->athlete_id_winner,
                                    'athlete_id_loser' => $matchBracket->athlete_id_loser,
                                    'bracket' => [
                                        'phase' => $matchBracket->bracket->phase,
                                        'status' => $matchBracket->bracket->status,
                                        // 'type_victory' => $matchBracket->bracket->type_victory,
                                        // 'athlete_id_loser' => $matchBracket->athlete_id_loser,
                                      
                                        // 'athlete_loser' => $matchBracket->bracket->athleteLose->name
                                        // 'athlete_winner' => [
                                            // 'name' => $matchBracket->bracket->athleteWinner->name
                                        // ],
                                        // 'athlete_loser' => [
                                            // 'name' => $matchBracket->bracket->athleteLoser->name
                                        // ]
                                    ]
                                ];
                            })
                        ]
                    ]
                ];
            })
        ];
    }
}
