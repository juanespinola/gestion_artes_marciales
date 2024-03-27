<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                // $userRoles = auth()->user()->getRoleNames(); // Obtener roles del usuario autenticado
                // $userPermision = auth()->user()->getPermissionsViaRoles();

                // return response()->json(['menu' => $menuItems]);
                
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        // return response()->json('prueba', 200);
    }
}
