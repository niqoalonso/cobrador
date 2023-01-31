
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
                        <h4 class="mb-sm-0 font-size-18">Historial Rendición Abonos</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-8">
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Historial</h4>
                                    <p class="card-title-desc">Seleccione el mes que desea revisar su rendiciones.</p>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Mes</label>
                                                    <input type="month" class="form-control" onchange="changeMes(this.value)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 divRendiciones" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Rendiciones</h4>
                                    <p class="card-title-desc">Listado de rendiciones historicas.</p>
                                </div>
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Efectivo</th>
                                            <th>Cheque</th>
                                            <th>Transferencia</th>
                                            <th>Total</th>
                                            <th>Fecha Emisión</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
        
                                        <tbody class="body-rendicion">
                                            
                                        </tbody>
                                    </table>
        
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
               
            </div>
            

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    {{-- Modal Abonos Lista --}}
    <div id="modalInforAbono" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Informacion Comprobante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body text-muted">
                        <div class="chat-message-list" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer">
                                        </div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: -15px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                                <div class="simplebar-content" style="padding: 0px;">
                            
                                <ul class="list-unstyled chat-list listAbono">
                                                                                   
                                </ul>
                           
                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 70px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                    </div><!-- end card-body -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal"> <i class="fa fa-times"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detale Abono -->
    <div class="modal fade" id="infoDetalleAbono" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Información Abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDetalleAbono">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Tipo Pago</label>
                                    <input type="text" class="form-control form-control-sm inputPago" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Monto</label>
                                    <input type="text" class="form-control form-control-sm inputMonto" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Fecha Abono</label>
                                    <input type="text" class="form-control form-control-sm inputFechaAbono" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 divTitular">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Titular</label>
                                    <input type="text" class="form-control form-control-sm inputTitular" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-3 divBanco">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Banco</label>
                                    <input type="text" class="form-control form-control-sm inputBanco" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-3 divCheque">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">N° Cheque</label>
                                    <input type="text" class="form-control form-control-sm inputCheque" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-3 divVencimiento">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Fecha Vencimiento</label>
                                    <input type="text" class="form-control form-control-sm inputVencimiento" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-3 divTransaccion">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">N° Transacción</label>
                                    <input type="text" class="form-control form-control-sm inputTransaccion" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-3 divFtransaccion">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Fecha Transacción</label>
                                    <input type="text" class="form-control form-control-sm inputFtransaccion" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-xs btnMotivoAnulacion" style="display: none;" onclick="verMotivoAnulacion(this.id)"><i class="fa fa-info-circle"></i> Motivo Anulación</button>
                    <button type="button" class="btn btn-danger btn-xs btnAnularAbono" style="display: none;" onclick="anularAbono(this.id)"> <i class="fa fa-ban"></i>Anular</button>
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
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

    <script src="{{asset('pages/js/RendicionAbono.js')}}"></script>

@endsection