@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
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
                    <form id="calendarForm" name="calendarForm" class="form-horizontal">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="control-label">{{ __('form.title') }}</label>
                            <input type="text" class="form-control" id="name" name="title">
                            <div class="invalid-feedback"><strong id="error_title"></strong></div>
                        </div>
                        <div class="form-group">
                            <label for="start">{{ __('form.start_event') }}</label>
                            <input type="datetime-local" class="form-control datepicker" id="start" name="start">
                            <div class="invalid-feedback"><strong id="error_start"></strong></div>
                        </div>
                        <div class="form-group">
                            <label for="end">{{ __('form.end_event') }}</label>
                            <input type="datetime-local" class="form-control datepicker" id="end" name="end">
                            <div class="invalid-feedback"><strong id="error_end"></strong></div>
                        </div>
                        <input type="hidden" id="creator" name="creator" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="user_list">{{ __('form.employee') }}</label>
                            <select class="form-select form-control w-100 @error('user_id')is-invalid @enderror"
                                name="user_id" id="user_list" aria-label="select example">
                                @foreach ($users as $key => $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"><strong id="error_user_list"></strong></div>
                        </div>
                        <div class="form-check mb-3" id="checkbox">
                            <input class="form-check-input" type="checkbox" id="check" name="completed" value="0">
                            <label class="form-check-label" for="check">
                                {{ __('form.complete_event') }}
                            </label>
                        </div>
                        <div class="form-group mb-0"
                            style="display: flex;
                        flex-wrap: wrap;
                        justify-content: space-between;"
                            id="buttons">
                            <button type="button" class="btn btn-primary" id="saveBtn"
                                value="create">{{ __('form.save') }}
                            </button>
                            <button type="button" class="btn btn-primary d-none" id="editBtn"
                                value="edit">{{ __('form.save') }}
                            </button>
                            @role(['admin', 'manager'])
                                <button type="button" class="btn btn-danger d-none" id="delete"
                                    value="delete">{{ __('form.delete') }}
                                </button>
                            @endrole
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.min.css">
@endsection

@section('js')
    <script src="{{ asset('vendor/fullcalendar/locales-all.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                eventSources: [{
                    events: {!! $events !!},
                }],
                dateClick: function(info) {
                    if ({{ $role }}) {
                        $('#calendarForm')[0].reset();
                        $('#delete, #checkbox, #editBtn').addClass('d-none');
                        $('#saveBtn').removeClass('d-none');
                        $('#error_title, #error_start, #error_end, #error_user_list').html('');
                        $('#name, #start, #end, #user_list').removeClass('is-invalid');
                        $('#modelHeading').html("{{ __('form.new_event') }}");
                        $('#ajaxModel').modal('show');
                        $('#start').val(info.dateStr + 'T00:00');
                        $('#end').val(info.dateStr + 'T12:00');
                    }
                },
                eventClick: function(info) {
                    var event = info.event;
                    $('#calendarForm')[0].reset();
                    $('#error_title, #error_start, #error_end, #error_user_list').html('');
                    $('#name, #start, #end, #user_list').removeClass('is-invalid');
                    $('#modelHeading').html("{{ __('form.edit') }}");
                    $('#delete, #checkbox, #editBtn').removeClass('d-none');
                    $('#saveBtn').addClass('d-none');
                    $('#ajaxModel').modal('show');
                    $('#name').val(event.title);
                    document.
                    querySelector('#user_list').value = event.extendedProps.user_id;
                    $('#start').val(event.startStr.split('+')[0]);
                    $('#end').val(event.endStr.split('+')[0]);
                    $('#id').val(event.id);
                    $('#check').val(event.extendedProps.completed);
                    $('#creator').val(event.extendedProps.creator);
                    if (event.extendedProps.completed) {
                        document.getElementById("check").checked = true;
                    } else {
                        document.getElementById("check").checked = false;
                    }
                },
                eventDrop: function(info) {
                    e.preventDefault();
                    $.ajax({
                        data: {
                            'id': info.event.id,
                            'title': info.event.title,
                            'start': info.event.startStr,
                            'end': info.event.endStr,
                            'user_id': info.event.extendedProps.user_id,
                            'creator': info.event.extendedProps.creator,
                        },
                        url: "{{ route('calendar.store') }}" + '/' + info.event.id,
                        type: "PUT",
                        dataType: 'json',
                    });
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                themeSystem: 'bootstrap',
                locale: 'ru',
                buttonIcons: true,
                weekNumbers: true,
                navLinks: true,
                editable: true,
                droppable: true,
                dayMaxEvents: true,
            });
            calendar.render();

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#calendarForm').serialize(),
                    url: "{{ route('calendar.store') }}",
                    type: "POST",
                    success: function(data) {
                        $('#ajaxModel').modal('hide');
                    },
                    error: function(data) {
                        if (typeof data.responseJSON.errors.title !==
                            "undefined") {
                            $('#name').addClass("is-invalid");
                            $('#error_title').html(data.responseJSON
                                .errors
                                .title);
                        }
                        if (typeof data.responseJSON
                            .errors.start !== "undefined") {
                            $('#start').addClass("is-invalid");
                            $('#error_start').html(data.responseJSON
                                .errors.start);
                        }
                        if (typeof data.responseJSON
                            .errors.end !== "undefined") {
                            $('#end').addClass("is-invalid");
                            $('#error_end').html(data.responseJSON
                                .errors
                                .end);
                        }
                        if (typeof data.responseJSON
                            .errors.user_list !== "undefined") {
                            $('#user_list').addClass("is-invalid");
                            $('#error_user_list').html(data.responseJSON
                                .errors
                                .user_list);
                        }
                    }
                });
            });
            $('#editBtn').click(function(e) {
                e.preventDefault();
                if (document.getElementById("check").checked) {
                    $('#check').val(1);
                }
                // else {
                //     $('#ajaxModel').modal('hide');
                //     document.getElementById("check").checked = true;
                //     $('#check').val(0);
                // }
                var id = document.querySelector('#id').value;
                $.ajax({
                    data: $('#calendarForm').serialize(),
                    url: "{{ route('calendar.store') }}" + '/' + id,
                    type: "PUT",
                    success: function(data) {
                        $('#ajaxModel').modal('hide');
                    },
                    error: function(data) {
                        if (typeof data.responseJSON.errors.title !==
                            "undefined") {
                            $('#name').addClass("is-invalid");
                            $('#error_title').html(data.responseJSON.errors
                                .title);
                        }
                        if (typeof data.responseJSON
                            .errors.start !== "undefined") {
                            $('#start').addClass("is-invalid");
                            $('#error_start').html(data.responseJSON
                                .errors.start);
                        }
                        if (typeof data.responseJSON
                            .errors.end !== "undefined") {
                            $('#end').addClass("is-invalid");
                            $('#error_end').html(data.responseJSON.errors
                                .end);
                        }
                        if (typeof data.responseJSON
                            .errors.user_list !== "undefined") {
                            $('#user_list').addClass("is-invalid");
                            $('#error_user_list').html(data.responseJSON
                                .errors
                                .user_list);
                        }
                    }
                });
            });
            $('#delete').click(function(e) {
                var id = document.querySelector('#id').value;
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('calendar.store') }}" + '/' + id,
                    success: function(data) {
                        $('#ajaxModel').modal('hide');
                    },
                });
            });

            Echo.private('events')
                .listen('NewEventNotification', (e) => {
                    calendar.addEvent(e.event);
                })
                .listen('UpdateEventNotification', (e) => {
                    calendar.getEventById(e.event.id).remove();
                    calendar.addEvent(e.event);
                })
                .listen('DestroyEventNotification', (e) => {
                    calendar.getEventById(e.event).remove();
                });

        });
    </script>
@endsection
