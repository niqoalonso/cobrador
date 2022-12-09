
@extends('layouts.index')


@section('css')
     <!-- alertifyjs Css -->
     <link href="{{asset('assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row ">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Gestión ROLES</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row divFormNuevo" >
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nuevo ROL</h4>
                            <p class="card-title-desc">ROL seran utilizados para dar restricción a los diferentes modulos de la plataforma.</p>
                        </div>

                        <form id="formRol">
                            <div class="card-body p-4">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="formrow-firstname-input" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($permisos as $item)
                                        <div class="col-3 mb-2">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" value="{{$item->id}}" name="permisos[]" class="form-check-input" id="formrow-customCheck{{$item->id}}">
                                                    <label class="form-check-label" for="formrow-customCheck{{$item->id}}">{{$item->name}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-md btn-submit">Crear ROL</button>
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
                            <h4 class="card-title">Editar ROL</h4>
                            <p class="card-title-desc">Edite sus roles que seran utilizados para dar restricción a los diferentes modulos de la plataforma.</p>
                        </div>

                        <form id="formRolEditar">
                            @method('PUT')
                            <input type="text" class="inputID" name="id" hidden>
                            <div class="card-body p-4">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Nombre</label>
                                                <input type="text" class="form-control inputNombre" name="nombre" id="formrow-firstname-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($permisos as $item)
                                        <div class="col-3 mb-2">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" value="{{$item->id}}" name="permisos[]" class="form-check-input" id="formrow-customCheckEdit{{$item->id}}">
                                                    <label class="form-check-label" for="formrow-customCheckEdit{{$item->id}}">{{$item->name}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-md btn-submitE">Actualizar ROL</button>
                                        <button type="button" class="btn btn-danger w-md btn-submitE" onclick="Cancelar()">Cancelar</button>
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
                                    <th width="20%">Permisos</th>
                                    <th width="10%">Acción</th>
                                </tr>
                                </thead>

                                <tbody class="body-roles">
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>{{count($item->permissions)}}</td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="Editar(this.id)" id="{{$item->id}}" class="text-warning p-2"><i class="fa fa-edit"></i></a>
                                                <a href="javascript:void(0)" onclick="Eliminar(this.id)" id="{{$item->id}}" class="text-danger p-2"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
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

    <script src="{{asset('pages/js/rol.js')}}"></script>

@endsection