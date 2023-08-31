@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group" aria-label="First group">
                            {{ __('Document Management') }}
                        </div>
                        <div class="input-group">
                            <a href="{{route('create.doc')}}" class="btn btn-sm btn-primary">Tambah</a>
                        </div>
                      </div>
                </div>

                <div class="card-body">
                    <table class="table-responsive" style="width: 100%">
                        <thead>
                            <th>#</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Signin</th>
                        </thead>
                        <tbody>
                            @foreach($document as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->title }}</td>
                                <td>{{ $user->content}}</td>
                                <td>
                                    @if($user->signing)
                                    <img src="{{ asset('storage/document/'.$user->signing) }}" style="height: 50px;width:100px;">
                                    @else 
                                    <span>No image found!</span>
                                    @endif
                                </td>
                                <td><a href="{{route('edit.doc',$user->id)}}" class="btn btn-success btn-xs py-0">Edit</a></td>
                                <td><a href="{{route('show.doc',$user->id)}}" class="btn btn-secondary btn-xs py-0">Show</a></td>
                                <td>
                                    <form method="POST" action="{{ route('destroy.doc',$user->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-xs py-0">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
