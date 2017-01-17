@extends('layouts.app')

@section('content')
    <div id="alerts" class="container">


        <!-- Messages -->
        @include('layouts.messages')


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading">Alertas</div>


                    <div class="panel-body">

                        <table id="data-table" class="common-table clients" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Contrato</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Contrato</th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @foreach ($alerts as $alert)
                                <tr>
                                    <td>{{ $alert->getDateWithFormat() }}</td>
                                    <td>{{ $alert->getType()->getName() }}</td>
                                    <td>{{ $alert->getContract() }}</td>
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
