<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Ebook;
use App\Models\ExamCategory;
use App\Models\ExamPaper;
use App\Models\FreeNote;
use App\Models\Post;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;

use Illuminate\Http\Request;
//use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use Artesaos\SEOTools\Facades\SEOTools;
use \Mpdf\Mpdf as PDF;
use \Carbon\Carbon;

class WebsiteController extends Controller
{

    public function index()
    {

        if (request()->query('search')) {
            $search = request()->query('search');
            $searchpost = Post::where('body', 'LIKE', "%{$search}%")->where('title', 'LIKE', "%{$search}%")->where('status', '=', 'PUBLISHED')->orderBy('created_at', 'DESC')->paginate(6);
            SEOTools::setTitle($search);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.search', compact('searchpost'));
        } else {
            SEOTools::setTitle('Home');
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.home');
        }

    }
    public function blog()
    {

        $allposts = Post::orderBy('created_at', 'DESC')->where('status', '=', 'PUBLISHED')->paginate(6);
        SEOTools::setTitle('Blog');
        SEOTools::setDescription(getSetting('site_description'));
        return view('website.blog', compact('allposts'));
    }
    public function about()
    {
        SEOTools::setTitle('About Us');
        SEOTools::setDescription(getSetting('site_description'));
        $teachers = Teacher::all();
        return view('website.about',compact('teachers'));
    }
    public function ebook()
    {
        SEOTools::setTitle('E Book');
        SEOTools::setDescription(getSetting('site_description'));

        $ebooks = Ebook::orderBy('created_at', 'DESC')->paginate(20);
        return view('website.ebook', compact('ebooks'));
    }
    public function notes()
    {
        SEOTools::setTitle('Free Notes');
        SEOTools::setDescription(getSetting('site_description'));

        $notes = FreeNote::orderBy('created_at', 'DESC')->get();
        return view('website.notes', compact('notes'));
    }
    public function exam()
    {
        SEOTools::setTitle('Exam');
        SEOTools::setDescription(getSetting('site_description'));

        $subjects = Subject::orderBy('created_at', 'DESC')->paginate(20);
        return view('website.subject', compact('subjects'));
    }
    public function post($slug)
    {

        $post = Post::where('slug', $slug)->first();
        if ($post) {

            $comments = Comment::where('post_id', '=', $post->id)->paginate(20);

            $postKey = 'postkey_' . $post->id;
            if (!Session::has($postKey)) {
                $post->increment('view_count');
                Session::put($postKey, 1);

            }
            SEOTools::setTitle($post->title);
            SEOTools::setDescription(getSetting('site_description'));

            return view('website.post', compact(['post', 'comments']));
        } else {
            SEOTools::setTitle('404');
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.404');
        }
    }
    public function category_clouds()
    {
        SEOTools::setTitle('Catgory Cloud');
        SEOTools::setDescription(getSetting('site_description'));

        return view('website.categoryclouds');
    }
    public function category($slug)
    {

        $category = Category::where('slug', $slug)->first();
        $categoryposts = Post::where('category_id', $category->id)->where('status','published')->paginate(6);
        SEOTools::setTitle($category->name);
        SEOTools::setDescription(getSetting('site_description'));
        return view('website.category', compact(['categoryposts', 'category']));
    }
    public function author($slug)
    {

        $author = User::where('id', $slug)->first();
        $authorposts = Post::where('author_id', $author->id)->where('status','published')->paginate(6);
        SEOTools::setTitle($author->name);
        SEOTools::setDescription(getSetting('site_description'));
        return view('website.author', compact(['authorposts', 'author']));
    }

    public function subject($slug)
    {

        $sub = subject::where('slug', $slug)->first();

        if ($sub) {
            // $ecats = ExamCategory::where('subject_id',$sub->id)->paginate(6);
            $ecats = $sub->exam_categories;
            SEOTools::setTitle($sub->name);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.examcategory', compact(['ecats', 'sub']));
        } else {
            return view('website.404');
        }
    }
    public function exam_category($slug)
    {

        $ecat = ExamCategory::where('slug', $slug)->first();

        if ($ecat) {

            $examLists = $ecat->exam_papers;
            SEOTools::setTitle($ecat->name);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.examlist', compact(['ecat','examLists']));
        } else {
            SEOTools::setTitle('404');
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.404');
        }
    }

