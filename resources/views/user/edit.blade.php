@extends('adminlte::page')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            toastr()->error($error, __('flash.users'));
        @endphp
    @endforeach
@endif

@section('content')
    <div class="row">
        <div class="col-12 mt-3 d-flex justify-content-between">
            <div class="col-6 card mr-2">
                <div class="card-header">
                    <h2>{{ $title }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route($action['url'], isset($action['data']) ? $action['data'] : '') }}" method="POST">
                        @csrf
                        @isset($action['method'])
                            @method($action['method'])
                        @endisset
                        <div class="form-group">
                            <label for="name">{{ __('form.name') }}</label>
                            <input value="@isset($user){{ $user->name }}@endisset" type="text"
                                name="name" id="name" class="form-control @error('name')is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('form.email') }}</label>
                            <input value="@isset($user){{ $user->email }}@endisset" name="email"
                                type="text" id="email" class="form-control @error('email')is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('form.password') }}</label>
                            <input value="" name="password" type="password" id="password"
                                class="form-control @error('password')is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('form.password_confirmation') }}</label>
                            <input value="" name="password_confirmation" type="password" id="password_confirmation"
                                class="form-control @error('password_confirmation')is-invalid @enderror">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="department_id">{{ __('form.department') }}</label>
                            <select class="form-control form-select w-100 @error('department_id')is-invalid @enderror"
                                name="department_id" id="department_id">
                                <option selected disabled>{{ __('form.select_department') }}</option>
                                @foreach ($departments as $key => $department)
                                    <option value="{{ $key }}"
                                        @isset($user->department->id)
                                            {{ $user->department->id === $key ? ' selected' : '' }}
                                        @endisset>
                                        {{ $department }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="position_id">{{ __('form.position') }}</label>
                            <select class="form-control form-select w-100 @error('position_id')is-invalid @enderror"
                                name="position_id" id="position_id">
                                <option selected disabled>{{ __('form.select_position') }}</option>
                                @foreach ($positions as $key => $position)
                                    <option value="{{ $key }}"
                                        @isset($user->position->id)
                                            {{ $user->position->id === $key ? ' selected' : '' }}
                                        @endisset>
                                        {{ $position }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gender_id">{{ __('form.gender') }}</label>
                            <select class="form-control form-select w-100 @error('gender_id')is-invalid @enderror"
                                name="gender_id" id="gender_id">
                                <option selected disabled>{{ __('form.select_gender') }}</option>
                                @foreach ($genders as $key => $gender)
                                    <option value="{{ $key }}"
                                        @isset($user->gender->id)
                                            {{ $user->gender->id === $key ? ' selected' : '' }}
                                        @endisset>
                                        {{ $gender }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gender_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role_id">{{ __('form.role') }}</label>
                            <select class="form-control form-select w-100  @error('role_id')is-invalid @enderror"
                                name="role_id" id="role_id">
                                <option selected disabled>{{ __('form.select_role') }}</option>
                                @foreach ($roles as $key => $role)
                                    <option value="{{ $key }}"
                                        @isset($user)
                                            @if ($user->hasRole($key)) {{ ' selected' }} @endif
                                        @endisset>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_id">{{ __('form.status') }}</label>
                            <select class="form-control form-select w-100  @error('status_id')is-invalid @enderror"
                                name="status_id" id="status_id">
                                <option selected disabled>{{ __('form.select_status') }}</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}"
                                        @isset($user->status->id)
                                            {{ $user->status->id === $key ? ' selected' : '' }}
                                        @endisset>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group m-0">
                            <button type="submit" class="btn btn-primary">{{ $submitButton }}</button>
                        </div>
                    </form>
                </div>
            </div>
            @isset($logs)
                <div class="col-6 card">
                    <div class="card-header">
                        <h2>{{ __('log.timeline') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($logs as $log)
                                <div class="time-label">
                                    <span class="bg-blue">{{ $log->updated_at->format('d.m.Y') }}</span>
                                </div>
                                <div>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i>
                                            {{ $log->updated_at->format('H:i:s') }}</span>
                                        <h3 class="timeline-header">{{ __('log.' . $log->description) }}</h3>
                                        <div class="timeline-body">
                                            <ul class="list-group">
                                                @foreach ($log->properties['attributes'] as $key => $property)
                                                    <li class="list-group-item">
                                                        {{ __('log.' . $key) }}
                                                        с <strong>
                                                            @isset($log->properties['old'][$key])
                                                                {{ $log->properties['old'][$key] }}
                                                            @endisset
                                                        </strong> на
                                                        <strong>{{ $property }}</strong>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
@endsection
