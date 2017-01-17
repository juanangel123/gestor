{{--*/
if ($prefix) :
    $prefix .= "-";
endif;
/*--}}

<div class="form-group address-main-data">
    <div class="row">
        <div class="col-md-6">
            <label for="line">Dirección:</label>
            <input type="text" class="form-control" id="line" name="{{ $prefix }}address-line" value="{{ isset($address) ? $address->getLine() : "" }}" />
        </div>

        <div class="col-md-6">
            <label for="{{ $prefix }}post-code">Código postal:</label>
            <input type="text" class="form-control" id="{{ $prefix }}address-post-code" name="{{ $prefix }}address-post-code" value="{{ isset($address) ? $address->getPostcode() : "" }}"/>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label for="{{ $prefix }}locality">Localidad:</label>
            <input type="text" class="form-control" id="{{ $prefix }}address-locality" name="{{ $prefix }}address-locality" value="{{ isset($address) ? $address->getLocality() : "" }}"/>
        </div>

        <div class="col-md-6">
            <label for="{{ $prefix }}province">Provincia:</label>
            <select
                class="form-control province"
                id="{{ $prefix }}address-province"
                name="{{ $prefix }}address-province">
                <option value="" selected disabled>Seleccionar provincia</option>

                @foreach ($provinces as $province)
                    <option value="{{ $province->getId() }}" {{ isset($address) && $address->getProvince() && $address->getProvince()->getId() == $province->getId() ? "selected" : "" }}>
                        {{ $province }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

