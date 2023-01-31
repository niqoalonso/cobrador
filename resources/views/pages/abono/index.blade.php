
@extends('layouts.index')


@section('css')
     <!-- alertifyjs Css -->
     <link href="{{asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nuevo Abono</h4>
                            <p class="card-title-desc">Seleccione un cliente al cual desea ingresar nuevo abono de pago.</p>
                        </div>

                        <div class="card-body p-4">
                            <div class="row mb-2">
                                <div class="col-lg-12"> 
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

            <div class="contentFactura">
                
            </div>

        </div>
    </div>
    <!-- End Page-content -->

        <!-- Modal Info Contrato -->
    <div class="modal fade" id="nuevoAbono" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Nuevo Abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevoAbono">
                    <input type="text" class="idFactura" name="id" hidden>
                    <input type="text" class="skuEmpresa" name="sku" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Tipo de Pago</label>
                                    <select name="tipo_pago" class="form-control form-control-sm inputTipoPago" onchange="selectTipoPago(this.value)">
                                        <option value="">Seleccionar</option>
                                        @foreach ($pagos as $item)
                                            <option value="{{$item->id_pago}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 inputTitular" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Titular</label>
                                    <input type="text" name="titular" class="form-control form-control-sm iTitular" id="formrow-firstname-input">
                                </div>
                            </div>

                            <div class="col-12 inputBanco" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Banco</label>
                                    <select name="entidad" class="form-control form-control-sm" id="">
                                        <option value="">Seleccionar</option>
                                        @foreach ($entidades as $item)
                                            <option value="{{$item->id_entidad}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 inputCheque" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">N° Cheque</label>
                                    <input type="text" name="n_cheque" class="form-control form-control-sm iNcheque" id="formrow-firstname-input">
                                </div>
                            </div>

                            <div class="col-6 inputVencimiento" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Vencimiento</label>
                                    <input type="date" name="f_vencimiento" class="form-control form-control-sm iFvencimiento" id="formrow-firstname-input">
                                </div>
                            </div>

                            <div class="col-6 inputTransaccion" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">N° Transacción</label>
                                    <input type="text" name="n_transaccion" class="form-control form-control-sm iTransaccion" id="formrow-firstname-input">
                                </div>
                            </div> 

                            <div class="col-6 inputFTransaccion" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Fecha Transacción</label>
                                    <input type="date" name="f_transaccion" class="form-control form-control-sm iFtransaccion" id="formrow-firstname-input">
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Fecha Abono</label>
                                    <input type="date" name="f_emision" class="form-control form-control-sm iFabono" id="formrow-firstname-input">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Monto</label>
                                    <input type="text" name="monto" class="form-control form-control-sm iMonto" id="formrow-firstname-input">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Abonos Lista --}}
    <div id="modalInforAbono" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
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

    <!-- Modal Motivo Anulación -->
    <div class="modal fade" id="modalMotivoAnulacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Motivo Anulación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDetalleAbono">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Usuario Responsable</label>
                                    <input type="text" class="form-control form-control-sm inputUsuarioAnulacion" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Fecha Anulación</label>
                                    <input type="text" class="form-control form-control-sm inputFechaAnulacion" readonly id="formrow-firstname-input">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Motivo</label>
                                    <textarea name="" class="form-control inputMotivoAnulacion" readonly cols="20" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
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
                        <button type="submit" class="btn btn-danger btn-xs btnAnularAbono"><i class="fa fa-check-circle"></i> Confirmar Anulación</button>
                        <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"> <i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ver Locales Arrendados --}}
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

    <script src="{{asset('pages/js/abono.js')}}"></script>

@endsection