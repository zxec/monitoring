@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-6 mt-3">
            <div class="card">
                <div class="card-header">
                    <h2>
                        <a href="@can('edit articles'){{ route('article.edit', $article->id) }}@endcan">
                            {{ $article->title }}
                        </a>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="body">
                        {{ $article->body }}
                    </div>
                    @unless ($article->tags->isEmpty())
                        <h5>{{ __('form.tags') }}</h5>
                        <ul>
                            @foreach ($article->tags as $tag)
                                <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    @endunless
                </div>
            </div>
        </div>
    </div>
@endsection
