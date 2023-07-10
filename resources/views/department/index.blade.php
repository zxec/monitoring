@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('form.departments') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @can('create departments')
                            <a class="btn btn-success" href="javascript:void(0)" id="createNewDepartment">
                                <i class="fa fa-plus"></i>
                                {{ __('form.create') }}
                            </a>
                        @endcan
                        <a class="btn btn-info" href="{{ route('department.export') }}">
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
                    <form id="departmentForm" name="departmentForm" class="form-horizontal">
                        <input type="hidden" name="department_id" id="department_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{ __('form.title') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" required>
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

            var table = $('#departments-table').DataTable();

            $('#createNewDepartment').click(function() {
                $('#saveBtn').removeClass("d-none");
                $('#saveBtn').val("create-department");
                $('#department_id').val('');
                $('#errors').html('');
                $('#name').removeClass('is-invalid');
                $('#editBtn').addClass('d-none');
                $('#name').val('');
                $('#modelHeading').html("{{ __('form.new_department') }}");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editDepartment', function() {
                var department_id = $(this).data('id');
                $.get("{{ route('department.index') }}" + '/' + department_id + '/edit', function(
                    data) {
                    $('#editBtn').removeClass("d-none");
                    $('#modelHeading').html("{{ __('form.edit') }}");
                    $('#name').removeClass('is-invalid');
                    $('#saveBtn').addClass('d-none');
                    $('#ajaxModel').modal('show');
                    $('#department_id').val(data.id);
                    $('#name').val(data.name);
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#departmentForm').serialize(),
                    url: "{{ route('department.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#name').val('');
                        $('#ajaxModel').modal('hide');
                        toastr.success("{{ __('flash.create_department') }}",
                            "{{ __('flash.departments') }}");
                        table.draw();
                    },
                    error: function(data) {
                        $('#name').addClass("is-invalid");
                        $('#errors').html(data.responseJSON.errors.name);
                        $('#saveBtn').html("{{ __('form.save') }}");
                        toastr.error(data.responseJSON.errors.name,
                            "{{ __('flash.departments') }}");
                    }
                });
            });

            $('#editBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#departmentForm').serialize(),
                    url: "{{ route('department.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#name').val('');
                        $('#ajaxModel').modal('hide');
                        toastr.success("{{ __('flash.edit_department') }}",
                            "{{ __('flash.departments') }}");
                        table.draw();
                    },
                    error: function(data) {
                        $('#name').addClass("is-invalid");
                        $('#errors').html(data.responseJSON.errors.name);
                        toastr.error(data.responseJSON.errors.name,
                            "{{ __('flash.departments') }}");
                    }
                });
            });

            $('body').on('click', '.deleteDepartment', function() {
                var department_id = $(this).data("id");
                if (confirm("{{ __('flash.confirm_delete_department') }}")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('department.store') }}" + '/' + department_id,
                        success: function(data) {
                            toastr.success("{{ __('flash.delete_department') }}",
                                "{{ __('flash.departments') }}");
                            table.draw();
                        },
                        error: function(data) {
                            toastr.error("{{ __('flash.fail_delete_department') }}",
                                "{{ __('flash.department') }}");
                        }
                    });
                }
            });
        });
    </script>
@endsection
