@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Edit Document') }}</div>

                    <div class="card-body">
                        <form action="{{route('update.doc', $doc->id)}}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="nama lengkap" value="{{$doc->title}}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-12">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea type="content" class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="content" required>{{$doc->content}}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if (!empty($doc->signing))
                                    <img src="{{ asset('storage/document/'.$doc->signing) }}" class="rounded float-start" alt="..." style="width:250px;">
                                @else
                                    <img src="/assets/user_icon.png" class="rounded float-start" alt="..." style="width:250px;">
                                @endif
                                <div class="mb-3">
                                    <label for="signin">Signin</label>
                                    <input class="form-control form-control-sm @error('signin') is-invalid @enderror" id="signin" name="signin" type="file">
                                    @error('signin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <hr class="my-4">

                            <button class="w-100 btn btn-primary btn-lg" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
