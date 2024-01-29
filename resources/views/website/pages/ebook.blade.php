@extends('layouts.master')

@section('content')
    <!-- Start Page Banner Area -->
    <div class="page-banner-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">

                <div class="page-banner-content" data-aos="fade-right" data-aos-delay="50" data-aos-duration="500"
                    data-aos-once="true">
                    <h2>E Books</h2>

                    <ul>
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>ebook</li>
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
                        <tbody>
                        @foreach ($ebooks as $ebook)
                            <tr>
                                <td>{{ $ebook->id }}</td>
                                <td><img src="{{ asset('uploads/'.$ebook->image )}}" class="img img-thumbnail" style="max-width: 120px"></td>
                                <td>{{ $ebook->name }}</td>
                                <td>{!! $ebook->details !!}  </td>
                                <td>
                                    @if($ebook->file)
                                        <a href="{{asset('uploads/'.$ebook->file)}}" onclick="incrementCount({{ $ebook->id }},'Ebook')" class="btn btn-danger">Download</a>
                                    @endif
                                    @if($ebook->link)
                                        <a href="{{$ebook->link}}" onclick="incrementCount({{ $ebook->id }},'Ebook')" class="btn btn-success">Download</a>
                                    @endif
                                </td>
                                <td>{{$ebook->count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>



            </div>

            {{ $ebooks->links('vendor.pagination.custom') }}
        </div>
    </div>
    <!-- End Blog Area -->
@endsection
