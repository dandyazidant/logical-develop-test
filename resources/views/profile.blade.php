@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    <div class="feature col">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                            @if (!empty(auth()->user()->foto))
                                <img src="{{ asset('storage/images/'.auth()->user()->foto) }}" class="rounded float-start" alt="..." style="width:250px;">
                            @else
                                <img src="/assets/user_icon.png" class="rounded float-start" alt="..." style="width:250px;">
                            @endif
                        </div>
                        <div class="fs-2 text-body-emphasis">{{ucwords(strtolower(auth()->user()->nama_lengkap))}}</div>
                        <div class="fs-5 text-body-emphasis">Email : {{auth()->user()->email}}, <br> No. Hp: {{auth()->user()->no_hp}}</div>
                        <div class="fs-5 text-body-emphasis">Company : {{!empty(auth()->user()->company) ? ucwords(strtolower(auth()->user()->company)) : '-'}}</div>
                        <div class="fs-5 text-body-emphasis">Divisi : {{!empty(auth()->user()->divisi) ? ucwords(strtolower(auth()->user()->divisi)) : '-'}}</div>
                        <a href="{{route('edit.profile', auth()->user()->id)}}" class="icon-link">Edit</a>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
