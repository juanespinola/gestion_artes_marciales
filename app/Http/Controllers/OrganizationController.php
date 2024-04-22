<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Federation;

class OrganizationController extends Controller
{
    public function federations() {
        try {
            $data = Federation::all();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
