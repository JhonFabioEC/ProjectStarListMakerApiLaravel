@extends('admin.TemplateAdmin')

@section('logo')
    <a class="navbar-brand" href="{{ route('welcome_user') }}">StarListMaker</a>
@endsection

@section('icono')
    <a class="nav-link {{ request()->is('user/profile*') ? 'active' : '' }} dropdown-toggle"
        href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <img class="icono" src="{{ asset('storage/users/persons/' . session('user_image')) }}"
            alt="{{ session('user_name') }}">
        {{ session('user_name') }}</a>
@endsection

@section('menu')
    <li class="nav-item">
        <a class="nav-link {{ request()->is('user') ? 'active' : '' }}" href="{{ route('welcome_user') }}"
            aria-current="page"><i class="fa-solid fa-house"></i> Inicio <span class="visually-hidden">(current)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/orders*') ? 'active' : '' }}" href="{{ route('getOrders') }}"
        aria-current="page"><i class="fas fa-shopping-cart"></i> Mi lista</a>
    </li>
@endsection

@section('profile')
    <a class="dropdown-item {{ request()->is('user/profile*') ? 'active' : '' }}"
        href="{{ route('user_profile') }}"><i class="fa-solid fa-user-gear"></i> Ver perfil</a>
@endsection
