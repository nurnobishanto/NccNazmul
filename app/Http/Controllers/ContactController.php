<?php

namespace App\Http\Controllers;


use App\Models\Ebook;
use App\Models\FreeNote;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    public function Contact(){
        SEOTools::setTitle('Contact');
        SEOTools::setDescription('Easy English');
        return view('website.contact');
    }
    public function storeContactForm(Request $request)
    {


        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:11|numeric',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $input = $request->all();
       Contact::create([
           'type' => $input['type'],
           'name' => $input['name'],
           'email' => $input['email'],
           'phone' => $input['phone'],
           'subject' => $input['subject'],
           'message' => $input['message'],
       ]);
        //  Send mail to admin
        Mail::send('contactMail', array(
            'type' => $input['type'],
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'subject' => $input['subject'],
            'message' => $input['message'],
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('info@easyenglishbd.com', 'Easy English BD')->subject($request->get('subject'));
        });

        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
    }

    public function storeComment(Request $request)
    {
        $input = $request->all();
        Comment::create([
            'user_id' => $input['user_id'],
            'post_id' => $input['post_id'],
            'comment' => $input['comment'],
        ]);
        return redirect()->back()->with(['success' => 'Comment Submit Successfully']);
    }
    public function incrementDownloadCount(Request $request)
    {
        $id = $request->input('id');
        $model = $request->input('model');
        if ($model == 'Ebook'){
            $data = Ebook::find($id);
            if ($data) {
                // Increment count
                $data->increment('count');
                return response()->json(['success' => true, 'count' => $data->count]);
            }
        }
        elseif ($model == 'FreeNote'){
            $data = FreeNote::find($id);
            if ($data) {
                // Increment count
                $data->increment('count');
                return response()->json(['success' => true, 'count' => $data->count]);
            }
        }

        return response()->json(['error' => 'Ebook not found'], 404);
    }
}
