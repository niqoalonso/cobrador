
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
        <div class="container-fluid">

            <!-- start page title --> 
            <div class="row ">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Gestión Arriendo</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edición Contrato</h4>
                            <p class="card-title-desc">Edite la información de su contrato, para gestionar la plataforma.</p>
                        </div>

                        <form id="formUpdate">
                            @method('PUT')
                            <input type="number" class="inputID" value="{{$arriendo->id_arriendo}}" name="id" hidden>
                            <div class="card-body p-4">
                                <div class="row mb-2">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Contrato</label>
                                            <input type="file" name="contrato" class="form-control inputContrato" id="formrow-firstname-input">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Valor Arriendo</label>
                                            <input type="text" name="valor_arriendo" class="form-control" id="formrow-firstname-input" value="{{$arriendo->valor_arriendo}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Fecha Inicio</label>
                                            <input type="date" name="fecha_inicio" class="form-control" id="formrow-firstname-input" value="{{$arriendo->fecha_inicio}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Fecha Termino</label>
                                            <input type="date" name="fecha_termino" class="form-control" id="formrow-firstname-input" value="{{$arriendo->fecha_termino}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Locales</label>
                                            <select class="form-control js-example-basic-multiple" name="locales[]" multiple="multiple" style="width: 100%">
                                                @php
                                                    $existe = 0;
                                                @endphp
                                                @foreach ($data as $item)
                                                    @foreach ($arriendo->local as $item2)
                                                        @if($item->id_local == $item2->id_local)
                                                            @php
                                                                $existe = 1;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    @if($existe == 1)
                                                        <option value="{{$item->id_local}}" selected>{{$item->identificador}}</option>
                                                        @php
                                                            $existe = 0;
                                                        @endphp
                                                    @else 
                                                        <option value="{{$item->id_local}}">{{$item->identificador}}</option>
                                                    @endif
                                                   
                                                       
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Documento PDF</label><br>
                                            <a href="../../storage/{{$arriendo->url_contrato}}" class="linkContrato" target="_blank"><button class="btn btn-warning" type="button"><i class="fa fa-file"></i> Ver Contrato</button></a>
                                        </div>
                                    </div>
                                    {{-- <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Representante</label>
                                            <select name="representante" class="form-control" id="">
                                                <option value="">Seleccionar</option>
                                                @foreach ($representantes as $item)
                                                    @if($empresa->representante_id == $item->id_representante)
                                                        <option value="{{$item->id_representante}}" selected>{{$item->nombres}} {{$item->apellidos}}</option>
                                                    @else 
                                                        <option value="{{$item->id_representante}}">{{$item->nombres}} {{$item->apellidos}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-md btn-submit">Actualizar Información</button>
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
    <div class="modal fade mt-2" id="modalImagen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <img src="" class="imgVer" width="100%" alt="">
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

    <script src="{{asset('pages/js/editarArriendo.js')}}"></script>

@endsection