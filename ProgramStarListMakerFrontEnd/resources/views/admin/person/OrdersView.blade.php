@extends('admin.NavbarUser')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-8">
                @php
                    $total = 0;
                @endphp
                @foreach ($item_orders as $item_order)
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 d-flex gap-4 justify-content-center flex-wrap">
                            <div class="card shadow bg-body-tertiary rounded mb-3"
                                style="width: 100%; height: 200px; max-height: 200px;">
                                <div class="row g-0 d-flex align-content-center">
                                    <div class="col-3">
                                        <img src="{{ asset('storage/itemOrders/' . $item_order['image']) }}"
                                            class="card-img-overlay" alt="{{ $item_order['name'] }}"
                                            style="width: 200px; height: 200px;">
                                    </div>

                                    <div class="col-6">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $item_order['name'] }}</h4>
                                            <h6 class="card-text">Marca: {{ $item_order['brand'] }}</h6>
                                            <span class="card-text d-block">De:
                                                <strong>{{ $item_order['establishment'] }}</strong></span>

                                            <div class="mt-2">
                                                <button class="btn btn-danger"
                                                    onclick="window.location.href = '/user/orders/delete/{{ $item_order['id'] }}';"
                                                    title="Quitar">
                                                    <i class="fas fa-minus-circle nav-icon"></i> Quitar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="d-flex flex-column justify-content-end pe-3">
                                            <span class="card-text text-end d-block fs-3 mb-2 mt-2">
                                                ${{ $item_order['price'] }}</span>
                                            <span class="card-text text-end d-block fs-5 mb-2">
                                                Cantidad: {{ $item_order['quantity'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ $total +=  $item_order['price'] * $item_order['quantity'] }};
                @endforeach
            </div>
            <div class="col-4">
                <div class="card shadow bg-body-tertiary rounded">
                    <div class="card-header">
                        <h3 class="m-0 me-auto h-100">Resumen de orden</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <span class="card-text text-start d-block fs-5">
                                    Total: </span>
                            </div>
                            <div class="col-6">
                                <span class="card-text text-end d-block fs-5">
                                    {{ $total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function increase(id, max) {
            var value = parseInt($('#quantity' + id).val(), 10);
            if (value < max) {
                $('#quantity' + id).val(value + 1);
            }
        }

        function decrease(id, min) {
            var value = parseInt($('#quantity' + id).val(), 10);
            if (value > min) {
                $('#quantity' + id).val(value - 1);
            }
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire(
                'Exito!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Error!',
                '{{ session('error') }}',
                'error'
            )
        </script>
    @endif
@endsection
