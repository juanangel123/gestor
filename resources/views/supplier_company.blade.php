@extends('layouts.app')

@section('content')
    <div class="container supplier-company">


        <!-- Messages -->
        @include('layouts.messages')


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @if (isset($supplierCompany))
                        <div class="panel-heading">Modificando empresa suministradora {{ $supplierCompany->getName() }}</div>
                    @else
                        <div class="panel-heading">Crear empresa suministradora</div>
                    @endif


                    @if (isset($supplierCompany))
                        <div class="panel-actions">
                            <form id="delete-form" role="form" method="POST" action="{{ url('/supplier-companies/delete/' . $supplierCompany->getId()) }}">
                                {{ csrf_field() }}

                                <button type="submit" class="btn btn-default delete-action">
                                    Eliminar empresa suministradora
                                </button>
                            </form>
                        </div>
                    @endif


                    <div class="panel-body">

                        <form id="supplier-company-form" role="form" method="POST" action="{{ url('/supplier-companies/save') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ isset($supplierCompany) ? $supplierCompany->getId() : "" }}" />


                            <!-- Supplier company data -->
                            <h4>Datos de la empresa suministradora</h4>
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ isset($supplierCompany) ? $supplierCompany->getName() : "" }}" required />
                            </div>


                            <!-- Address -->
                            <div class="form-group address-container">
                                <h4>Dirección</h4>
                                @include('address', ['prefix' => '', 'address' => isset($supplierCompany) ? $supplierCompany->getAddress() : null])
                            </div>


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