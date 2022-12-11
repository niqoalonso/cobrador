
@extends('layouts.index')


@section('css')
     <!-- alertifyjs Css -->
     <link href="{{asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
     <style type="text/css">
        .preview {
          overflow: hidden;
          margin: auto;
          width: 300px; 
          height: 300px;
          border: 1px solid rgb(216, 216, 216);
        }
      </style>

@endsection

@section('content')
    <div class="page-content">
        @if(count($representantes) == 0)    
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Gestión Usuarios</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Acceso Restringido</h4>
                                <p class="card-title-desc">No hemos podido detectar representes ingresados en el sistema, dirigase al modulo <b><a href="{{route('gestionRepresentante.index')}}"> "Gestión Clientes > Representantes" </a></b> para gestionar sus clientes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @else
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Gestión Cliente</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <form id="formEmpresa">
                    <div class="row divFormNuevo">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Informacion Cliente</h4>
                                    <p class="card-title-desc">Crea nuevos clientes para luego asignarle un arriendo.</p>
                                </div>

                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">RUT</label>
                                                    <input type="text" class="form-control" id="input_dni" onkeyup="checkRut(this)" name="rut" placeholder="12345678-9">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row divFormulario" style="display: none;">
                                        
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Razon Social</label>
                                                <input type="text" class="form-control" name="razon_social" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Fantasia</label>
                                                <input type="text" class="form-control" name="fantasia" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Alias</label>
                                                <input type="text" class="form-control" name="alias" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Correo Electronico</label>
                                                <input type="text" class="form-control" name="correo" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Telefono</label>
                                                <input type="text" class="form-control" name="telefono" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Celular</label>
                                                <input type="text" class="form-control" name="celular" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Representante</label>
                                                <select name="representante" class="form-control" id="">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($representantes as $item)
                                                        <option value="{{$item->id_representante}}">{{$item->nombres}} {{$item->apellidos}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label" for="formrow-firstname-input">Facturación por correo</label>
                                            <div class="form-check form-switch mb-3 mt-2" dir="ltr">
                                                <input type="checkbox" class="form-check-input" name="factura" id="customSwitch1">
                                                <label class="form-check-label" for="customSwitch1">Si, recibir documentos tributarios.</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Foto Perfil - <small>(opcional)</small></label>
                                                <input type="file" class="form-control image" id="file">
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <label class="form-label" for="formrow-firstname-input">Visualizador</label>
                                            <div class="preview text-center">                        
                                                <img id="image" src=""  width="90%">   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row divFormulario" style="display: none;">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Información Arriendo</h4>
                                    <p class="card-title-desc">Ingresa la información del arriendo asociado al cliente.</p>
                                </div>

                                <form id="formEmpresa">
                                    <div class="card-body p-4">
                                        <div class="row divFormulario">
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Contrato</label>
                                                    <input type="file" class="form-control" name="contrato" id="formrow-firstname-input">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Valor Arriendo</label>
                                                    <input type="text" class="form-control" name="valor_arriendo" id="formrow-firstname-input">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Fecha Inicio</label>
                                                    <input type="date" class="form-control" name="fecha_inicio" id="formrow-firstname-input">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Fecha Termino</label>
                                                    <input type="date" class="form-control" name="fecha_termino" id="formrow-firstname-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="row divFormulario" style="display: none;">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="row ">
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary w-md btn-submit">Crear Representante</button>
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-preloader" disabled style="display: none;">
                                                <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        @endif
    </div>
    <!-- End Page-content -->


    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © Minia.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by <a href="#!" class="text-decoration-underline">Themesbrand</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('js')

    <!-- alertifyjs js -->
    <script src="{{asset('assets/libs/alertifyjs/build/alertify.min.js')}}"></script>

    <!-- notification init -->
    <script src="{{asset('assets/js/pages/notification.init.js')}}"></script>
        
    <script src="{{asset('assets/js/app.js')}}"></script>

    <script src="{{asset('pages/js/empresa.js')}}"></script>

@endsection