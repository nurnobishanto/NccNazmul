<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ExamPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class ExamPaperPasswordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $examPaperId = $request->route('id');
        if (!$examPaperId){
            abort(404);
        }
        $exam = ExamPaper::find($examPaperId);
        $password = $exam->password??null;

        // Check if the ExamPaper has a password
        if ($password !== null) {
            // Check if the user has entered the correct password
            if (Session::has("exam_paper_password_{$examPaperId}") && Session::get("exam_paper_password_{$examPaperId}") == $password) {
                return $next($request);
            }
        }else{
            return $next($request);
        }
        Session::put( "exam_paper_password_{$examPaperId}", 'Your entered wrong password! Please, Try Again');
        return redirect()->back();

    }
}
