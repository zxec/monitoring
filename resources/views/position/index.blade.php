@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('form.positions') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @can('create positions')
                            <a class="btn btn-success" href="javascript:void(0)" id="createNewPosition">
                                <i class="fa fa-plus"></i>
                                {{ __('form.create') }}
                            </a>
                        @endcan
                        <a class="btn btn-info" href="{{ route('position.export') }}">
                            <i class="far fa-file-excel"></i>
                        </a>
                    </div>
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="positionForm" name="positionForm" class="form-horizontal" novalidate>
                        <input type="hidden" name="position_id" id="position_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{ __('form.title') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name">
                                <div class="invalid-feedback"><strong id="errors"></strong></div>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn"
                                value="create">{{ __('form.save') }}
                            </button>
                            <button type="submit" class="btn btn-primary" id="editBtn"
                                value="edit">{{ __('form.save') }}
                            </button>
                        </div>
                    </form>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('js')
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @stack('scripts')

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#positions-table').DataTable();

            $('#createNewPosition').click(function() {
                $('#saveBtn').removeClass("d-none");
                $('#saveBtn').val("create-position");
                $('#position_id').val('');
                $('#errors').html('');
                $('#name').removeClass('is-invalid');
                $('#editBtn').addClass('d-none');
                $('#name').val('');
                $('#modelHeading').html("{{ __('form.new_position') }}");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editPosition', function() {
                var position_id = $(this).data('id');
                $.get("{{ route('position.index') }}" + '/' + position_id + '/edit', function(
                    data) {
                    $('#editBtn').removeClass("d-none");
                    $('#modelHeading').html("{{ __('form.edit') }}");
                    $('#name').removeClass('is-invalid');
                    $('#saveBtn').addClass('d-none');
                    $('#ajaxModel').modal('show');
                    $('#position_id').val(data.id);
                    $('#name').val(data.name);
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#positionForm').serialize(),
                    url: "{{ route('position.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#name').val('');
                        $('#ajaxModel').modal('hide');
                        toastr.success("{{ __('flash.create_position') }}",
                            "{{ __('flash.positions') }}");
                        table.draw();
                    },
                    error: function(data) {
                        $('#name').addClass("is-invalid");
                        $('#errors').html(data.responseJSON.errors.name);
                        $('#saveBtn').html("{{ __('form.save') }}");
                        toastr.error(data.responseJSON.errors.name,
                            "{{ __('flash.positions') }}");
                    }
                });
            });

            $('#editBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#positionForm').serialize(),
                    url: "{{ route('position.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#name').val('');
                        $('#ajaxModel').modal('hide');
                        toastr.success("{{ __('flash.edit_position') }}",
                            "{{ __('flash.positions') }}");
                        table.draw();
                    },
                    error: function(data) {
                        $('#name').addClass("is-invalid");
                        $('#errors').html(data.responseJSON.errors.name);
                        toastr.error(data.responseJSON.errors.name,
                            "{{ __('flash.positions') }}");
                    }
                });
            });

            $('body').on('click', '.deletePosition', function() {
                var position_id = $(this).data("id");
                if (confirm("{{ __('flash.confirm_delete_position') }}")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('position.store') }}" + '/' + position_id,
                        success: function(data) {
                            toastr.success("{{ __('flash.delete_position') }}",
                                "{{ __('flash.positions') }}");
                            table.draw();
                        },
                        error: function(data) {
                            toastr.error("{{ __('flash.fail_delete_position') }}",
                                "{{ __('flash.positions') }}");
                        }
                    });
                }
            });
        });
    </script>
@endsection
