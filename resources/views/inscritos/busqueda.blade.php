@extends('layouts.layout')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
@endpush
@section('content')

{{-- fondo --}}
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   Busqueda de Certificados
                </div>
                {{-- formulario --}}
                <div class="container mt-4 ml-4">
                    <form class="form-inline" id="form-agregar-usuario">
                    @csrf
                        <div class="form-group mb-2">
                            <label >Ingrese Número de DNI:</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            {{-- <label for="inputPassword2" class="sr-only">Password</label> --}}
                            <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                    </form>
                
                </div>
                
                {{-- tabla resultado --}}
            </div>
            <br>
            <div id="tablas"> 
                <div class="card">
                    <div class="card-header">
                        Resultado de Busqueda
                    </div>
                    <div class="card-body">
                        <table width="100%"
                            class="table table-responsive table-bordered nowrap"
                            cellspacing="0"
                            id="afiliado-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ __("Nombres") }}</th>
                                    <th>{{ __("Apellidos") }}</th>
                                    <th>{{ __("DNI") }}</th>
                                    <th>{{ __("teléfono") }}</th>
                                    <th>{{ __("email") }}</th>
                                    <th>{{ __("Curso") }}</th>
                                    <th>{{ __("Certificado") }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- footer --}}
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script>
    jQuery(document).ready(function() {
            $("#tablas").hide();
        
            $('#form-agregar-usuario').submit(function(e){

                e.preventDefault();
                //spinner.show();
                // let data = $(this).serialize();
                var formDerivar = document.getElementById("form-agregar-usuario");
                let data = new FormData(formDerivar);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url:'busqueda',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        dt = jQuery("#afiliado-table").DataTable({
                        pageLength: 15,
                        lengthMenu: [15, 25, 50, 75, 100 ],
                        processing: true,
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        ajax: 'getinscritos/'+data.dni,
                        language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                        },
                        columns: [
                        // {data: 'id'},
                        {data: 'nombres'},
                        {data: 'apellidos'},
                        {data: 'dni'},
                        {data: 'celular'},
                        {data: 'email'},
                        {data: 'curso'},
                        {data: 'Opciones'}
                        ],
                        rowCallback:function(row, data,index){

                        $('td:eq(6)',row).html('<a class="editar-usuario" target="_blank" href="storage/'+data.url_certificado+'"> <i class="fas fa-file-alt big-icon text-primary" aria-hidden="true"></i></a> ')
                        }

                        });
                        $("#tablas").show();
                    },
                    error: function(error) {
                        toastr.error(error, '¡Error!', {timeOut: 5000})
                        $("#tablas").hide();
                    }
                });
            });
    });
</script>
@endpush
