@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Anuncios</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $sale->product }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                @if($sale->images->isNotEmpty())
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($sale->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->route) }}" 
                                         class="d-block w-100" style="height: 400px; object-fit: contain" 
                                         alt="Imagen {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        @if($sale->images->count() > 1)
                            <button class="carousel-control-prev" type="button" 
                                    data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" 
                                    data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        @endif
                    </div>
                @else
                    <img src="{{ asset('images/default-thumbnail.jpg') }}" 
                         class="card-img-top" style="height: 400px; object-fit: contain" 
                         alt="Sin imagen">
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $sale->product }}</h2>
                    <h3 class="text-primary mb-4">${{ number_format($sale->price, 2) }}</h3>
                    
                    <div class="mb-4">
                        <h5>Descripción</h5>
                        <p class="card-text">{{ $sale->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Detalles</h5>
                        <ul class="list-unstyled">
                            <li><strong>Categoría:</strong> {{ $sale->category->name }}</li>
                            <li><strong>Vendedor:</strong> {{ $sale->user->name }}</li>
                            <li><strong>Publicado:</strong> {{ $sale->created_at->format('d/m/Y') }}</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="fas fa-envelope"></i> Contactar Vendedor
                        </button>
                        @if(Auth::id() == $sale->user_id)
                            <a href="{{ route('sales.edit', $sale->id) }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-edit"></i> Editar Anuncio
                            </a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('¿Estás seguro de eliminar este anuncio?')">
                                    <i class="fas fa-trash"></i> Eliminar Anuncio
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection