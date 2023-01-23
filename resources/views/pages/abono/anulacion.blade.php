
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
                        <h4 class="mb-sm-0 font-size-18">Anulación Abonos</h4>
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
                                        <th width="40%">CLIENTE (ALIAS)</th>
                                        <th>MONTO</th>
                                        <th>MOTIVO</th>
                                        <th>FECHA</th>
                                        <th width="10%">Acción</th>
                                    </tr>
                                </thead>

                                <tbody class="body-anulacion">
                                    @foreach ($data as $item)
                                        <tr>    
                                            <td>{{$item->factura->arriendo->empresa->rut}}</td>
                                            <td>{{$item->factura->arriendo->empresa->alias}}</td>
                                            <td>${{$item->monto}}</td>
                                            <td class="text-center"><a href="javascript:void(0)" onclick="motivoAnulacionVer(this.id)" id="{{$item->motivo}}" class="text-warning p-2"><i class="fa fa-exclamation-triangle"></i></a>
                                            <td>{{$item->fecha_emision}}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="text-info p-2" onclick="verDetalleAbono(this.id)" id="{{$item->sku}}" ><i class="fa fa-list-alt"></i></a>
                                                <a href="javascript:void(0)" class="text-success p-2" onclick="confirmarAnulacion(this.id)" id="{{$item->id_abono}}"><i class="fa fa-check-circle"></i></a>
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

    <!-- Modal Informacion Motivo Anulacion Postura -->

    <div class="modal fade" id="modalInformacionDetalleAnulacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Motivo Anulación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 divMotivoAnulacion">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Detalle Abono -->
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

    <!-- Modal Ver Detalle Abono -->

    <div class="modal fade" id="modalVerAbono" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Detalle Postura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="row">
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">SKU</label>
                                        <input type="text" class="form-control form-control-sm inputSku" readonly>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Fecha Emisión</label>
                                        <input type="text" class="form-control form-control-sm inputFecha" readonly>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Tipo Pago</label>
                                        <input type="text" class="form-control form-control-sm inputTipoPago" readonly>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Total</label>
                                        <input type="text" class="form-control form-control-sm inputTotal" readonly>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body text-muted">
                                    <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                        <div class="pt-3">
                                            <div class="px-3">
                                                <h5 class="font-size-14 mb-3">Detalle</h5>
                                            </div>
                                            <ul class="list-unstyled chat-list listDetallePostura">
                                                
                                            </ul>
                                        </div>
                                    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 70px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-xs btnAnular" style="display: none;" onclick="anularPostura(this.id)" ><i class="fa fa-ban"></i> Anular Postura</button>
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Anular Abono -->

    <div class="modal fade" id="modalAnularAbono" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Aceptación Anulación Abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAceptaAnulacion">
                    <input type="text" class="inputIdAbono" name="id" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Observación anulación</label>
                                    <textarea name="motivo" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-check-circle"></i> Aceptar Anulación</button>
                        <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </form>
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

    <script src="{{asset('assets/libs/alertifyjs/build/alertify.min.js')}}"></script>

    <script src="{{asset('pages/js/anulacionAbono.js')}}"></script>

@endsection