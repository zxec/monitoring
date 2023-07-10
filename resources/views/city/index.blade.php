@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('form.cities') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-success" href="{{ route('city.create') }}">
                            <i class="fas fa-redo"></i>
                            {{ __('form.update') }}
                        </a>
                        <a class="btn btn-info" href="{{ route('city.export') }}">
                            <i class="far fa-file-excel"></i>
                        </a>
                    </div>
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
@endsection

@section('js')
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
@endsection
