<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class CitasController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener la instancia del modelo de usuario actualmente autenticado
        $rol_id = $user->rol_id; // Acceder a la propiedad rol_id del modelo de usuario

        $horas = [[9, 10], [10, 11], [11, 12], [12, 13], [14, 15], [15, 16]];
        $doctores = User::where('rol_id', '=', 2)->get();        

        return view('citasMedicas.index', compact('horas', 'doctores', 'rol_id'));
    }

    public function show()
    {
        $all_events = Horario::all();
        $events = [];

        foreach ($all_events as $key => $event) {
            $title = "Cita #" . ($key + 1);
            $start_day = $event->day_hour . "T" . $event->startHour;
            $end_day = $event->day_hour . "T" . $event->EndHour;
            // si son disponibles
            if ($event->estado_id == 1) {
                $fondoColor = "#3788d8";
            } else {
                // si no son disponibles
                $fondoColor = "#ec3c51";
            }

            $events[] = [
                'title' => $title,
                'start' => $start_day,
                'end' => $end_day,
                'backgroundColor' => $fondoColor,
            ];
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        request()->validate(Horario::$rules);
        $inicio = Carbon::createFromFormat('H', $request->horario)->format('H:i:s');
        $fin = Carbon::createFromFormat('H', $request->horario + 1)->format('H:i:s');
        $date = Carbon::createFromFormat('Y-m-d', $request->dia);
        $date_string = $date->toDateString();

        $citas_date = Horario::where('day_hour', '=', $date_string)
            ->where('startHour', '=', $inicio)
            ->where('user_id', '=', $request->doctor)
            ->get();

        if ($citas_date->isEmpty()) {
            Horario::create([
                'estado_id' => 1,
                'user_id' => $request->doctor,
                'day_hour' => $date,
                'startHour' => $inicio,
                'EndHour' => $fin,
            ]);

            return redirect('citas')->with('status', 'La cita se ha agendado exitosamente');
        } else {
            return redirect('citas')->with('status', '¡Ya existe una cita con los datos seleccionados!');
        }
    }

    public function edit($id)
    {
        $cita = Horario::find($id);
        return response()->json($cita);
    }

    public function reservar($id)
    {
        $user = Auth::user(); // Obtener la instancia del modelo de usuario actualmente autenticado
        $cita = Horario::find($id);
        $cita->update([
            'estado_id' => 2,
            'id_paciente'=> $user->id,
            
        ]);
        return response()->json($cita);
    }

    public function cancelar($id)
    {
        $cita = Horario::find($id);
        $cita->update([
            'estado_id' => 1,
            'id_paciente'=> null,
        ]);
        return response()->json($cita);
    }
}
