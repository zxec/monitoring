@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-6 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('form.articles') }}</h3>
                </div>
                <div class="card-body">
                    @foreach ($articles as $article)
                        <div class="mb-3">
                            <h2>
                                <a href="{{ route('article.show', $article->id) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <div class="body">
                                {{ $article->body }}
                            </div>
                        </div>
                    @endforeach
                </div>
                @can('create articles')
                    <div class="card-footer">
                        <h2>
                            <a href="{{ route('article.create') }}" class="btn btn-primary">{{ __('form.new_article') }}</a>
                        </h2>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
