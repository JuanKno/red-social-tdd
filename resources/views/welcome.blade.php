@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card border-0 bg-light">
                <form action="{{ route('status.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <textarea class="form-control border-0 bg-light" placeholder="¿Qué estás pensando Juan?" name="body" id="body"></textarea>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="create-status">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection