<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container d-block">
        <div class="col">
            <div class="row px-1 d-flex justify-content-between">
                <div class="col px-4">
                    <div class="row mb-0">
                        <strong class="p-0">@if(isset(auth()->user()->city->name)) г. {{ auth()->user()->city->name }} @endif</strong>
                    </div>
                    <div class="row">{{ auth()->user()->fio }}</div>
                </div>
                <div class="col">
                    <div class="col d-flex justify-content-end p-0">
                        <a class="" href="/"> {{ __('monitorings.to_main') }}</a>
                    </div>
                    <div class="col d-flex justify-content-end p-0">
                        <a class="" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('monitorings.logout') }}
                        </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
