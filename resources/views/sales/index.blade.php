@extends('layouts.app') 

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Productos</h2>
    
    <div class="row">
        @foreach ($sales as $sale)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <!-- Miniatura del producto -->
                <img src="{{ asset('storage/' . $sale->image) }}" class="card-img-top" alt="Imagen del producto">

                <div class="card-body">
                    <h5 class="card-title">{{ $sale->product }}</h5>
                    <p class="card-text">{{ Str::limit($sale->description, 100) }}</p>
                    <p class="card-text"><strong>Precio:</strong> ${{ number_format($sale->price, 2) }}</p>
                    <p class="card-text"><strong>Categoría:</strong> {{ $sale->category->name }}</p>
                    <p class="card-text"><small class="text-muted">Publicado por: {{ $sale->user->name }}</small></p>

                    <!-- Enlace a los detalles del producto -->
                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-primary">Ver detalles</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection