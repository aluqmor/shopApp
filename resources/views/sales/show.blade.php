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
                <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        @foreach($sale->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->route) }}" 
                                    class="d-block w-100" 
                                    style="height: 400px; object-fit: contain" 
                                    alt="Imagen {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    @if($sale->images->count() > 1)
                        <button class="carousel-control-prev" type="button" 
                                data-bs-target="#productCarousel" 
                                data-bs-slide="prev"
                                style="background: rgba(0,0,0,0.3); width: 50px;">
                            <span class="carousel-control-prev-icon" 
                                aria-hidden="true"
                                style="width: 30px; height: 30px;"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" 
                                data-bs-target="#productCarousel" 
                                data-bs-slide="next"
                                style="background: rgba(0,0,0,0.3); width: 50px;">
                            <span class="carousel-control-next-icon" 
                                aria-hidden="true"
                                style="width: 30px; height: 30px;"></span>
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
                    <h3 class="text-primary mb-4">€{{ number_format($sale->price, 0, ',', '.') }}</h3>
                    
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
                        @if(Auth::id() != $sale->user_id && !$sale->isSold)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buyModal">
                                <i class="fas fa-envelope"></i> Comprar
                            </button>
                        @endif
                        
                        @if(Auth::id() == $sale->user_id)
                            @if($sale->isSold)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Producto vendido
                                </div>
                            @endif
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('¿Estás seguro de eliminar este anuncio?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="buyModalLabel">Confirmar Compra</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas comprar "{{ $sale->product }}" por €{{ number_format($sale->price, 0, ',', '.') }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('sales.purchase', $sale->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Confirmar Compra</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection