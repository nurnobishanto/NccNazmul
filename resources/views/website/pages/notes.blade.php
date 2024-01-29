@extends('layouts.master')

@section('content')
    <!-- Start Page Banner Area -->
    <div class="page-banner-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">

                <div class="page-banner-content" data-aos="fade-right" data-aos-delay="50" data-aos-duration="500"
                    data-aos-once="true">
                    <h2>Free Notes</h2>

                    <ul>
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>Free Notes</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- End Page Banner Area -->

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
