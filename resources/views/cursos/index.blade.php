@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cursos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Dashboard Content</h3>
                            @can('crear-cursos')
                                <a href="{{ route('cursos.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan

                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display:none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">Descripcion</th>
                                    <th style="color:#fff;">Estado</th>
                                    <th style="color:#fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($cursos as $usuario)
                                        <tr>
                                            <td style="display:none;">{{ $usuario->id }}</td>
                                            <td>{{ $usuario->nombre }}</td>
                                            <td>{{ $usuario->descripcion }}</td>
                                            <td>
                                               {{ $usuario->estado  }}
                                            </td>
                                            <td>
                                                <a class="btn btn-info" href="{{ route('cursos.edit',$usuario->id) }}">Editar</a>
                                        
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['cursos.destroy',$usuario->id],'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close()  !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $cursos->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

