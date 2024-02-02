@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => $paper->name,'url'=>'#'])
    <div class="portfolio-page pad-tb">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-2 col-md-6 col-sm-6  fixed-bottom">
                    <div class="bg-gradient12 text-light py-2 rounded">
                        <h4 class="text-center text-light">Time Remaining</h4>
                        <div id="timer" class="flex-wrap d-flex justify-content-center">

                            <div id="countdownMin" class=" btn btn-warning text-light rounded-pill m-2"></div>
                            <div id="countdownSec" class="btn btn-warning text-light rounded-pill m-2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">

                    <form action="{{ route('checking') }}" method="post" name="questionPaper">
                        @csrf
                        <?php
                        $count = 1;
                        $total = $paper->questions->count();
                        $timeMin = $paper->duration;
                        $timeSec = $timeMin * 60;
                        $remtime = $timeSec - $attmDuration;
                        $timeMlSec = $remtime * 1000;

                        ?>
                        <script type="text/javascript">
                            var timeleft = <?php echo $remtime; ?>;
                            var downloadTimer = setInterval(function() {
                                if (timeleft <= 0) {
                                    clearInterval(downloadTimer);
                                    document.getElementById("countdown").innerHTML = "Finished";
                                } else {
                                    var min = Math.floor(timeleft / 60);
                                    var sec = timeleft % 60;
                                    document.getElementById("countdownMin").innerHTML ="<h2>"+ min + "<span> Min</span></h2>";
                                    document.getElementById("countdownSec").innerHTML ="<h2>"+ sec + "<span> Sec</span></h2>";
                                }
                                timeleft -= 1;
                            }, 1000);
                        </script>
                        <p>{!! $paper->description !!}</p>
                        <input type="number" name="paperid" value="{{ $paper->id }}" hidden>
                        <input type="number" name="pmark" value="{{ $paper->pmark }}" hidden>
                        <input type="number" name="nmark" value="{{ $paper->nmark }}" hidden>
                        <input type="number" name="total" value="{{ $paper->questions->count() }}" hidden>
                        <span class="text-dark">Time : {{ $timeMin }} Minutes.</span><br>
                        <span class="text-primary">Total Questions : {{ $total }} </span><br>
                        <span class="text-success">Postive Mark For Every Question : {{ $paper->pmark }}</span><br>
                        <span class="text-danger">Negative Mark For Every Question : {{ $paper->nmark }}</span><br>
                        <span class="text-success "><strong> Total Mark : {{ $total }} X {{ $paper->pmark }} =
                                {{ $total * $paper->pmark }} </strong></span><br>
                        <?php $g = [];?>
                        @foreach($paper->questions as $q)
                            <?php
                                if (!in_array($q->subject_id, $g)) {
                                    array_push($g, $q->subject_id);
                                }

                                ?>
                        @endforeach
                        @foreach($g as $k)
                            <div class="border mt-2 mb-2 p-2">
                                <h4>{{\App\Models\Question::getSubName($k)}}</h4>
                                @foreach ($paper->questions->where('subject_id',$k)->shuffle() as $question)
                                    <hr>
                                    <div class="row  m-1">
                                        <input type="text" name="q{{ $count }}" value="{{ $question->id }}" hidden>
                                        <input type="text" name="ca{{ $count }}" value="{{ $question->ca }}" hidden>
                                        {!! $question->description !!}
                                        <div class="mt-2"><strong>{{$count}}) {{ $question->name }} </strong></div>
                                        <input hidden value="none" type="radio" name="op{{ $count }}" checked>
                                        @if($question->image)
                                            <div class="mt-2">
                                                <img style="width: 360px;" src="{{ asset('uploads/'.$question->image) }}"
                                                     alt="{{ $question->name }}">
                                            </div>
                                        @endif
                                        <div class="row gap-2 btn-group mt-2 " role="group" aria-label="Basic radio toggle button group">
                                            <div class="col-sm-5">
                                                <input type="radio" class="btn-check" value="op1" name="op{{ $count }}" id="op1{{ $count }}" autocomplete="off">
                                                <label class="btn btn-outline-primary d-block text-start" for="op1{{ $count }}">i.) {{ $question->op1 }}</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="radio" class="btn-check" value="op2" name="op{{ $count }}" id="op2{{ $count }}" autocomplete="off">
                                                <label class="btn btn-outline-primary d-block text-start" for="op2{{ $count }}">ii.) {{ $question->op2 }}</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="radio" class="btn-check" value="op3" name="op{{ $count }}" id="op3{{ $count }}" autocomplete="off">
                                                <label class="btn btn-outline-primary d-block text-start" for="op3{{ $count }}">iii.) {{ $question->op3 }}</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="radio" class="btn-check" value="op4" name="op{{ $count }}" id="op4{{ $count }}" autocomplete="off">
                                                <label class="btn btn-outline-primary d-block text-start" for="op4{{ $count }}">iv.) {{ $question->op4 }}</label>
                                            </div>

                                        </div>
                                    </div>
                                        <?php $count = $count + 1; ?>
                                @endforeach
                            </div>

                        @endforeach


                        <input class="btn-main bg-btn6 lnk m-1" type="submit" value="Submit">


                        <script type="text/javascript">
                            window.onload = function() {
                                window.setTimeout(function() {
                                    document.questionPaper.submit();
                                }, <?php echo $timeMlSec; ?>);
                            };
                        </script>
                    </form>


                </div>


            </div>
        </div>
    </div>
@endsection
