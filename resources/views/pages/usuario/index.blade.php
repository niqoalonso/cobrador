
@extends('layouts.index')


@section('css')
     <!-- alertifyjs Css -->
     <link href="{{asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content') 
    <div class="page-content">
        @if(count($roles) == 0)
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Gestión Usuarios</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Acceso Restringido</h4>
                                <p class="card-title-desc">No hemos podido detectar Roles ingresados en el sistema, dirigase al modulo <b><a href="{{route('GestionUser.index')}}">"Roles & Permisos"</a></b> para gestionar sus roles.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Gestión Usuarios</h4>
                        </div>
                    </div>
                </div> 
                <!-- end page title -->

                <div class="row divFormNuevo">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Nuevo Usuario</h4>
                                <p class="card-title-desc">Crea nuevos usuarios para poder gestionar tu plataforma.</p>
                            </div>

                            <form id="formUsuario">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">RUT</label>
                                                    <input type="text" class="form-control" id="input_dni" onkeyup="checkRut(this)" name="rut" placeholder="12345678-9">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="row divFormulario" style="display: none;">
                                        <div class="col-lg-6">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                    <input type="text" class="form-control" name="nombres" id="formrow-firstname-input">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Apellidos</label>
                                                    <input type="text" class="form-control" name="apellidos" id="formrow-firstname-input">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Correo Electronico</label>
                                                    <input type="text" class="form-control" name="correo" id="formrow-firstname-input">
                                                </div>
                            
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Roles</label>
                                                <select name="rol" class="form-control" id="">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($roles as $item)
                                                        <option value="{{$item->name}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row divFormulario" style="display: none;">
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary w-md btn-submit">Crear Usuario</button>
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
                


                <div class="row divFormEditar" style="display: none;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edición Usuario</h4>
                                <p class="card-title-desc">Edita la información usuarios para poder gestionar tu plataforma.</p>
                            </div>

                            <form id="formEditUsuario">
                                @method('PUT')
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">RUT</label>
                                                    <input type="text" class="form-control inputRut" name="rut">
                                                    <input type="text" class="inputID" name="id" hidden>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                    <input type="text" class="form-control inputNombres" name="nombres" id="formrow-firstname-input">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Apellidos</label>
                                                    <input type="text" class="form-control inputApellidos" name="apellidos" id="formrow-firstname-input">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Correo Electronico</label>
                                                    <input type="text" class="form-control inputCorreo" name="correo" id="formrow-firstname-input">
                                                </div>
                            
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Roles</label>
                                                <select name="rol" class="form-control body-usersEdit" id="">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($roles as $item)
                                                        <option value="{{$item->name}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary w-md btn-submitE">Actualizar Usuario</button>
                                            <button type="button" class="btn btn-danger w-md btn-submitE" onclick="CancelarEdicion()">Cancelar</button>
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-preloaderE" disabled style="display: none;">
                                                <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Espere
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Roles</h4>
                            </div>
                            <div class="card-body">

                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th width="20%">Correo</th>
                                        <th width="10%">Acción</th>
                                    </tr>
                                    </thead>

                                    <tbody class="body-users">
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="Editar(this.id)" id="{{$item->id}}" class="text-warning p-2"><i class="fa fa-edit"></i></a>
                                                    <a href="" class="text-danger p-2"><i class="fa fa-trash"></i></a>
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
        @endif
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

    <script src="{{asset('pages/js/usuario.js')}}"></script>

@endsection