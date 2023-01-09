
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
                        <h4 class="mb-sm-0 font-size-18">Historial Abonos</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row mb-2">
                                <div class="col-12"> 
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Clientes</label>
                                            <select class="js-example-basic-single" class="form-control" name="state" style="width: 100%" onchange="selectCliente(this.value)">
                                                    <option value="">Seleccionar Cliente</option>
                                                @foreach ($empresas as $item)
                                                    <option value="{{$item->sku}}"> <i> {{$item->rut}} </i>   || <b> {{$item->razon_social}} </b> || ( {{$item->alias}} )</option>
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

                <div class="col-4 divArriendo" style="display: none;">
                    <div class="card">
                        <div class="card-body text-muted">
                            <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                <div class="pt-3">
                                    <div class="px-3">
                                        <h5 class="font-size-14 mb-3">Arriendos</h5>
                                    </div>
                                    <ul class="list-unstyled chat-list listArriendo">
                                        
                                    </ul>
                                </div>
                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 70px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        </div><!-- end card-body -->
                    </div>
                </div>

                <div class="col-4 divFactura" style="display: none;">
                    <div class="card">
                        <div class="card-body text-muted">
                            <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                <div class="pt-3">
                                    <div class="px-3">
                                        <h5 class="font-size-14 mb-3">Facturas</h5>
                                    </div>
                                    <ul class="list-unstyled chat-list listFactura">
                                        
                                        
                                        
                                    </ul>
                                </div>
                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 70px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        </div><!-- end card-body -->
                    </div>
                </div>

                <div class="col-4 divAbonos" style="display: none;">
                    <div class="card">
                        <div class="card-body text-muted">
                            <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                <div class="pt-3">
                                    <div class="px-3">
                                        <h5 class="font-size-14 mb-3">Abonos</h5>
                                    </div>
                                    <ul class="list-unstyled chat-list listAbonos">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-14 mb-1">N° 234</h5>
                                                        <p class="text-truncate mb-0"><b>Monto:</b> $950.000</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-11">2022-05-14</div>
                                                    </div>
                                                    <div class="unread-message">
                                                        <span class="badge bg-success" style="padding: 5px;">Pagado</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-14 mb-1">Facturación N° 234</h5>
                                                        <p class="text-truncate mb-0"><b>Monto:</b> $950.000</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="font-size-11">2022-05-14</div>
                                                    </div>
                                                    <div class="unread-message">
                                                        <span class="badge bg-warning" style="padding: 5px;">No Pagada</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 70px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                        </div><!-- end card-body -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Page-content -->

    <!-- Modal Info Empresa - Cliente -->
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
                    <button type="button" class="btn btn-danger btn-xs btnAnularAbono" style="display: none;" onclick="anularAbono(this.id)" >Anular</button>
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Info Empresa - Cliente -->
    <div class="modal fade" id="modalAnularAbono" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Anular Abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAnulacion">
                    <input type="text" class="inputIdAbono" hidden name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Motivo</label>
                                    <textarea name="motivo" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-xs btnAnularAbono">Confirmar Anulación</button>
                        <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalLocales" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Locales Contratados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row detalleLocales">
                        <ul class="list-unstyled mb-0 listaLocales">
                            
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
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

    <script src="{{asset('pages/js/HistorialAbono.js')}}"></script>

@endsection