    public function results($id)
    {
        $exam_paper = ExamPaper::find($id);
        if (!$exam_paper){
            return  view('website.404');
        }
        $result = Result::where('exam_paper_id', $id)->orderBy('total_mark', 'DESC')->orderBy('duration', 'ASC')->orderBy('created_at', 'ASC')->get();

        // return $result;
        SEOTools::setTitle('Results');
        SEOTools::setDescription(getSetting('site_description'));
        return view('website.results', compact(['result', 'id']));

    }
    public function result($result)
    {

        $data = Result::find($result);
        if (!$data || !$data->exam_paper){
            return  view('website.404');
        }

        // return $result;
        SEOTools::setTitle('Results');
        SEOTools::setDescription(getSetting('site_description'));
        return view('website.result', compact('data'));

    }
    public function rank($id)
    {
        $paper = ExamPaper::where('id', $id)->first();
        if (!$paper){
            return  view('website.404');
        }
        $result = Result::where('exam_paper_id', $id)->orderBy('total_mark', 'DESC')->orderBy('duration', 'ASC')->orderBy('created_at', 'ASC')->get();

        SEOTools::setTitle('Rank');
        SEOTools::setDescription(getSetting('site_description'));
        return view('website.rank', compact(['result', 'id', 'paper']));

    }

    public function generatePDFquestion($id)
    {

        $paper = ExamPaper::where('id', $id)->first();
        $date = [
            'paper' => $paper,
        ];
        // Setup a filename
        $documentFileName = $paper->id." Question Answare.pdf";

        // Create the mPDF document
        $document = new PDF([
            'default_font' => 'trebuchetms',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        $document->SetWatermarkText('EasyEnglishBD.com');
        $document->showWatermarkText = true;

        $document->allow_charset_conversion = true; // Set by default to TRUE

        //$document->charset_in = 'windows-1252';

        $document->autoLangToFont = true;
        $document->autoScriptToLang = true;

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
        ];

        // Write some simple Content
        $document->WriteHTML(view('pdf.question', $date));


        // Save PDF on your public storage
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));

        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //



    }

    public function generatePDFrank($id)
    {

        $result = Result::where('exam_paper_id', $id)->orderBy('total_mark', 'DESC')->orderBy('duration', 'ASC')->orderBy('created_at', 'ASC')->get();

        $paper = ExamPaper::where('id', $id)->first();

        $date = [
            'paper' => $paper,
            'result' => $result,
        ];

        // Setup a filename
   	$documentFileName = "Ranking List of ".$paper->id.$paper->id.".pdf";

        // Create the mPDF document
        $document = new PDF([
            'default_font' => 'trebuchetms',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        $document->SetWatermarkText('EasyEnglishBD.com');
        $document->showWatermarkText = true;

        $document->allow_charset_conversion = true; // Set by default to TRUE

        //$document->charset_in = 'windows-1252';

        $document->autoLangToFont = true;
        $document->autoScriptToLang = true;

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
        ];

        // Write some simple Content
        $document->WriteHTML(view('pdf.ranklist', $date));

        // Save PDF on your public storage
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));

        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //

    }

    public function generatePDFresultCardPdf($id)
    {

        $result = Result::where('id', $id)->first();

        $date = [
            'result' => $result,
        ];

        // Setup a filename

        $documentFileName = $result->user->name.$result->id." Result Card.pdf";

        // Create the mPDF document
        $document = new PDF([
            'default_font' => 'freesans',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        $document->SetWatermarkText('EasyEnglishBD.com');
        $document->showWatermarkText = true;

        $document->allow_charset_conversion = true; // Set by default to TRUE

        //$document->charset_in = 'windows-1252';

        $document->autoLangToFont = true;
        $document->autoScriptToLang = true;

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
        ];

        // Write some simple Content
        $document->WriteHTML(view('pdf.result', $date));

        // Save PDF on your public storage
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));

        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //




    }
    public function clone($id)
    {
        $old_ep = ExamPaper::find($id);
        $new_ep = $old_ep->replicate();
        $new_ep->push();
        $new_ep->name = $old_ep->name." - copy";
        $new_ep->update();
       foreach ($old_ep->questions as $q){
           DB::table('exam_paper_questions')->insert([
               'exam_paper_id' => $new_ep->id,
               'question_id' => $q->id
           ]);
       }

        return redirect()->back();
    }
    public function start($id)
    {

        $paper = ExamPaper::where('id', $id)->first();

        if ($paper) {
            $date = Carbon::now();
            $date = date('Y-m-d', time());
            $time = date('H:i:s', time());
            $currentTime = $date . " " . $time;
            $paperid = "paperid" . $paper->id;

            SEOTools::setTitle($paper->name);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.start', compact(['paper']));

        } else {
            return view('website.404');
        }
    }

    public function url($id){

        return $id;

    }

}
