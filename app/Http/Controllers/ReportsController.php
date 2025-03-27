<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportsController extends Controller
{
    public function getTotalAthleteInEventWithPrice()
    {
        $federation_id = request()->federation_id;
        $association_id = request()->association_id;

        $query = 'SELECT 
                    COUNT(i.athlete_id) AS total_atletas_inscriptos, 
                    SUM(ti.price) AS total_ganancia,
                    ec.name AS categoria,
                    e.description AS evento
                FROM inscriptions i 
                JOIN tariff_inscriptions ti ON i.tariff_inscription_id = ti.id 
                JOIN entry_categories ec ON ti.entry_category_id = ec.id
                JOIN events e ON i.event_id = e.id
                WHERE i.status = ? AND e.federation_id = ?';

        $params = ["pagado", $federation_id];

        if (!empty($association_id)) {
            $query .= ' AND e.association_id = ?';
            $params[] = $association_id;
        }

        $query .= ' GROUP BY categoria, evento';

        $data = DB::select($query, $params);

        return response()->json($data);
    }

    public function getTotalAthleteInEvent()
    {
        $federation_id = request()->federation_id;
        $association_id = request()->association_id;
        
        $query = 'SELECT 
                    COUNT(i.athlete_id) AS total_atletas_inscriptos,
                    e.description AS evento
                  FROM events e 
                  JOIN inscriptions i ON i.event_id = e.id 
                  WHERE e.federation_id = ?';
        
        $params = [$federation_id];
        
        if (!empty($association_id)) {
            $query .= ' AND e.association_id = ?';
            $params[] = $association_id;
        }
        
        $query .= ' GROUP BY evento';
        
        $data = DB::select($query, $params);
        
        return response()->json($data);
    }


}
