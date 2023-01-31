
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
                            <h4 class="card-title">Solicitudes Rendicion Posturas</h4>
                        </div>
                        <div class="card-body divTablaDatos" @if(count($rendiciones) == 0) style="display: none;" @endif>
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Usuario Rendidor</th>
                                        <th>Folio Interno</th>
                                        <th>Efectivo</th>
                                        <th>Cheque</th>
                                        <th>Transferencia</th>
                                        <th>Total</th>
                                        <th>Fecha Emisión</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>

                                <tbody class="body-rendiciones">
                                    @foreach ($rendiciones as $item)
                                        <tr>
                                            <td>{{$item->user->name}}</td>
                                            <td>{{$item->folio}}</td>
                                            <td>${{$item->monto_efectivo}}</td>
                                            <td>${{$item->monto_cheque}}</td>
                                            <td>${{$item->monto_transferencia}}</td>
                                            <td>${{$item->monto}}</td>
                                            <td>{{$item->fecha_emision}}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" onclick="verPosturas(this.id)" id="{{$item->id_rendicion}}"><i class="fa fa-eye"></i></button>
                                                <button class="btn btn-sm btn-success" onclick="AprobarRendicion(this.id)" id="{{$item->id_rendicion}}"><i class="fa fa-check-circle"></i></button>
                                            </td>
                                        </tr>    
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="row divNoRigistros" @if(count($rendiciones) != 0) style="display: none;" @endif>
                            <div class="col-lg-12">
                                <div class="card-header ">
                                    <h5 class="card-title text-center">No se han encontrado rendiciones de abonos ingresados.</h5>
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

    {{-- Modal Posturas Lista --}}
    <div id="modalInfoPosturas" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
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
                            
                                <ul class="list-unstyled chat-list listPosturas">
                                                                                   
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

    <!-- Modal Ver Detalle Postura -->
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

    <script src="{{asset('pages/js/SolicitudRendicionPostura.js')}}"></script>

@endsection