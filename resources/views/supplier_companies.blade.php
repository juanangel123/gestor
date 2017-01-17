@extends('layouts.app')

@section('content')
<div id="supplier-companies" class="container">


    <!-- Messages -->
    @include('layouts.messages')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">Empresas suministradoras</div>

                <div class="panel-actions">
                    <a class="btn btn-default" href="{{ url('/supplier-companies/create') }}">
                        Crear empresa suministradora
                    </a>
                </div>

                <div class="panel-body">

                    <table id="data-table" class="common-table supplier-companies" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @foreach ($supplierCompanies as $supplierCompany)
                            <tr data-href="{{ url('/supplier-companies/edit/' . $supplierCompany->getId()) }}">
                                <td>{{ $supplierCompany->getName() }}</td>
                                <td>{{ $supplierCompany->getAddress() }}</td>
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
