@php 
$userInfo = $data['userInfo'];
$fname = substr($userInfo['first_name'], 0, 1);
$lname = substr($userInfo['last_name'], 0, 1);
$avatar = $fname . $lname;
@endphp
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="." style="text-decoration: none;">
                <img src="/img/icons/icon-100.png" width="45" height="45" alt="Presupuester"> Presupuester
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ $userInfo['first_name'] ?? '' }} {{ $userInfo['last_name'] ?? ''}}</div>
                        <div class="mt-1 small text-secondary">UI Designer</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Status</a>
                    <a href="./profile.html" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Feedback</a>
                    <div class="dropdown-divider"></div>
                    <a href="./settings.html" class="dropdown-item">Settings</a>
                    <a href="./sign-in.html" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('welcome')}}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-home" width="50" height="50"></i>
                        </span>
                        <span class="nav-link-title">
                            Inicio
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('welcome')}}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                        <span class="nav-link-title">
                            Operaciones
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('accounts')}}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-wallet"></i>
                        </span>
                        <span class="nav-link-title">
                            Cuentas
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('welcome')}}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-wrench"></i>
                        </span>
                        <span class="nav-link-title">
                            Configuraciones
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block text-danger">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="nav-link-title bold text-danger">
                            Cerrar sesión
                        </span>
                    </a>
                </li>
            </ul>
            <div class="m-4">
                <a href="{{ route('user', ['id' => $userInfo['id']]) }}" class="nav-link d-flex lh-1 text-reset p-0">
                    <span class="avatar avatar-sm" style="background-image: url(https://api.dicebear.com/9.x/initials/svg?seed={{ $avatar }})"></span>
                    <div class="d-xl-block ps-2">
                        <div>{{ $userInfo['first_name'] ?? '' }} {{ $userInfo['last_name'] ?? ''}}</div>
                        <div class="mt-1 small text-secondary">Propietario</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</aside>