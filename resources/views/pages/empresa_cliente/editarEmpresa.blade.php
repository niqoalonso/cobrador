
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
                        <h4 class="mb-sm-0 font-size-18">Gestión Cliente</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edición</h4>
                            <p class="card-title-desc">Edite la información de su cliente, para gestionar la plataforma.</p>
                        </div>

                        <form id="formUpdate">
                            @method('PUT')
                            <input type="number" class="inputID" value="{{$empresa->id_empresa}}" name="id" hidden>
                            <div class="card-body p-4">
                                <div class="row mb-2">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">RUT</label>
                                            <input type="text" class="form-control" id="formrow-firstname-input" disabled value="{{$empresa->rut}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="formrow-firstname-input">Razón Social</label>
                                            <input type="text" class="form-control"name="razon_social" id="formrow-firstname-input" value="{{$empresa->razon_social}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="formrow-firstname-input">Fantasia</label>
                                            <input type="text" class="form-control" name="fantasia" id="formrow-firstname-input" value="{{$empresa->nombre_fantasia}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="formrow-firstname-input">Alias</label>
                                            <input type="text" class="form-control" name="alias" id="formrow-firstname-input" value="{{$empresa->alias}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="formrow-firstname-input">Correo Electronico</label>
                                            <input type="text" class="form-control" name="correo" id="formrow-firstname-input" value="{{$empresa->correo}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="formrow-firstname-input">Telefono</label>
                                            <input type="text" class="form-control" name="telefono" id="formrow-firstname-input" value="{{$empresa->telefono}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="formrow-firstname-input">Celular</label>
                                            <input type="text" class="form-control" name="celular" id="formrow-firstname-input" value="{{$empresa->celular}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
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
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label" for="formrow-firstname-input">Facturación por correo</label>
                                        <div class="form-check form-switch mb-3 mt-2" dir="ltr">
                                            <input type="checkbox" class="form-check-input" name="factura" id="customSwitch1" @if($empresa->solicita_fac_email == 1) checked @endif>
                                            <label class="form-check-label" for="customSwitch1">Si, recibir documentos tributarios.</label>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label" for="formrow-firstname-input">Imagen Perfil</label>
                                        <div class="d-grid gap-2" dir="ltr">
                                            <a href="javascript:(0)" class="linkInputImg" onclick="verImagen(this.id)" id="{{$empresa->url_perfil}}"><button type="button" class="btn btn-warning "><i class="fa fa-imagen"></i> Ver Imagen</button></a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-firstname-input">Foto Perfil - <small>(opcional)</small></label>
                                            <input type="file" class="form-control image" id="file">
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <label class="form-label" for="formrow-firstname-input">Visualizador</label>
                                        <div class="preview text-center">                        
                                            <img id="image" src=""  width="90%">   
                                        </div>
                                    </div>
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

    <script src="{{asset('pages/js/editarEmpresa.js')}}"></script>

@endsection