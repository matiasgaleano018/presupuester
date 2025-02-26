@extends('adm.adm-default')

@php

//dd(Request::url() )

@endphp

@section('title', 'Presupuester - Registrarme')
@section('content')
<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4">
      <img src="img/icons/icon-100.png" alt="Presupuester" class="navbar-brand-image" style="max-width: 150px;">
    </div>
    <form class="card card-md" action="http://laravel-test:8082/sing-up" method="POST" autocomplete="off" novalidate>
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Registrarme</h2>
        <div class="row">
          <div class="col-lg-6 col-12">
            <label class="form-label">Nombre</label>
            <input type="text" name="first_name" class="form-control" placeholder="Ingresar nombre">
          </div>
          <div class="col-lg-6 col-12">
            <label class="form-label">Apellido</label>
            <input type="text" name="last_name" class="form-control" placeholder="Ingresar apellido">
          </div>
          <div class="col-12 my-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Ingresar email">
          </div>
          <div class="col-lg-6 col-12">
            <label class="form-label">Contraseña</label>
            <div class="input-group input-group-flat">
              <input type="password" name="pass" class="form-control"  placeholder="Password"  autocomplete="off">
              <span class="input-group-text">
                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                </a>
              </span>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <label class="form-label">Confirmar contraseña</label>
            <div class="input-group input-group-flat">
              <input type="password" name="confirm_pass" class="form-control"  placeholder="Password"  autocomplete="off">
              <span class="input-group-text">
                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                </a>
              </span>
            </div>
          </div>
        </div>

        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Crear</button>
        </div>
      </div>
    </form>
    <div class="text-center text-secondary mt-3">
      ¿Ya tienes una cuenta? <a href="{{ route('login') }}" tabindex="-1">Ingresar</a>
    </div>
  </div>
</div>
@endsection