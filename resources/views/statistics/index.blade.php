@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('form.statistics') }}</h3>
                </div>
                <div class="card-body">
                    <form class="w-25 mb-3" id="chartForm" name="calendarForm" class="form-horizontal">
                        <div class="form-group">
                            <label for="start">{{ __('form.start_interval') }}</label>
                            <input type="date" class="form-control datepicker" id="start" name="start_interval">
                            <div class="invalid-feedback"><strong id="error_start"></strong></div>
                        </div>
                        <div class="form-group">
                            <label for="end">{{ __('form.end_interval') }}</label>
                            <input type="date" class="form-control datepicker" id="end" name="end_interval">
                            <div class="invalid-feedback"><strong id="error_end"></strong></div>
                        </div>
                        <div class="form-group" id="buttons">
                            <button type="button" class="btn btn-primary" id="show">
                                {{ __('form.show') }}
                            </button>
                        </div>
                    </form>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $dates !!},
                datasets: [{
                        label: "{{ __('form.count_events') }}",
                        data: {!! $countEventsDay !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: "{{ __('form.count_completed_events') }}",
                        data: {!! $countCompletedEventsDay !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            },
        });
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#show').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#chartForm').serialize(),
                    url: "{{ route('statistics.store') }}",
                    type: "POST",
                    success: function(data) {
                        $('#error_start, #error_end').html('');
                        $('#start, #end').removeClass('is-invalid');
                        myChart.data.labels = data['dates'];
                        myChart.data.datasets = [{
                                label: "{{ __('form.count_events') }}",
                                data: data['countEventsDay'],
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: "{{ __('form.count_completed_events') }}",
                                data: data['countCompletedEventsDay'],
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ];
                        myChart.update();
                    },
                    error: function(data) {
                        console.log(data);
                        if (typeof data.responseJSON
                            .errors.start_interval !== "undefined") {
                            $('#start').addClass("is-invalid");
                            $('#error_start').html(
                                data.responseJSON.errors.start_interval);
                        }
                        if (typeof data.responseJSON
                            .errors.end_interval !== "undefined") {
                            $('#end').addClass("is-invalid");
                            $('#error_end').html(
                                data.responseJSON.errors.end_interval);
                        }
                    }
                });
            });
        });
    </script>
@endsection
