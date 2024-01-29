@extends('layouts.master')

@section('content')
    <!-- Start Page Banner Area -->
    <div class="page-banner-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">

                <div class="page-banner-content" data-aos="fade-right" data-aos-delay="50" data-aos-duration="500"
                    data-aos-once="true">
                    <h2>Ranking</h2>

                    <ul>
                        <li>
                            <a href="{{ route('website') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('exam') }}">Exam</a>
                        </li>
                        <li>Ranking</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- End Page Banner Area -->
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <?php

                $count = 1;

                ?>
                <h3>Exam Name: {{ $paper->name }} ({{$paper->id}})</h3>
                <p> Full Mark :{{ $paper->questions->count() * $paper->pmark }} <br>
                    Total Questions : {{ $paper->questions->count() }} <br>
                    Total Attempt: {{ $result->count() }} Students <br>
                    <a class="btn btn-warning d-inline" href="{{route('rankpdf', ['id' => $id ])}}"><i class="fa fa-download"></i> PDF Download</a>
                </p>

                <div class="table-responsive border p-1">
                    <table id="table" class="table table-bordered mt-5">
                        <thead class="bg-success text-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Correct</th>
                            <th>Not ans</th>
                            <th>Wrong </th>
                            <th>Attempt</th>
                            <th>Mark</th>
                            <th>Duration</th>
                            <th>Submitted</th>
                            <th>Comment</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($result as $r)
                            @if($r->user)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $r->user->name }} ({{$r->user->user_id}})</td>
                                    <td>{{ $r->ca }}</td>
                                    <td>{{ $r->na }}</td>
                                    <td>{{ $r->wa }}</td>
                                    <td>{{ $r->ca + $r->wa }}</td>
                                    <td>{{ $r->total_mark }}</td>
                                    <td>{{ floor($r->duration / 60) }} Min
                                        {{ $r->duration % 60 }} Sec</td>
                                    <td>{{ date_format($r->created_at,"d M, Y H:i a") }}</td>
                                    <td class="small small-text">{{getResultAttemptDetails($r)}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>



                <span class="font-weight-300 text-success" style="font-size: 12px;"><i> (
                        {{ $paper->pmark }}
                        Mark for Per Correct Answer )</i></span>
                <span class="font-weight-300 text-danger" style="font-size: 12px;"><i> (
                        {{ $paper->nmark }}
                        Mark for Per Negative Answer )</i></span>
            </div>
        </div>
    </div>
@endsection
