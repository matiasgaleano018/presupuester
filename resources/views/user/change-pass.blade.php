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
                            <a href="{{ route('user', ['id' => $user['id']]) }}" class="list-group-item list-group-item-action d-flex align-items-center">Cuenta</a>
                            <a href="{{ route('user-change-pass', ['id' => $user['id']]) }}" class="list-group-item list-group-item-action d-flex align-items-center active">Cambiar contraseña</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form action="{{ route('user-change-pass', ['id' => $user['id']]) }}" method="post" autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <h2 class="mb-4">Cambiar contraseña</h2>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-xl" style="background-image: url(https://api.dicebear.com/9.x/initials/svg?seed={{ $avatar }})"></span>
                                    </div>
                                </div>
                                <div class="row g-3 my-3">
                                    <div class="col-12">
                                        <h4>{{ $user['first_name'] . ' ' . $user['last_name'] }}</h4>
                                    </div>
                                </div>
                                <div class="row g-3 my-3">
                                    <div class="col-md">
                                        <div class="form-label">Contraseña actual</div>
                                        <input type="password" name="old_pass" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Nueva contraseña</div>
                                        <input type="password" name="new_pass" class="form-control">
                                    </div>
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