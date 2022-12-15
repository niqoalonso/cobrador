
@extends('layouts.index')


@section('css')
     <!-- alertifyjs Css -->
     <link href="{{asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Listado Clientes</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Clientes</h4>
                            </div>
                            <div class="card-body">

                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th width="10%">RUT</th>
                                        <th width="40%">Razon Social</th>
                                        <th>Alias</th>
                                        <th>Correo</th>
                                        <th width="10%">Acción</th>
                                    </tr>
                                    </thead>

                                    <tbody class="body-empresas">
                                        @foreach ($empresas as $item)
                                            <tr>    
                                                <td>{{$item->rut}}</td>
                                                <td>{{$item->razon_social}}</td>
                                                <td>{{$item->alias}}</td>
                                                <td>{{$item->correo}}</td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="ShowEmpresa(this.id)" id="{{$item->id_empresa}}" class="text-primary p-2"><i class="fa fa-info-circle"></i></a>
                                                    <a href="javascript:void(0)" onclick="ShowEmpresa(this.id)" id="{{$item->id_empresa}}" class="text-success p-2"><i class="fas fa-handshake" aria-hidden="true"></i></a>
                                                    <a href="{{route('gestionEmpresas.edit', $item->sku)}}" class="text-warning p-2"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)" onclick="DarBaja(this.id)" id="{{$item->id_empresa}}" class="text-danger p-2"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> 
       
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

    <!-- Modal Info Empresa - Cliente -->
    <div class="modal fade" id="infoEmpresaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Información Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">RUT</label>
                                <input type="text" class="form-control form-control-sm inputRUT" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Razón Social</label>
                                <input type="text" class="form-control form-control-sm inputRazonSocial" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Fantasia</label>
                                <input type="text" class="form-control form-control-sm inputFantasia" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Alias</label>
                                <input type="text" class="form-control form-control-sm inputAlias" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Correo</label>
                                <input type="text" class="form-control form-control-sm inputCorreo" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Telefono</label>
                                <input type="text" class="form-control form-control-sm inputTelefono" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Celular</label>
                                <input type="text" class="form-control form-control-sm inputCelular" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Requere Factura Correo</label>
                                <input type="text" class="form-control form-control-sm inputFactura" readonly id="formrow-firstname-input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <!-- alertifyjs js -->
    <script src="{{asset('assets/libs/alertifyjs/build/alertify.min.js')}}"></script>

    <!-- notification init -->
    <script src="{{asset('assets/js/pages/notification.init.js')}}"></script>
        
    <script src="{{asset('assets/js/app.js')}}"></script>

    <script src="{{asset('pages/js/listEmpresa.js')}}"></script>

@endsection