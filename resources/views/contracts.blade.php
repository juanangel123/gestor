@extends('layouts.app')

@section('content')
<div id="contracts" class="container">


    <!-- Messages -->
    @include('layouts.messages')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Contratos</div>

                <div class="panel-actions">
                    <a class="btn btn-default" href="{{ url('/contracts/create') }}">
                        Crear contrato
                    </a>
                </div>

                <div class="panel-body">

                    <!-- Contracts table -->
                    @include('contracts_table', ['showClient' => true])

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
