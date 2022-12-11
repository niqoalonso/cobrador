
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
                            <h4 class="mb-sm-0 font-size-18">Gestión Locales</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="card-title-desc">Gestionas tus areas de trabajo, para luego asignarles sus locales correspondientes para gestionar sus arriendos.</p>
                            </div><!-- end card header -->
                            
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    <li class="nav-item waves-effect waves-light" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Gestión Areas</span> 
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#home-1" role="tab" aria-selected="false" tabindex="-1">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Gestión Locales</span> 
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
                                    
                                    <div class="tab-pane active show" id="profile-1" role="tabpanel">
                                        <div class="card-header row">
                                            <div class="col-6">
                                                <h4 class="card-title titleAreaNuevo">Nueva Area</h4>
                                                <h4 class="card-title titleAreaEditar" style="display: none;">Editar Area</h4>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="card-title">Listado</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 divAreaNuevo">
                                                <form id="formArea">
                                                    <div class="card-body p-4">
                                                       
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                                        <input type="text" class="form-control" name="nombre" id="formrow-firstname-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                    
                                                        <div class="row">
                                                            <div class="mt-4">
                                                                <button type="submit" class="btn btn-primary w-md btn-submitE">Crear Area</button>
                                                                
                                                                <button type="button" class="btn btn-primary waves-effect waves-light btn-preloaderE" disabled style="display: none;">
                                                                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-6 divAreaEditar" style="display: none;">
                                                <form id="formEditarArea">
                                                    @method('PUT')
                                                    <div class="card-body p-4">
                                                       <input type="text" name="id" class="inputAreaID" hidden>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                                        <input type="text" class="form-control inputNombre" name="nombre" id="formrow-firstname-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                    
                                                        <div class="row">
                                                            <div class="mt-4">
                                                                <button type="submit" class="btn btn-primary w-md btn-submitE">Actualizar Area</button>
                                                                <button type="button" class="btn btn-danger w-md btn-submitE" onclick="CancelarArea()">Cancelar</button>
                                                                
                                                                <button type="button" class="btn btn-primary waves-effect waves-light btn-preloaderE" disabled style="display: none;">
                                                                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-6">
                                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100 mt-5">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th width="10%">Acción</th>
                                                    </tr>
                                                    </thead>
                
                                                    <tbody class="body-areas">
                                                        @foreach ($areas as $item)
                                                            <tr>    
                                                                <td>{{$item->nombre}}</td>
                                                                <td>
                                                                    <a href="javascript:void(0)" onclick="EditarArea(this.id)" id="{{$item->id_area}}" class="text-warning p-2"><i class="fa fa-edit"></i></a>
                                                                    <a href="javascript:void(0)" onclick="EliminarArea(this.id)" id="{{$item->id_area}}" class="text-danger p-2" ><i class="fa fa-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="home-1" role="tabpanel">
                                        <div class="divFormularioLocal" @if(count($areas) == 0) style="display: none;" @endif>
                                            <div class="card-header row">
                                                <div class="col-6">
                                                    <h4 class="card-title titleLocalNuevo">Nuevo Local</h4>
                                                    <h4 class="card-title titleLocalEditar" style="display: none;">Editar Local</h4>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="card-title">Listado</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 divFormLocalNuevo">
                                                    <form id="formLocal">
                                                        <div class="card-body p-4">
                                                           
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="formrow-firstname-input">Nombre - <small>(Identificador)</small></label>
                                                                            <input type="text" class="form-control" name="identificador" id="formrow-firstname-input">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="formrow-firstname-input">Dirección</label>
                                                                            <input type="text" class="form-control" name="direccion" id="formrow-firstname-input">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="formrow-firstname-input">Area</label>
                                                                            <select name="area" class="form-control inputAreaSelect">
                                                                                <option value="">Seleccionar</option>
                                                                                @foreach ($areas as $item)
                                                                                    <option value="{{$item->id_area}}">{{$item->nombre}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                        
                                                            <div class="row">
                                                                <div class="mt-4">
                                                                    <button type="submit" class="btn btn-primary w-md btn-submitL">Crear Local</button>
                                                                    
                                                                    <button type="button" class="btn btn-primary waves-effect waves-light btn-preloaderL" disabled style="display: none;">
                                                                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-6 divFormLocalEdit" style="display: none;">
                                                    <form id="formEditarLocal">
                                                        @method('PUT')
                                                        <div class="card-body p-4">
                                                                <input type="text" class="inputIDLocal" name="id" hidden>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="formrow-firstname-input">Nombre - <small>(Identificador)</small></label>
                                                                            <input type="text" class="form-control inputIdentificador" name="identificador" id="formrow-firstname-input">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="formrow-firstname-input">Dirección</label>
                                                                            <input type="text" class="form-control inputDireccion" name="direccion" id="formrow-firstname-input">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="formrow-firstname-input">Area</label>
                                                                            <select name="area" class="form-control inputAreaSelectEdit">
                                                                                <option value="">Seleccionar</option>
                                                                                @foreach ($areas as $item)
                                                                                    <option value="{{$item->id_area}}">{{$item->nombre}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                        
                                                            <div class="row">
                                                                <div class="mt-4">
                                                                    <button type="submit" class="btn btn-primary w-md btn-submitL">Crear Local</button>
                                                                    
                                                                    <button type="button" class="btn btn-primary waves-effect waves-light btn-preloaderL" disabled style="display: none;">
                                                                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-6">
                                                    <table id="datatableLocal" class="table table-bordered dt-responsive  nowrap w-100 mt-5">
                                                        <thead>
                                                        <tr>
                                                            <th>Nombre - <small>(Identificador)</small>  </th>
                                                            <th>Area</th>
                                                            <th width="10%">Acción</th>
                                                        </tr>
                                                        </thead>
                    
                                                        <tbody class="body-locales">
                                                            @foreach ($locales as $item)
                                                                <tr>    
                                                                    <td>{{$item->identificador}}</td>
                                                                    <td>{{$item->area->nombre}}</td>
                                                                    <td>
                                                                        <a href="javascript:void(0)" onclick="EditarLocal(this.id)" id="{{$item->id_local}}" class="text-warning p-2"><i class="fa fa-edit"></i></a>
                                                                        <a href="" class="text-danger p-2"><i class="fa fa-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divBloqueoAcceso"  @if(count($areas) > 0) style="display: none;" @endif>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">Acceso Restringido</h4>
                                                            <p class="card-title-desc">No hemos podido detectar Areas ingresadas en el sistema, dirigase a la pestaña "Gestión Areas" para gestionar sus areas.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>

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
@endsection

@section('js')

    <!-- alertifyjs js -->
    <script src="{{asset('assets/libs/alertifyjs/build/alertify.min.js')}}"></script>

    <!-- notification init -->
    <script src="{{asset('assets/js/pages/notification.init.js')}}"></script>
        
    <script src="{{asset('assets/js/app.js')}}"></script>

    <script src="{{asset('pages/js/area.js')}}"></script>
    <script src="{{asset('pages/js/local.js')}}"></script>

@endsection