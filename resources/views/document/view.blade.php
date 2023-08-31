@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Detail') }}</div>

                <div class="card-body">
                    <div class="feature col">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                            @if (!empty($doc->signing))
                                <img src="{{ asset('storage/document/'.$doc->signing) }}" class="rounded float-start" alt="..." style="width:250px;">
                            @else
                                <img src="/assets/user_icon.png" class="rounded float-start" alt="..." style="width:250px;">
                            @endif
                        </div>
                        <div class="fs-2 text-body-emphasis">{{ucwords(strtolower($doc->title))}}</div>
                        <div class="fs-5 text-body-emphasis">{{$doc->content}}</div>
                        <a href="{{route('edit.doc', $doc->id)}}" class="icon-link">Edit</a>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
