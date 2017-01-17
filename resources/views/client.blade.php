@extends('layouts.app')

@section('content')
<div class="container">


    <!-- Messages -->
    @include('layouts.messages')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                @if (isset($client))
                <div class="panel-heading">Modificando cliente {{ $client->getName() }}</div>
                @else
                <div class="panel-heading">Crear nuevo cliente</div>
                @endif


                @if (isset($client))
                <div class="panel-actions">
                    <form id="delete-form" role="form" method="POST" action="{{ url('/clients/delete/' . $client->getId()) }}">
                        {{ csrf_field() }}

                        <button type="submit" class="btn btn-default delete-action">
                            Eliminar cliente
                        </button>
                    </form>

                    <a class="btn btn-default" href="{{  url('/contracts/create/' . $client->getId()) }}">
                        Crear contrato para este cliente
                    </a>
                </div>
                @endif

                <div class="panel-body">

                    <!-- Contracts table -->
                    @if (isset($client))
                    <h4>Contratos del cliente</h4>
                    @include('contracts_table', ['contracts' => $clientContracts, 'showClient' => false])
                    @endif

                    <form id="client-form" role="form" method="POST" action="{{ url('/clients/save') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{ isset($client) ? $client->getId() : "" }}" />

                        <!-- Client data -->
                        <h4>Datos de cliente</h4>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Nombre completo:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ isset($client) ? $client->getName() : "" }}" required />
                                </div>

                                <div class="col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ isset($client) ? $client->getEmail() : "" }}" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="telephone">Teléfono:</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ isset($client) ? $client->getTelephone() : "" }}" />
                                </div>

                                <div class="col-md-6">
                                    <label for="mobile">Móvil:</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ isset($client) ? $client->getMobile() : "" }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="client-type">Tipo de cliente:</label>
                                    <select class="form-control" id="client-type" name="client-type" required>
                                        <option value="" selected disabled>Seleccionar tipo de cliente</option>

                                        @foreach ($clientTypes as $clientType)
                                            <option value="{{ $clientType }}" {{ isset($client) && $client->getClientType()->value() == $clientType ? "selected" : "" }}>
                                                {{ (new \App\Models\ClientType($clientType))->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="vat-id">NIF/CIF:</label>
                                    <input type="text" class="form-control" id="vat-id" name="vat-id" value="{{ isset($client) ? $client->getVatId() : "" }}" />
                                </div>
                            </div>
                        </div>


                        <!-- Address -->
                        <div class="form-group address-container">
                            <h4>Dirección</h4>
                            @include('address', ['prefix' => '', 'address' => isset($client) ? $client->getAddress() : null])
                        </div>


                        <!-- Documents -->
                        @if (isset($client))
                            <div class="form-group">
                                <h4>Documentos</h4>
                                @include('documents', ['id' => isset($client) ? $client->getId() : '', 'baseUrl' => url('/documents/client')])
                            </div>
                        @endif


                        <button type="submit" class="btn btn-default">
                            Guardar
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
