@php

$user = $data['user'];
$fname = substr($user['first_name'], 0, 1);
$lname = substr($user['last_name'], 0, 1);
$avatar = $fname . $lname;
@endphp

@extends('layouts.base')
@section('title', 'Mi perfil - Presupuester')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Modificar cuenta
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <div class="list-group list-group-transparent">
                                <a href="{{ route('user', ['id' => $user['id']]) }}" class="list-group-item list-group-item-action d-flex align-items-center active">Cuenta</a>
                                <a href="{{ route('user-change-pass', ['id' => $user['id']]) }}" class="list-group-item list-group-item-action d-flex align-items-center">Cambiar contraseña</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form action="{{ route('user', ['id' => $user['id']]) }}" method="post" autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <h2 class="mb-4">Mi cuenta</h2>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-xl" style="background-image: url(https://api.dicebear.com/9.x/initials/svg?seed={{ $avatar }})"></span>
                                    </div>
                                </div>
                                <div class="row g-3 my-3">
                                    <div class="col-md">
                                        <div class="form-label">Nombre</div>
                                        <input type="text" name="first_name" class="form-control" value="{{ $user['first_name'] }}">
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Apellido</div>
                                        <input type="text" name="last_name" class="form-control" value="{{ $user['last_name'] }}">
                                    </div>
                                </div>
                                <h3 class="card-title mt-4">Email</h3>
                                <div>
                                    <div class="row g-3">
                                        <div class="col-md">
                                            <input type="text" name="email" class="form-control" value="{{ $user['email'] }}">
                                        </div>
                                    </div>
                                </div>
                    
                                <h3 class="card-title mt-4">Apariencia</h3>
                                <div>
                                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
            data-bs-placement="bottom">
                                        <i class="far fa-moon"></i>
                                        <span class="ms-1">Cambiar a modo oscuro</span>
                                    </a>
                                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
                                data-bs-placement="bottom">
                                        <i class="far fa-sun"></i>
                                        <span class="ms-1">Cambiar a modo claro</span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list justify-content-end">
                                    <a href="{{ route('welcome') }}" class="btn btn-danger">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Modificar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection