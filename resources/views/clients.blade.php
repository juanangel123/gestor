@extends('layouts.app')

@section('content')
<div id="clients" class="container">


    <!-- Messages -->
    @include('layouts.messages')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">Clientes</div>

                <div class="panel-actions">
                    <a class="btn btn-default" href="{{ url('/clients/create') }}">
                        Crear cliente
                    </a>
                </div>

                <div class="panel-body">

                    <table id="data-table" class="common-table clients" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Móvil</th>
                                <th>Email</th>
                                <th>Dirección</th>
                                <th>NIF/CIF</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Móvil</th>
                                <th>Email</th>
                                <th>Dirección</th>
                                <th>NIF/CIF</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @foreach ($clients as $client)
                            <tr data-href="{{ url('/clients/edit/' . $client->getId()) }}">
                                <td>{{ $client->getName() }}</td>
                                <td>{{ $client->getMobile() }}</td>
                                <td>{{ $client->getEmail() }}</td>
                                <td>{{ $client->getAddress() }}</td>
                                <td>{{ $client->getVatId() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
