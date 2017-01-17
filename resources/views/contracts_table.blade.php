<table id="data-table" class="common-table contracts" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Fecha</th>
        @if ($showClient)
        <th>Cliente</th>
        @endif
        <th>CUPS</th>
        <th>Tipo</th>
        <th>Comisión cobrada</th>
        <th>Empresa suministradora</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>Fecha</th>
        @if ($showClient)
        <th>Cliente</th>
        @endif
        <th>CUPS</th>
        <th>Tipo</th>
        <th>Comisión cobrada</th>
        <th>Empresa suministradora</th>
    </tr>
    </tfoot>

    <tbody>
    @foreach ($contracts as $contract)
        <tr data-href="{{ url('/contracts/edit/' . $contract->getId()) }}" class="{{ $contract->isComissionPaid() ? "comission-paid" : "comission-not-paid" }}">
            <td>{{ $contract->getDateWithFormat() }}</td>
            @if ($showClient)
            <td>{{ $contract->getClient() }}</td>
            @endif
            <td>{{ $contract->getCUPS() }}</td>
            <td>{{ $contract->getTariff()->getName() }}</td>
            <td>{{ $contract->isComissionPaid() ? "Si" : "No" }}</td>
            <td>{{ $contract->getSupplierCompany() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>