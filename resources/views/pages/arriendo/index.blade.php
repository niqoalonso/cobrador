
@extends('layouts.index')


@section('css')
     <!-- alertifyjs Css -->
     <link href="{{asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title --> 
            <div class="row ">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Gestión Arriendos</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row" >
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Clientes</h4>
                            <p class="card-title-desc">Selecciona un cliente para revisar sus contratos de arriendo.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-2">
                                <div class="col-lg-8">
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Clientes</label>
                                            <select class="form-control" onchange="buscarArriendo(this)" name="" id="">
                                                <option value="">Seleccionar</option>
                                                @foreach ($empresas as $item)
                                                    <option value="{{$item->id_empresa}}">{{$item->razon_social}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Contratos</h4>
                        </div>
                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th width="5%">Contrato</th>
                                    <th width="20%">Mensualidad</th>
                                    <th width="20%">Fecha Inicio</th>
                                    <th width="10%">Estado</th>
                                    <th width="10%">Acción</th>
                                </tr>
                                </thead>

                                <tbody class="body-arriendo">
                                    
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


            <div class="row" >
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nuevo ROL</h4>
                            <p class="card-title-desc">ROL seran utilizados para dar restricción a los diferentes modulos de la plataforma.</p>
                        </div>

                        <form id="formRol">
                            <div class="card-body p-4">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="formrow-firstname-input" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                   
                                </div>

                                <div class="row">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-md btn-submit">Crear ROL</button>
                                        <button type="button" class="btn btn-primary waves-effect waves-light btn-preloader" disabled style="display: none;">
                                            <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- Modal Info Empresa - Cliente -->
    <div class="modal fade" id="infoContrato" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Información Arriendo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Valor Arriendo</label>
                                <input type="text" class="form-control form-control-sm inputValorArriendo" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Fecha Inicio</label>
                                <input type="text" class="form-control form-control-sm inputFechaInicio" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Fecha Termino</label>
                                <input type="text" class="form-control form-control-sm inputFechaTermino" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Locales</h6>
                        </div>
                        <div class="col-12 row divLocales">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="{{asset('pages/js/arriendo.js')}}"></script>

@endsection