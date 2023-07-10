@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('form.roles') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @can('create roles')
                            <a class="btn btn-success" href="{{ route('role.create') }}">
                                <i class="fa fa-plus"></i>
                                {{ __('form.create') }}
                            </a>
                        @endcan
                        <a class="btn btn-info" href="{{ route('role.export') }}">
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

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.min.css">
@endsection

@section('js')
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    @stack('scripts')
@endsection
