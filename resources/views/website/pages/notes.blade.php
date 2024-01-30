@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'Free Notes','url'=>'#'])


    <!-- Start Blog Area -->
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead class="table text-center" >
                        <tr>
                            <th width="10px">SL</th>
                            <th width="120px">Image</th>
                            <th width="200px">Book Name</th>
                            <th>Details</th>
                            <th width="200px">Action</th>
                            <th width="20px">Count</th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach ($notes as $note)
                            <tr>
                                <td>{{ $note->id }}</td>
                                <td><img src="{{ asset('uploads/'.$note->image )}}" class="img img-thumbnail" style="max-width: 120px"></td>
                                <td>{{ $note->name }}</td>
                                <td>{!! $note->details !!}  </td>
                                <td>
                                    @if($note->file)
                                    <a href="{{asset('uploads/'.$note->file)}}" onclick="incrementCount({{ $note->id }},'FreeNote')" class="btn btn-danger">Download</a>
                                    @endif
                                    @if($note->link)
                                    <a href="{{$note->link}}" onclick="incrementCount({{ $note->id }},'FreeNote')" class="btn btn-success">Download</a>
                                    @endif
                                </td>
                                <td>{{$note->count}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
