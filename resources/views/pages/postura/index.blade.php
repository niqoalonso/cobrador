
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
                        <h4 class="mb-sm-0 font-size-18">Nueva Postura</h4>
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

                <div class="col-6 divPosturas" style="display: none;">
                    <div class="card">
                        <div class="card-body text-muted">
                            <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                <div class="pt-3">
                                    <div class="px-3">
                                        <h5 class="font-size-14 mb-3">Posturas</h5>
                                    </div>
                                    <ul class="list-unstyled chat-list listPosturas">
                                        
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

    <!-- Modal Nueva Postura -->
    <div class="modal fade" id="infoDetalleAbono" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Información Postura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="row">
                                <input type="text" class="inputIDArriendo" hidden>
                                <input type="text" class="inputID" hidden>
                                <input type="text" class="inputItemName" hidden>
                                <div class="col-7">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Item</label>
                                        <select class="form-control form-control-sm selectItemPostura" onchange="seleccionarItem(this.value)">
                                            <option value="">Seleccionar</option>
                                            @foreach ($itemsPosturas as $item)
                                                <option value="{{$item->id_item_postura}}">{{$item->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Cantidad</label>
                                        <input type="number" class="form-control form-control-sm inputCantidad" id="formrow-firstname-input" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-firstname-input">Monto Unitario</label>
                                        <input type="text" class="form-control form-control-sm inputMontoUnitario" readonly id="formrow-firstname-input">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-sm" type="button" onclick="agregarPostura()"><i class="fa fa-plus"></i> Agregar</button>
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
                                            <ul class="list-unstyled chat-list listPostura">
                                                
                                            </ul>
                                        </div>
                                    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 70px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                                </div><!-- end card-body -->
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Tipo Pago</label>
                                    <select class="form-control form-control-sm selectTipoPago" id="">
                                        <option value="">Seleccionar</option>
                                        @foreach ($pagos as $item)
                                            <option value="{{$item->id_pago}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="IngresarPostura()"><i class="fa fa-save"></i> Ingresar Postura</button>
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Postura -->
    <div class="modal fade" id="modalVerPostura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-info btn-xs btnMotivoAnulacion" style="display: none;" onclick="verMotivoAnulacion(this.id)"><i class="fa fa-info-circle"></i> Motivo Anulación</button>
                    <button type="button" class="btn btn-danger btn-xs btnAnular" style="display: none;" onclick="anularPostura(this.id)"><i class="fa fa-ban"></i> Anular</button>
                    <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Anular Postura -->
    <div class="modal fade" id="modalAnularPostura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Anular Postura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAnulacion">
                    <input type="text" class="inputIdPostura" name="id" hidden>
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
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-check-circle"></i> Confirmar Anulación</button>
                        <button type="button" class="btn btn-light btn-xs" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ver Locales --}}
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

    <script src="{{asset('pages/js/postura.js')}}"></script> 

@endsection