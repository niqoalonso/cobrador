
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
                            <h4 class="card-title">Nueva Rendicion</h4>
                            <p class="card-title-desc">Seleccione un cliente al cual desea ingresar nuevo abono de pago.</p>
                        </div>
                        <div class="row divBotonRendir" @if(count($abonos) == 0) style="display: none;" @endif>
                            <div class="col-12 mt-2">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="button" onclick="RendirAbonos()"><i class="fa fa-check-circle"></i> Rendir Ahora</button>
                                  </div>
                            </div>
                        </div>
                        <div class="card-body divTablaDatos" @if(count($abonos) == 0) style="display: none;" @endif>
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>N° Factura</th>
                                        <th>Folio Interno</th>
                                        <th>Monto</th>
                                        <th>Tipo Pago</th>
                                        <th>Fecha Emisión</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($abonos as $item)
                                        <tr>
                                            <td>{{$item->Factura->n_factura}}</td>
                                            <td>{{$item->sku}}</td>
                                            <td>${{$item->monto}}</td>
                                            <td>{{$item->TipoPago->nombre}}</td>
                                            <td>{{$item->fecha_emision}}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" onclick="verDetalleAbono(this.id)" id="{{$item->sku}}"><i class="fa fa-eye"></i></button>
                                            </td>
                                        </tr>    
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="row divNoRigistros" @if(count($abonos) != 0) style="display: none;" @endif>
                            <div class="col-lg-12">
                                <div class="card-header ">
                                    <h5 class="card-title text-center">No se han encontrado abonos ingresador.</h5>
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