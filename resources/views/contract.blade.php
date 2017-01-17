@extends('layouts.app')

@section('content')
    <div class="container">


        <!-- Messages -->
        @include('layouts.messages')


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @if (isset($contract))
                        <div class="panel-heading">Modificando contrato {{ $contract }}</div>
                    @else
                        <div class="panel-heading">Crear nuevo contrato</div>
                    @endif


                    @if (isset($contract))
                        <div class="panel-actions">
                            <form id="delete-form" role="form" method="POST" action="/contracts/delete/{{ $contract->getId() }}">
                                {{ csrf_field() }}

                                <button type="submit" class="btn btn-default delete-action">
                                    Eliminar contrato
                                </button>
                            </form>
                        </div>
                    @endif


                    <div class="panel-body">

                        <form id="contract-form" role="form" method="POST" action="{{ url('/contracts/save') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ isset($contract) ? $contract->getId() : "" }}" />

                            @if (! isset($contract))
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-checkbox">
                                            <input type="checkbox" id="put-contract-data" name="put-contract-data" />
                                            Crear contrato a partir de otro (seleccionado)
                                        </label>
                                    </div>

                                    <div class="col-md-6 select-contract" style="display: none;">
                                        <label for="contract-type">Seleccionar contrato:</label>
                                        <select class="form-control" id="contract-copy" name="contract-copy">
                                            <option value="" selected disabled>Seleccionar contrato</option>

                                            @foreach ($contracts as $contractCopy)
                                                <option value="{{ $contractCopy->getId() }}">
                                                    {{ $contractCopy->getClient()->getName() . " - " . $contractCopy->getCUPS() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Contract data -->
                            <h4>Datos del contrato</h4>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="date">Fecha:</label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ isset($contract) ? $contract->getDateWithFormat('Y-m-d') : "" }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="contract-type">Tarifa:</label>
                                        <select class="form-control" id="contract-type" name="contract-type" required>
                                            <option value="" selected disabled>Seleccionar tarifa</option>

                                            @foreach ($contractTypes as $contractType)
                                                <option value="{{ $contractType }}" {{ isset($contract) && $contract->getTariff()->value() == $contractType ? "selected" : "" }}>
                                                    {{ (new \App\Models\Tariff($contractType))->getName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="date">CUPS:</label>
                                        <input type="text" class="form-control" id="cups" name="cups" value="{{ isset($contract) ? $contract->getCUPS() : "" }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="date">Potencia(s) contratadas:</label>
                                <div class="row">
                                    @if (! isset($pwcs))
                                        @foreach (range(0, 5) as $number)
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="pwc-<?php echo $number ?>" name="pwc-<?php echo $number ?>" value="" />
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Pwcs stored -->
                                        @foreach ($pwcs as $index => $pwc)
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="pwc-<?php echo $index ?>" name="pwc-<?php echo $index ?>" value="{{ $pwc->getTotal() }}" />
                                            </div>
                                        @endforeach

                                        <!-- The rest of pwcs -->
                                        @for ($index = count($pwcs); $index < 6; $index++)
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="pwc-<?php echo $index ?>" name="pwc-<?php echo $index ?>" value="" />
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="date">Media de consumo (anual):</label>
                                        <input type="text" class="form-control" id="mean_consuption" name="mean_consuption" value="{{ isset($contract) ? $contract->getMeanConsuption() : "" }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-checkbox">
                                            <input type="checkbox" id="comission-paid" name="comission-paid" {{ isset($contract) && $contract->isComissionPaid() ? "checked" : "" }} />
                                            Comisión cobrada
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Cliente:</label>

                                @if (isset($client))
                                <input type="hidden" name="client" value="{{ $client->getId() }}" />
                                <input type="text" class="form-control" name="dummy" value="{{ $client }}" readonly />
                                @else
                                <select class="form-control" id="client" name="client" required>
                                    <option value="" selected disabled>Seleccionar cliente</option>

                                    @foreach ($clients as $client)
                                        <option value="{{ $client->getId() }}" {{ isset($contract) && $contract->getClient()->getId() == $client->getId() ? "selected" : "" }}>
                                            {{ $client }}
                                        </option>
                                    @endforeach
                                </select>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="supplier-company">Empresa suministradora:</label>

                                <select class="form-control" id="supplier-company" name="supplier-company" required>
                                    <option value="" selected disabled>Seleccionar empresa suministradora</option>

                                    @foreach ($supplierCompanies as $supplierCompany)
                                        <option value="{{ $supplierCompany->getId() }}" {{ isset($contract) && $contract->getSupplierCompany()->getId() == $supplierCompany->getId() ? "selected" : "" }}>
                                            {{ $supplierCompany }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Supply address -->
                            <div class="form-group address-container">
                                <h4>Dirección de suministro</h4>
                                @include('address', ['prefix' => 'supply', 'address' => isset($contract) ? $contract->getSupplyAddress() : null])
                            </div>


                            <!-- Documents -->
                            @if (isset($contract))
                            <div class="form-group">
                                <h4>Documentos</h4>
                                @include('documents', ['id' => isset($contract) ? $contract->getId() : '', 'baseUrl' => url('/documents/contract')])
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