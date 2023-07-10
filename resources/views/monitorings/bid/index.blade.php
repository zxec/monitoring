@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="col">
                            <div class="row mb-0">
                                <strong>{{ __('monitorings.add_address_from_request') }}</strong>
                            </div>
                            <div class="row mt-3">
                                <p>{{ __('monitorings.choose_request') }}:</p>
                            </div>
                            @if(count($ordersCompleted) > 0 || count($ordersPostponed) > 0)
                            <div class="col">
                                <div class="row mb-3 mt-2">
                                    <strong>{{ __('monitorings.in_work') }}</strong>
                                </div>
                                @if (count($ordersCompleted) > 0)
                                    @foreach ($ordersCompleted as $order)
                                        <div class="card mt-2" style="background-color: #d5d5d587">
                                            <a href="{{route('monitorings.createFromBid', ['bid'=> $order->id])}}" data-toggle="tooltip"
                                                class="text-decoration-none card-body px-2 py-1 cursor-pointer">
                                                <p class="my-0 py-0" style="font-size: 13px;">
                                                    {{ __('monitorings.request') . ' №' . $order->id }}</p>
                                            </a>
                                            @if (!empty($order->adress))
                                                <div class="my-0 px-2 py-1">{{ $order->adress }}</div>
                                            @else
                                                <div class="mb-0 px-2 py-1 text-danger">
                                                    {{ __('monitorings.address_not_specified') }}</div>
                                            @endif
                                            @if (!empty($order->service))
                                                <p class="text-secondary px-2 py-1 m-0">{{ $order->service->name }}</p>
                                            @else
                                                <p class="text-danger px-2 py-1 m-0">
                                                    {{ __('monitorings.service_not_specified') }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-secondary px-2 py-1 m-0">{{ __('monitorings.no_request') }}</p>
                                @endif
                            </div>
                            <div class="col">
                                <div class="row mb-3 mt-3">
                                    <strong class="text-sm text-lg">{{ __('monitorings.postponed') }}</strong>
                                </div>

                                @if (count($ordersPostponed) > 0)
                                    @foreach ($ordersPostponed as $order)
                                        <div class="card mt-2" style="background-color: #d5d5d587">
                                            <a href="{{route('monitorings.createFromBid', ['bid'=> $order->id])}}" data-toggle="tooltip"
                                                class="text-decoration-none card-body px-2 py-1 cursor-pointer">
                                                <p class="my-0 py-0" style="font-size: 13px;">
                                                    {{ __('monitorings.request') . ' №' . $order->id }}</p>
                                            </a>
                                            @if (!empty($order->adress))
                                                <div class="my-0 px-2 py-1">{{ $order->adress }}</div>
                                            @else
                                                <div class="mb-0 px-2 py-1 text-danger">
                                                    {{ __('monitorings.address_not_specified') }}</div>
                                            @endif
                                            @if (!empty($order->service))
                                                <p class="text-secondary p-2 py-1 m-0">{{ $order->service->name }}</p>
                                            @else
                                                <p class="text-danger px-2 py-1 m-0">
                                                    {{ __('monitorings.service_not_specified') }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-secondary px-2 py-1 m-0">{{ __('monitorings.no_request') }}</p>
                                @endif
                            </div>
                            @else
                            <p class="text-secondary px-2  m-0">{{ __('monitorings.you_dont_have_request') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
