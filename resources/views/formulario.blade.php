<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    
    <!-- Title Page-->
    <title>Au Register Forms by Colorlib</title>

    <!-- Icons font CSS-->
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('vendor/css/main.css') }}" rel="stylesheet" media="all">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Llene el Siguiente Formulario</h2>
                </div>
                <div class="card-body">
                    <form method="POST" id="form-agregar-usuario">
                        @csrf
                        <div class="form-row m-b-55">
                            <div class="name">Nombres:</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="nombres">
                                            <label class="label--desc">Nombres</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="apellidos">
                                            <label class="label--desc">Apellidos</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">DNI</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="dni">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Email</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="form-row m-b-55">
                            <div class="name">Celular</div>
                            <div class="value">
                                <div class="">
                                    <div class="col">
                                        <div class="input-group">
                                            <input class="input--style-5" type="text" name="celular">
                                            <label class="label--desc">Numero de Celular</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Curso</div>
                            <div class="value">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="id_curso">
                                            <option disabled="disabled" selected="selected">Seleccione...</option>
                                            @foreach ($cursos as $curso)
                                                <option  value='{{ $curso->id }}'>{{ $curso->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row p-t-20">
                            <label class="label label--block">Acepta los terminos?</label>
                            <div class="p-t-15">
                                <label class="radio-container m-r-55">Si
                                    <input type="radio" checked="checked" name="exist">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-container">No
                                    <input type="radio" name="exist">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn--radius-2 btn--red" type="submit">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/datepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/datepicker/daterangepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Main JS-->
    <script src="{{ asset('vendor/js/global.js') }}"></script>

    <script>
        jQuery(document).ready(function() {
            $('#form-agregar-usuario').submit(function(e){
                e.preventDefault();
                //spinner.show();
                // let data = $(this).serialize();
                var formDerivar = document.getElementById("form-agregar-usuario");
                let data = new FormData(formDerivar);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url:'inscritos',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if(data.status)
                        {
                            toastr.success(data.message, '¡Operación Exitosa!', {timeOut: 5000})
                            $('#nombres').val('');
                            $('#tipo').val(null).trigger('change');
                            $('#tipo').val('');
                        }
                        else
                        {
                            toastr.error(data.message, '¡Error!', {timeOut: 5000})
                        }
                    },
                    error: function(error) {
                        toastr.error(error, '¡Error!', {timeOut: 5000})
                    }
                });
            });
        })
    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->