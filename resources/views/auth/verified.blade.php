@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Email Verificado') }}</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ __('Tu email ha sido verificado correctamente.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection