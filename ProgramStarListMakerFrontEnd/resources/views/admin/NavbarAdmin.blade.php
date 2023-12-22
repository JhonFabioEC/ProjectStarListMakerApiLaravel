@extends('admin.TemplateAdmin')

@section('logo')
    <a class="navbar-brand" href="{{ route('welcome_admin') }}">StarListMaker</a>
@endsection

@section('icono')
    <a class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }} dropdown-toggle"
        href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <img class="icono" src="{{ asset('storage/users/persons/' . session('user_image')) }}"
            alt="{{ session('user_name') }}">
        {{ session('user_name') }}</a>
@endsection

@section('menu')
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('welcome_admin') }}"
            aria-current="page"><i class="fa-solid fa-house"></i> Inicio <span class="visually-hidden">(current)</span></a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link {{ request()->is('admin/management/*') ? 'active' : '' }} dropdown-toggle" href="#" id="dropdownId"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-gear"></i>
            Administrador</a>
        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownId">
            <a class="dropdown-item {{ request()->is('admin/management/establishment_types') ? 'active' : '' }}"
                href="{{ route('establishment_types.index') }}"><i class="fa-solid fa-shop"></i> Tipo de
                establecimientos</a>
            <a class="dropdown-item  {{ request()->is('admin/management/categories') ? 'active' : '' }}"
                href="{{ route('categories.index') }}"><i class="fas fa-star"></i> Categorias</a>
            <a class="dropdown-item {{ request()->is('admin/management/brands') ? 'active' : '' }}"
                href="{{ route('brands.index') }}"><i class="fa-solid fa-tag"></i> Marcas</a>
            <a>
                <hr class="dropdown-divider">
            </a>
            <a class="dropdown-item {{ request()->is('admin/management/user_accounts') ? 'active' : '' }}"
                href="{{ route('user_accounts.index') }}"><i class="fa-solid fa-users"></i> Cuentas de usuarios</a>
        </div>
    </li>
@endsection

@section('profile')
    <a class="dropdown-item {{ request()->is('admin/profile*') ? 'active' : '' }}"
        href="{{ route('admin_profile') }}"><i class="fa-solid fa-user-gear"></i> Ver perfil</a>
@endsection
