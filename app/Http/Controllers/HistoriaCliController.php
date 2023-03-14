<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia_Clinica;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

$user = "";

class HistoriaCliController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener la instancia del modelo de usuario actualmente autenticado
        $rol_id = $user->rol_id; // Acceder a la propiedad rol_id del modelo de usuario

        if ($rol_id == 1 || $rol_id == 2) {
            $historiasCli = Historia_clinica::all();
        } else {
            $historiasCli = Historia_clinica::where('user_id', '=', $user->id)->get();
        }
        $users = User::where('rol_id', '=', 3)->get(); // a cambiar, traer usuario con rol de pacientes(3)


        return view('historiaClinicas.index', compact('historiasCli', 'users', 'rol_id'));
    }

    public function store(Request $request)
    {
        // dd($request);
        Historia_clinica::create([
            'user_id' => $request->user_id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $historiaCli = Historia_Clinica::find($id);

        $historiaCli->update([
            "diagnosis" => $request->diagnosis,
            "treatment" => $request->treatment,
        ]);

        return back();
    }
}
