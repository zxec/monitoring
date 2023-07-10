@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body p-2">
                    <div class="col">
                        <div class="row mb-0">
                            <strong>{{__('monitorings.my_address')}}</strong>
                        </div>

                        <div class="row mt-2 px-2">
                            <a href="{{ route('monitorings.create') }}" class="btn btn-success p-1" style="width: 30%; margin-right: 5%">{{ __('monitorings.add') }}</a>
                            <a href="{{ route('monitorings.indexBid') }}" class="btn btn-primary p-1" style="width: 65%">{{ __('monitorings.add_from_request') }}</a>
                        </div>

                        <div class="col">
                            @foreach ($monitorings as $monitoring)
                                <div class="card mt-2" style="background-color: #d5d5d587">
                                    <div class="card-body p-2">
                                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $monitoring->dateFormat }}</h6>
                                        <div class="mb-0"><a href="{{ route('monitorings.edit', $monitoring) }}" class="text-decoration-none card-body cursor-pointer p-0">{{ $monitoring->street }} {{ $monitoring->house_number}}</a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
