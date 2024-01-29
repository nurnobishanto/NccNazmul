<?php

namespace App\Http\Controllers;

use App\Models\ExamPaper;
use App\Models\Result;
use App\Models\FreeNote;
use App\Models\Ebook;
use App\Models\ResultActivity;
use Artesaos\SEOTools\Facades\SEOTools;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \Carbon\Carbon;
class ExamController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function pass(Request $request){
        Session::put( "exam_paper_password_{$request->id}", $request->pass);
        return redirect()->route('test', ['id' => $request->id]);
    }

    public function index($id)
    {

        $paper = ExamPaper::where('id', $id)->first();
        if ($paper) {
            $limit = 9999;
            $date = Carbon::now();
            $date = date('Y-m-d', time());
            $time = date('H:i:s', time());
            $currentTime = $date . " " . $time;
            $paperid = "paperid" . $paper->id;

            $result = Result::where('user_id', Auth::user()->id)->where('exam_paper_id', $paper->id)->get();

            $atmpCount = $result->count();
            $attmDuration = 0;
            if(date('Y-m-d H:i:s') >= $paper->startdate . ' ' . $paper->starttime && date('Y-m-d H:i:s') <= $paper->enddate . ' ' . $paper->endtime){
                $limit = 100;
            }else{
                $limit = 999999;
            }
            if ($atmpCount < $limit) {
                if (Session::has($paperid)) {
                    $attempt = Session::get($paperid);
                    $start_date = new DateTime($attempt);
                    $since_start = $start_date->diff(new DateTime($currentTime));
                    $seconds = $since_start->days * 24 * 60;
                    $seconds += $since_start->h * 60;
                    $seconds += $since_start->i * 60;
                    $seconds += $since_start->s;

                    $attmDuration = $seconds;

                } else {
                    Session::put($paperid, $currentTime);
                }
                SEOTools::setTitle($paper->name);
                SEOTools::setDescription(getSetting('site.description'));
                if(date('Y-m-d H:i:s') >= $paper->startdate . ' ' . $paper->starttime){
                    return view('website.test', compact(['paper', 'attmDuration']));
                }else{
                    Session::forget( "exam_paper_password_{$id}");
                    return view('website.start', compact(['paper']));
                }


            } else {
                Session::forget( "exam_paper_password_{$id}");
                return "Limit Cross";

            }

        } else {
            Session::forget( "exam_paper_password_{$id}");
            return view('website.404');
        }
    }
    public function checking(Request $request)
    {
        Session::forget( "exam_paper_password_{$request->paperid}");
        $paperid = "paperid" . $request->paperid;
        $id = $request->paperid;

        if (Session::has($paperid)) {
            $attempt = Session::get($paperid);
            Session::forget($paperid);
        } else {

            $result = Result::where('user_id', Auth::user()->id)->where('exam_paper_id', $request->paperid)->orderBy('total_mark', 'DESC')->orderBy('duration', 'ASC')->orderBy('created_at', 'ASC')->get();

            // return $result;
            SEOTools::setTitle('My Result');
            SEOTools::setDescription(getSetting('site.description'));
            return view('website.results', compact(['result', 'id']));
        }
        $paper = ExamPaper::where('id', $id)->first();
        $date = Carbon::now();
        $date = date('Y-m-d', time());
        $time = date('H:i:s', time());
        $currentTime = $date . " " . $time;

        $start_date = new DateTime($attempt);
        $since_start = $start_date->diff(new DateTime($currentTime));

        $seconds = $since_start->days * 24 * 60;
        $seconds += $since_start->h * 60;
        $seconds += $since_start->i * 60;
        $seconds += $since_start->s;



        $mark = 0.0;
        $pm = $request->pmark;
        $nm = $request->nmark;
        $notans = 0;
        $wrongans = 0;
        $correctans = 0;
        $result = Result::create([
            'exam_paper_id' => $request->paperid,
            'user_id' => Auth::user()->id,
            'total_mark' => 0,
            'ca' => 0,
            'na' => 0,
            'wa' => 0,
            'duration' => $seconds,
        ]);
        for ($c = 1; $c <= $request->total; $c++) {
            $qid= "q" . $c;
            $ca = "ca" . $c;
            $sop = "op" . $c;
            $status = null;
            if ($request->$sop == $request->$ca) {
                $mark = $mark + $pm;
                $correctans = $correctans + 1;
                $status = 'Correct';
            } elseif ($request->$sop == "none") {
                $notans = $notans + 1;
            } else {
                $mark = $mark - $nm;
                $wrongans = $wrongans + 1;
                $status = 'Wrong';
            }
            ResultActivity::create([
                'result_id' => $result->id,
                'question_id' => $request->$qid,
                'attempt' => $request->$sop,
                'status' => $status,
            ]);

        }


        $result->total_mark = $mark;
        $result->ca = $correctans;
        $result->na = $notans;
        $result->wa = $wrongans;
        $result->update();
        $data = $result;
        SEOTools::setTitle('My Result');
        SEOTools::setDescription(getSetting('site.description'));
        return view('website.result', compact(['data']));
    }

    public function download(Request $request)
    {
        //return $request->id;

        $download = ENV('APP_URL') ."". $request->url;
        if($request->type == "note"){
            $note = FreeNote::where('id', $request->id)->first();
            if($note){
                $note->increment('count');
                return redirect($download);
            }else{
              return  "Note not Found!";
            }

        }elseif($request->type == "ebook"){
             $ebook = Ebook::where('id', $request->id)->first();
            if($ebook){
                $ebook->increment('count');
                return redirect($download);
            }else{
              return  "E-Book not Found!";
            }
        }else{
         // return redirect($download);
         return "Something Error!";
        }



    }

}
