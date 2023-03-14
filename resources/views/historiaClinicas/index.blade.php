@extends('temas.tema_dashboard')

@section('contenido')
<h1 class="mt-4">Historias Clinicas</h1>
@if ($rol_id == 1 || $rol_id == 2)
<div class="my-3" style="text-align:center;">
    <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success">Agregar</a>
</div>
@endif
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Paciente</th>
                <th scope="col">Diagnóstico</th>
                <th scope="col">Tratamiento</th>
                @if ($rol_id == 1 || $rol_id == 2)
                <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            @foreach ($historiasCli as $key => $historiaCli)
            @if ($user->id == $historiaCli->user_id)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name }} {{ $user->lastname }}</td>
                <td>{{ $historiaCli->diagnosis }}</td>
                <td>{{ $historiaCli->treatment	 }}</td>
                <td>
                    @if ($rol_id == 1 || $rol_id == 2)
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal2{{$key}}" class="btn btn-outline-warning">Editar</a>
                    @endif
                </td>
            </tr>

            {{-- MODAL EDITAR HISTORIAS --}}
            <div class="modal fade" id="exampleModal2{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('historia.update', $historiaCli->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel2">Editar Historia</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($user->id == $historiaCli->user_id)
                                <input type="text" name="user_id" class="form-control" value="{{ $user->name }} {{ $user->lastname }}" disabled>
                                @endif
                                <textarea name="diagnosis" rows="4" class="form-control  my-3" placeholder="Diagnóstico...">{{$historiaCli->diagnosis}}</textarea>
                                <textarea name="treatment" rows="4" class="form-control  my-3" placeholder="Tratamiento...">{{$historiaCli->treatment}}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endif
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL AGREGAR HISTORIAS --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('historia.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos de la historia Clínica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <input type="numeric" name="user_id" class="form-control" placeholder="Identificador Usuarios"> -->
                    <select name="user_id" class="form-select">
                        <option value="">Selecciona paciente...</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                        @endforeach
                    </select>
                    <textarea name="diagnosis" rows="4" class="form-control  my-3" placeholder="Diagnóstico..."></textarea>
                    <textarea name="treatment" rows="4" class="form-control  my-3" placeholder="Tratamiento..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection