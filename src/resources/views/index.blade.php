@extends('layouts.main')

@section('content')
    <div class="main-section">
        <div class="main-section-header">
            ПРОДУКТЫ
        </div>
        <x-products-list :products="$products" />
    </div>
    <div class="right-menu-bar">
        <div class="d-flex justify-content-between right-menu-bar-header">
            <span>{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                {{ __('Выйти') }}
            </a>
        </div>


        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <div class="right-menu-bar-btn" id="openModal">
            Добавить
        </div>
    </div>
    <x-create-product-modal />

    <x-show-product-modal />

    <script src="/scripts/product_list.js"></script>
@endsection
