@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="col">
                            <div class="row mb-0">
                                <strong>{{ __('monitorings.create.creating') }} /
                                    {{ __('monitorings.create.editing') }}</strong>
                            </div>
                            <form class="col mt-3" method="POST" action="{{ route('monitorings.update', $monitoring->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        name="city" id="city" value="{{ old('city', $monitoring->city) }}"
                                        placeholder="{{ __('monitorings.create.form.city') }}">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('street') is-invalid @enderror"
                                        name="street" value="{{ old('street', $monitoring->street) }}" id="street"
                                        placeholder="{{ __('monitorings.create.form.street') }}">
                                    @error('street')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('house_number') is-invalid @enderror"
                                        value="{{ old('house_number', $monitoring->house_number) }}" name="house_number"
                                        id="house_number" placeholder="{{ __('monitorings.create.form.house') }}">
                                    @error('house_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="date" class="form-control" name="date" id="date"
                                        value="{{ old('date', $monitoring->date) }}">
                                </div>
                                <hr />
                                <div class="col mb-3">
                                    <div class="card mt-2" style="background-color: #d5d5d587; font-size: .75rem">
                                        <div class="card-body p-1" id="container">
                                            <div class="d-flex justify-content-between flex-row mb-2">
                                                <strong>
                                                    {{ __('monitorings.create.form.entrance') }}
                                                </strong>
                                                <strong>
                                                    {{ __('monitorings.create.form.floors') }}
                                                </strong>
                                                <strong>
                                                    {{ __('monitorings.create.form.stickers') }}
                                                </strong>
                                                <strong>
                                                    {{ __('monitorings.create.form.competitor') }}
                                                </strong>
                                            </div>
                                            @for ($i = 1; $i <= old('countEntrances', $countEntrances); $i++)
                                                @if ($monitoring->entrances->contains('number', $i))
                                                    @php
                                                        $entrance = $monitoring->entrances->shift();
                                                    @endphp
                                                    <div class="d-flex justify-content-between flex-row align-center mb-2">
                                                        <div class="mb-1 form-check d-flex justify-content-center align-items-center"
                                                            style="width: 55px;">
                                                            <input type="checkbox" checked
                                                                class="form-check-input @error('entrances') border-danger @enderror"
                                                                name="entrances[]" id="entrance{{ $i }}"
                                                                value="{{ $i }}">
                                                            <label class="form-check-label mt-1 ms-1"
                                                                for="entrance{{ $i }}">{{ $i }}
                                                                {{ __('monitorings.create.form.short_entrance') }}</label>
                                                        </div>
                                                        <div class="mb-1" style="width: 60px;">
                                                            <input type="number" class="form-control p-1" name="floors[]"
                                                                id="floors{{ $i }}" placeholder="0"
                                                                value="{{ old('floors.' . $i - 1, $entrance->floor) }}">
                                                        </div>
                                                        <div class="mb-1" style="width: 60px;">
                                                            <input type="number" class="form-control p-1" name="stickers[]"
                                                                id="stickers{{ $i }}" placeholder="0"
                                                                value="{{ old('stickers.' . $i - 1, $entrance->sticker) }}">
                                                        </div>
                                                        <div class="mb-1 form-check d-flex justify-content-center align-items-center"
                                                            style="width: 55px;">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="competitors[]"
                                                                @if ($entrance->competitor) checked @endif
                                                                id="competitor{{ $i }}"
                                                                value="{{ $i }}">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-between flex-row align-center mb-2">
                                                        <div class="mb-1 form-check d-flex justify-content-center align-items-center"
                                                            style="width: 55px;">
                                                            <input type="checkbox"
                                                                class="form-check-input @error('entrances') border-danger @enderror"
                                                                name="entrances[]" id="entrance{{ $i }}"
                                                                value="{{ $i }}"
                                                                {{ old('entrances') && in_array($i, old('entrances')) ? 'checked' : '' }}>
                                                            <label class="form-check-label mt-1 ms-1"
                                                                for="entrance{{ $i }}">{{ $i }}
                                                                {{ __('monitorings.create.form.short_entrance') }}</label>
                                                        </div>
                                                        <div class="mb-1" style="width: 60px;">
                                                            <input type="number" class="form-control p-1" name="floors[]"
                                                                id="floors{{ $i }}" placeholder="0"
                                                                step="1" value="{{ old('floors.' . $i - 1, 0) }}">
                                                        </div>
                                                        <div class="mb-1" style="width: 60px;">
                                                            <input type="number" class="form-control p-1"
                                                                name="stickers[]" id="stickers{{ $i }}"
                                                                placeholder="0" min="0" step="1"
                                                                value="{{ old('stickers.' . $i - 1, 0) }}">
                                                        </div>
                                                        <div class="mb-1 form-check d-flex justify-content-center align-items-center"
                                                            style="width: 55px;">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="competitors[]" id="competitor{{ $i }}"
                                                                value="{{ $i }}"
                                                                {{ old('competitors') && in_array($i, old('competitors')) ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endfor
                                            <input type="hidden" id="countEntrances" name="countEntrances"
                                                value="{{ old('countEntrances', $countEntrances) }}">
                                            <input type="hidden" name="latitude" id="latitude"
                                                value="{{ old('latitude', $monitoring->latitude) }}">
                                            <input type="hidden" name="longitude" id="longitude"
                                                value="{{ old('longitude', $monitoring->longitude) }}">
                                            <input type="hidden" name="order_id" id="order_id" value="{{ $monitoring->order_id ?? old('order_id') }}">
                                            <button type="button" id="add_entrance" onclick="addFields()"
                                                class="btn btn-secondary w-100">+
                                                {{ __('monitorings.create.form.add_entrance') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn btn-success w-100">{{ __('monitorings.create.form.save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>

    <script>
        var $city = $("#city");
        var $street = $("#street");
        var $house = $("#house_number");
        var $lat = $("#latitude");
        var $lon = $("#longitude");

        function join(arr /*, separator */ ) {
            var separator = arguments.length > 1 ? arguments[1] : ", ";
            return arr
                .filter(function(n) {
                    return n;
                })
                .join(separator);
        }

        function makeAddressString(address) {
            if (address.city === address.region) {
                return join([
                    address.city,
                    address.settlement,
                    address.street_with_type,
                    join(
                        [address.house_type, address.house, address.block_type, address.block],
                        " "
                    ),
                    join([address.flat_type, address.flat], " ")
                ]);
            } else {
                return join([
                    // address.region_with_type,
                    address.area_with_type,
                    address.city,
                    address.settlement,
                    address.street_with_type,
                    join(
                        [address.house_type, address.house, address.block_type, address.block],
                        " "
                    ),
                    join([address.flat_type, address.flat], " ")
                ]);
            }
        }

        function formatResult(value, currentValue, suggestion) {
            var addressValue = makeAddressString(suggestion.data);
            suggestion.value = addressValue;
            return addressValue;
        }

        function formatSelected(suggestion) {
            var addressValue = makeAddressString(suggestion.data);
            return addressValue;
        }

        // город
        $city.suggestions({
            token: "052360039b34d9a63b94be8b5fc39c11aa39cee0",
            type: "ADDRESS",
            hint: false,
            bounds: "city",
            formatResult: formatResult,
            formatSelected: formatSelected
        });

        // улица
        $street.suggestions({
            token: "052360039b34d9a63b94be8b5fc39c11aa39cee0",
            type: "ADDRESS",
            hint: false,
            bounds: "street",
            constraints: $city
        });

        // дом
        $house.suggestions({
            token: "052360039b34d9a63b94be8b5fc39c11aa39cee0",
            type: "ADDRESS",
            hint: false,
            noSuggestionsHint: false,
            bounds: "house",
            constraints: $street
        });

        $lat.suggestions({
            token: "052360039b34d9a63b94be8b5fc39c11aa39cee0",
            type: "ADDRESS",
            hint: false,
            noSuggestionsHint: false,
            bounds: "geo_lat",
            constraints: $house
        });

        $lon.suggestions({
            token: "052360039b34d9a63b94be8b5fc39c11aa39cee0",
            type: "ADDRESS",
            hint: false,
            noSuggestionsHint: false,
            bounds: "geo_lon",
            constraints: $house
        });

        let counter = {!! $countEntrances !!};
        counter++;
        console.log(counter);

        function addFields() {
            let container = document.getElementById("container");

            let div = document.createElement("div");
            div.className = "d-flex justify-content-between flex-row align-center mb-2";
            div.innerHTML = `
        <div class="mb-1 form-check d-flex justify-content-center align-items-center" style="width: 55px;">
            <input type="checkbox" class="form-check-input" name="entrances[]" id="entrance` + counter +
                `" value="` + counter + `">
            <label class="form-check-label mt-1 ms-1" for="entrance` + counter + `">` + counter + ` {{ __('monitorings.create.form.short_entrance') }}</label>
        </div>
        <div class="mb-1" style="width: 60px;">
            <input type="number" class="form-control p-1" name="floors[]" placeholder="0" value="0" step="1">
        </div>
        <div class="mb-1" style="width: 60px;">
            <input type="number" class="form-control p-1" name="stickers[]" placeholder="0" value="0" min="0" step="1">
        </div>
        <div class="mb-1 form-check d-flex justify-content-center align-items-center" style="width: 55px;">
            <input type="checkbox" class="form-check-input" name="competitors[]" id="competitor` + counter +
                `" value="` + counter + `">
        </div>
    `;
            const button = document.getElementById("add_entrance");
            container.insertBefore(div, button);
            counter++;
        }
    </script>
@endsection
