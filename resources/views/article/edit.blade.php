@extends('adminlte::page')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            toastr()->error($error, __('flash.articles'));
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
                    <form action="{{ route($action['url'], isset($action['data']) ? $action['data'] : '') }}" method="POST">
                        @csrf
                        @isset($action['method'])
                            @method($action['method'])
                        @endisset
                        <div class="form-group">
                            <label for="title">{{ __('form.title') }}</label>
                            <input value="@isset($article){{ $article->title }}@endisset" type="text"
                                name="title" id="title" class="form-control @error('title')is-invalid @enderror">
                            @error('title')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="body">{{ __('form.text') }}</label>
                            <textarea rows="10" name="body" id="text" class="form-control @error('body')is-invalid @enderror">
@isset($article)
{{ $article->body }}
@endisset
</textarea>
                            @error('body')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="published_at">{{ __('form.published_at') }}</label>
                            <input value="@isset($article){{ $article->published_at }}@endisset"
                                type="date" name="published_at" id="published_at"
                                class="form-control @error('published_at')is-invalid @enderror">
                            @error('published_at')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group select2-primary">
                            <label for="tag_list">{{ __('form.tags') }}</label>
                            <select class="form-select w-100 @error('tags[]')is-invalid @enderror" name="tags[]"
                                id="tag_list" multiple aria-label="multiple select example">
                                @foreach ($tags as $key => $tag)
                                    <option value="{{ $key }}"
                                        @isset($article)
                                            {{ $article->tags->contains($key) ? ' selected' : '' }}
                                        @endisset>
                                        {{ $tag }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tags[]')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group m-0">
                            <button type="submit" class="btn btn-primary">{{ $submitButton }}</button>
                        </div>
                    @section('footer')
                        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
                            crossorigin="anonymous"></script>
                        <script>
                            $(document).ready(function() {
                                $('#tag_list').select2({
                                    placeholder: "{{ __('form.select_tags') }}"
                                });
                            });
                            // $('#tag_list').select2({
                            //     placeholder: 'Choose a tag',
                            //     // tags: true,
                            //     // ajax: {
                            //     //     dataType: 'json',
                            //     //     url: 'api/tags',
                            //     //     delay: 250,
                            //     //     data: function(params) {
                            //     //         return {
                            //     //             q: params.term
                            //     //         }
                            //     //     },
                            //     //     processResult: function($data) {
                            //     //         return {
                            //     //             results: data
                            //     //         }
                            //     //     }
                            //     // }
                            // });
                        </script>
                    @endsection
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
