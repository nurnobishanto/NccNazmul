@extends('layouts.master')

@section('content')
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row justify-content-center card">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                @endif
                <ul class="nav nav-tabs nav-pills nav-justified bg-light border " id="myTab" role="tablist">

                    <li class="nav-item " role="presentation">
                        <button class="nav-link active " id="today-tab" data-bs-toggle="tab" data-bs-target="#today"
                            type="button" role="tab" aria-controls="today" aria-selected="true">Profile
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
                            type="button" role="tab" aria-controls="upcoming" aria-selected="true">Edit Profile
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="previous-tab" data-bs-toggle="tab" data-bs-target="#previous"
                            type="button" role="tab" aria-controls="previous" aria-selected="false">Activity</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">

                        <div class="row justify-content-center ptb-100">

                            <div class="col-sm-6 col-md-4 border text-center p-5">
                                <img src="{{ asset('uploads/'.$profile->image) }}" alt="{{ $profile->name }}"
                                    class="img-rounded img-responsive" />
                                <p>
                                    <b>User ID : #{{ $profile->id }}</b><br>
                                    <b>Name : {{ $profile->name }}</b><br>
                                    <span>Email : {{ $profile->email }}</span><br>
                                    <span>College : {{ $profile->college }}</span><br>
                                    <span>Batch : {{ $profile->batch }}</span><br>
                                    <span>District : {{ $profile->district }}</span><br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                        <div class="ptb-100">
                            <form method="POST" action="{{ route('update') }}">
                                @csrf

                                {{-- <div class="row mb-3">
                                    <label for="avatar"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Select Profile Image') }}</label>

                                    <div class="col-md-6">
                                        <input  id="avatar" type="file" class="form-control" name="avatar">

                                    </div>
                                </div> --}}

                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Full Name *') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $profile->name }}" placeholder="Enter Your Full Name" required
                                            autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address Or Phone Number *') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $profile->email }}" placeholder="Enter Email or Phone Number"
                                            required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="college"
                                        class="col-md-4 col-form-label text-md-end">{{ __('School or College Name *') }}</label>

                                    <div class="col-md-6">
                                        <input id="college" type="text" class="form-control" name="college"
                                            value="{{ $profile->college }}" placeholder="Enter School or College Name"
                                            required>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="batch"
                                        class="col-md-4 col-form-label text-md-end">{{ __('HSC/SSC Batch *') }}</label>

                                    <div class="col-md-6">
                                        <input id="batch" type="text" class="form-control" name="batch"
                                            value="{{ $profile->batch }}" placeholder="Ex.. HSC 2022-2023" required>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="district"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Your District *') }}</label>

                                    <div class="col-md-6">
                                        <input id="district" type="text" class="form-control" name="district"
                                            value="{{ $profile->district }}" placeholder="Enter District Name"
                                            required>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Enter New Password" autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" placeholder="Enter Confirm Password"
                                            autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Profile') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="previous" role="tabpanel" aria-labelledby="previous-tab">
                        <h2 class="mt-5">My Activity</h2>
                                    <div class="row justify-content-center">
                @foreach ($activity as $r)
                    <div class="col-md-4">

                        <div class="card m-1">
                            <div class="card-body">

                                <p>Exam Name: {{ $r->exam_paper->name }}</p>
                                <div class="m-2 text-center">
                                    <span class="bg-info p-1">Full Mark :
                                        {{ $r->exam_paper->questions->count() * $r->exam_paper->pmark }}
                                    </span>

                                    <span class="bg-success text-light p-1"><strong> Mark : {{ $r->total_mark }} /
                                            {{ $r->exam_paper->questions->count() * $r->exam_paper->pmark }}
                                        </strong></span>
                                </div>


                                <div class="m-2 text-center">
                                    <span style="padding: 5px;" class="bg-success text-light">Correct Answer :
                                        {{ $r->ca }}</span><span style="padding: 5px;"
                                        class="bg-dark  text-light">Total Attempt :
                                        {{ $r->ca + $r->wa }}</span>
                                </div>
                                <div class="m-2 text-center">
                                    <span style="padding: 5px;" class="bg-warning">Not Answer : {{ $r->na }} </span>
                                    <span style="padding: 5px;" class="bg-danger text-light">Wrong Answer :
                                        {{ $r->wa }}</span>
                                </div>


                                <div style="font-size: 14px;">Submitted : {{ $r->created_at }}</div>
                                <div style="font-size: 14px;">Duration : {{ floor($r->duration / 60) }} Minutes
                                    {{ $r->duration % 60 }} Seconds</div>


                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width:{{ ($r->ca * 100) / $r->exam_paper->questions->count() }}%">
                                        Correct ({{ ($r->ca * 100) / $r->exam_paper->questions->count() }}%)
                                    </div>
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width:{{ ($r->na * 100) / $r->exam_paper->questions->count() }}%">
                                        Not  ({{ ($r->na * 100) / $r->exam_paper->questions->count() }}%)
                                    </div>
                                    <div class="progress-bar bg-danger " role="progressbar"
                                        style="width:{{ ($r->wa * 100) / $r->exam_paper->questions->count() }}%">
                                        Wrong  ({{ ($r->wa * 100) / $r->exam_paper->questions->count() }}%)
                                    </div>
                                </div>
                                <span class="font-weight-300 text-success" style="font-size: 14px;"><i> (
                                        {{ $r->exam_paper->pmark }}
                                        Mark for Per Correct Answer )</i></span><br>
                                <span class="font-weight-300 text-danger" style="font-size: 14px;"><i> (
                                        {{ $r->exam_paper->nmark }}
                                        Mark for Per Negative Answer )</i></span>
                                        <br>
                                        <a class="btn btn-info m-1" href="{{route('resultCardPdf', ['id' => $r->id ])}}" target="_blank" rel="noopener noreferrer"><i class="ri-download-2-line"></i> Result Card</a>
                                        <a class="btn btn-success" href="{{ Route('question', ['id' => $r->exam_paper->id]) }}"><i class="ri-download-2-line"></i> Answer</a>
                                        <a class="btn btn-danger" href="{{ Route('start', ['id' => $r->exam_paper->id]) }}"><i class="ri-restart-line"></i>Retest</a>
                            </div>
                        </div>


                    </div>
                @endforeach




            </div>

                        <!--<table id="table" class="table table-striped table-bordered table-sm mt-5" cellspacing="0"-->
                        <!--    width="100%">-->
                        <!--    <thead>-->
                        <!--        <tr>-->
                        <!--            <th>SL</th>-->
                        <!--            <th>Questin</th>-->
                        <!--            <th>CA</th>-->
                        <!--            <th>NA</th>-->
                        <!--            <th>WA</th>-->
                        <!--            <th>TA</th>-->
                        <!--            <th>Mark</th>-->
                        <!--            <th>Duration</th>-->
                        <!--            <th>Submitted</th>-->
                        <!--            <th>Action</th>-->

                        <!--        </tr>-->
                        <!--    </thead>-->
                        <!--    <tbody>-->
                                <?php

                                $count = 1;

                                ?>
                        <!--        @foreach ($activity as $r)-->
                        <!--         @if($r->exam_paper)-->
                        <!--            <tr>-->
                        <!--                <td>{{ $count++ }}</td>-->
                        <!--                <td>{{ $r->exam_paper->name }}</td>-->
                        <!--                <td>{{ $r->ca }}</td>-->
                        <!--                <td>{{ $r->na }}</td>-->
                        <!--                <td>{{ $r->wa }}</td>-->
                        <!--                <td>{{ $r->ca + $r->wa }}</td>-->
                        <!--                <td>{{ $r->total_mark }}</td>-->
                        <!--                <td>{{ floor($r->duration / 60) }} Min-->
                        <!--                    {{ $r->duration % 60 }} Sec</td>-->
                        <!--                <td style="font-size: 12px">{{ date_format($r->created_at,"l d, M Y H:i A");  }}</td>-->
                        <!--                <td><a class="btn btn-success" href="{{ Route('question', ['id' => $r->exam_paper->id]) }}"><i class="ri-download-2-line"></i></a> <a class="btn btn-danger" href="{{ Route('start', ['id' => $r->exam_paper->id]) }}"><i class="ri-restart-line"></i></a> </td>-->
                        <!--            </tr>-->
                        <!--            @endif-->
                        <!--        @endforeach-->
                        <!--    </tbody>-->
                        <!--</table>-->


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
