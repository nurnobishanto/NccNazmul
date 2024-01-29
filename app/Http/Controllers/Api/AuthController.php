<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\ExamPaper;
use App\Models\Post;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf as PDF;

class AuthController extends Controller
{
    protected function respondWithToken($token)
    {
        return response([
            'status' => true,
            'token' => $token,
            'token_type' => 'bearer',
        ])->original;
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false,'error' => $validator->errors()]);
        }

       User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $credentials = $request->only('email', 'password');
        $token = $this->guard()->attempt($credentials);
        if (!$token) {
            return response([
                'status' => false,
                'error' => 'Invalid credentials'
            ]);
        }
        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $token = $this->guard()->attempt($credentials);
        if (!$token) {
            return response([
                'status' => false,
                'error' => 'Invalid credentials'
            ]);
        }

        return $this->respondWithToken($token);
    }
    public function blogs(){
        try {
            // Retrieve blogs from the database
            $blogs = Post::all();

            // Format the response data
            $blogList = [];
            foreach ($blogs as $blog) {
                $blogList[] = [
                    'id'    => $blog->id,
                    'title' => $blog->title,
                    'body'  => $blog->body,
                    'image' => $blog->image,
                ];
            }

            // Return the response as JSON
            return response()->json($blogList, 200);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['error' => 'Failed to fetch blog list.'], 500);
        }
    }
    public function books(){
        try {
            // Retrieve blogs from the database
            $books = Ebook::all();

            // Format the response data
            $bookList = [];
            foreach ($books as $book) {
                $bookList[] = [
                    'id'    => $book->id,
                    'name' => $book->name,
                    'file_one'  => $book->link,
                    'file_two'  => $book->file,
                    'image' => $book->image,
                ];
            }

            // Return the response as JSON
            return response()->json($bookList, 200);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['error' => 'Failed to fetch blog list.'], 500);
        }
    }
    public function subjects(){
        $subjects = Subject::all();
        $data = [];
        foreach ($subjects as $subject){
            $data[] =[
                'id' => $subject->id,
                'name' => $subject->name
            ];
        }
        return response()->json($data, 200);
    }
    public function subject($id){
        try {
            // Retrieve blogs from the database
            $subject = Subject::find($id);



            // Format the response data
            $examList = [];
            if ($subject){
                $exams = $subject->exams;
                foreach ($exams as $exam) {
                    $examList[] = [
                        'id'    => $exam->id,
                        'name' => $exam->name,
                        'description' => $exam->description,
                        'subject' => $exam->subject->name,
                        'exam_category' => $exam->exam_category->name,
                        'duration' => $exam->duration,
                        'start' => $exam->startdate,
                        'end' => $exam->startdate,
                        'questions' => $exam->questions->count(),
                    ];
                }
            }

            // Return the response as JSON
            return response()->json($examList, 200);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['error' => 'Failed to fetch blog list.'], 500);
        }
    }
    public function exam($id){
        try {
            // Retrieve blogs from the database
            $exam = ExamPaper::find($id);

            // Format the response data
            $questionList = [];
            foreach ($exam->questions as $question) {
                $ca = $question->ca;
                $questionList[] = [
                    'id'    => $question->id,
                    'name' => $question->name,
                    'description' => $question->description,
                    'subject' => $question->subject->name,
                    'image' => $question->image,
                    'op1' => $question->op1,
                    'op2' => $question->op2,
                    'op3' => $question->op3,
                    'op4' => $question->op4,
                    'correct' => $question->$ca,
                    'explain' => $question->explain,
                    'explain_img' => $question->explain_img,
                ];
            }
            // Return the response as JSON
            return response()->json($questionList, 200);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['error' => 'Failed to fetch blog list.'], 500);
        }
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
    public function guard()
    {
        return Auth::guard('api');
    }
}
