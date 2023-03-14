@extends('temas.tema_dashboard')

@section('contenido')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<h1 class="mt-4">Citas Médicas</h1>
<div class="container">
    <div id="agenda">
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="cita" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" enctype="multipart/form-data" id="form-cita">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Citas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group d-none" id="divID">
                        <label for="id"># Cita</label>
                        <input type="text" name="id" id="id" class="form-control" value="" placeholder="ID" readonly>
                    </div>
                    <div class="form-group">
                        <label for="dia">Día</label>
                        <input type="text" name="dia" id="dia" class="form-control" value="12/03/2023" readonly>
                    </div>
                    <div class="form-group">
                        <label for="horario">Hora: Inicio - Fin</label>
                        <select class="form-control" name="horario" id="horario">
                            <option>Selecciona horario ...</option>
                            @foreach ($horas as list($inicio, $fin))
                            <option value="{{$inicio}}" id={{$inicio}}>{{$inicio}}:00 - {{$fin}}:00</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="doctor">Doctor</label>
                        <select class="form-control" name="doctor" id="doctor">
                            <option>Selecciona Doctor ...</option>
                            @foreach ($doctores as $doctor)
                            <option value="{{$doctor->id}}" id="{{$doctor->id}}">{{$doctor->name}} {{$doctor->lastname}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    @if ($rol_id == 1 || $rol_id == 2)
                    <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                    @endif
                    @if ($rol_id == 1 || $rol_id == 3)
                    <button type="button" class="btn btn-warning" id="btnReservar">Reservar</button>
                    @endif
                    @if ($rol_id == 1 || $rol_id == 3)
                    <button type="button" class="btn btn-danger" id="btnCancelar">Cancelar</button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection