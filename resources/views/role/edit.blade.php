@extends('adminlte::page')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            toastr()->error($error, __('flash.roles'));
        @endphp
    @endforeach
@endif

@section('content')
    <div class="row">
        <div class="col-6 mt-3">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route($action['url'], isset($action['data']) ? $action['data'] : '') }}" method="POST"
                        class="form">
                        @csrf
                        @isset($action['method'])
                            @method($action['method'])
                        @endisset
                        <div class="form-group">
                            <label for="name">{{ __('form.title') }}</label>
                            <input value="@isset($role){{ $role->name }}@endisset" type="text"
                                name="name" id="name" class="form-control @error('name')is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        @foreach ($configPermissions as $configPermissionKey => $configPermission)
                            <div class="form-group select2-primary">
                                <label
                                    for="{{ $configPermissionKey }}_permissions_list">{{ __('form.' . $configPermissionKey . '_permissions') }}</label>
                                <select
                                    class="form-select w-100 @error($configPermissionKey . '_permissions[]')is-invalid @enderror"
                                    name="{{ $configPermissionKey }}_permissions[]"
                                    id="{{ $configPermissionKey }}_permissions_list" multiple
                                    aria-label="multiple select example">
                                    @foreach ($configPermission as $permission)
                                        <option value="{{ $permissions[$permission . ' ' . $configPermissionKey] }}"
                                            @isset($role)
                                            {{ $role->permissions->contains($permissions[$permission . ' ' . $configPermissionKey]) ? ' selected' : '' }}
                                        @endisset>
                                            {{ __('permissions.' . $permission . ' ' . $configPermissionKey) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error($configPermissionKey . '_permissions[]')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        @endforeach
                        <div class="form-group m-0">
                            <button type="submit" class="btn btn-primary">{{ $submitButton }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#articles_permissions_list, #users_permissions_list, #departments_permissions_list, #positions_permissions_list, #roles_permissions_list, #statistics_permissions_list')
                .select2({
                    placeholder: "{{ __('form.select_permissions') }}"
                });
        });
    </script>
@endsection
