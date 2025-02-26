@extends('adm.adm-default')

@section('title', 'Presupuester - Iniciar sesión')
@section('content')
<div class="page page-center">
  <div class="container container-normal py-4">
    <div class="row align-items-center g-4">
      <div class="col-lg">
        <div class="container-tight">
          <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
          </div>
          <div class="card card-md">
            <div class="card-body">
              <h2 class="h2 text-center mb-4">Iniciar sesión en tu cuenta</h2>
              <form action="{{ route('login') }}" method="post" autocomplete="off" novalidate>
                @csrf
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" placeholder="tu@email.com" autocomplete="off">
                </div>
                <div class="mb-2">
                  <label class="form-label">
                    Contraseña
                    <span class="form-label-description">
                      <a href="./forgot-password.html">Olvide mi contraseña</a>
                    </span>
                  </label>
                  <div class="input-group input-group-flat">
                    <input type="password" name="pass" class="form-control"  placeholder="Tu contraseña"  autocomplete="off">
                    <span class="input-group-text">
                      <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                      </a>
                    </span>
                  </div>
                </div>
                <div class="mb-2">
                  <label class="form-check">
                    <input type="checkbox" class="form-check-input"/>
                    <span class="form-check-label">Mantener sesión iniciada</span>
                  </label>
                </div>
                <div class="form-footer">
                  <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="text-center text-secondary mt-3">
            ¿No tienes una cuenta? <a href="{{ route('sing-up') }}" tabindex="-1">Registrarme</a>
          </div>
        </div>
      </div>
      <div class="col-lg d-none d-lg-block">
        <img src="img/static/portada.svg" height="300" class="d-block mx-auto" alt="">
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  const passwordInput = document.getElementById('password');
  const togglePassword = document.getElementById('togglePassword');

  togglePassword.addEventListener('click', function () {
    // Cambiar el tipo de input
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;

    // Cambiar el ícono
    this.classList.toggle('fa-eye-slash');
  });
</script>
@endsection