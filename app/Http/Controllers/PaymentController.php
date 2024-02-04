<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function order_pay(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $order = Order::find($id);
        if ($order){
            $order->payment_method = $request->payment_method;
            $order->update();
            $payment = Payment::where('order_id',$order->id)->where('status','!=','completed')->where('amount',$order->due)->first();
            if (!$payment){
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->due,
                    'payment_method' => $order->payment_method,
                    'transaction_id' => Payment::generateUniqueTransactionID('CE'),
                    'status' => 'pending',
                ]);
            }else{
                $payment->payment_method = $order->payment_method;
                $payment->update();
            }
            return redirect(route('payment',['id'=>$payment->id]));
        }
        return view('website.pages.404');
    }
    public function invoice($id){
        $payment = Payment::find($id);
        if ($payment){
            $order = $payment->order;
            return view('website.pages.invoice',compact(['order']));
        }
        return view('website.pages.404');
    }
    public function view_order($id){
        $order = Order::find($id);
        if ($order){
            return view('website.pages.invoice',compact(['order']));
        }
        return view('website.pages.404');
    }
    public function payment(Request $request, $id)
    {

        $payment = Payment::find($id);
        if ($payment && $payment != 'completed'){
            if ($request->payment_method){
                $payment->payment_method = $request->payment_method;
                $payment->update();
            }
            if ($payment->payment_method == 'bkash'){
                return redirect(route('bkash_payment',['id'=>$payment->id]));
            }
            else if ($payment->payment_method == 'uddoktapay'){
                return redirect(route('uddoktapay_payment',['id'=>$payment->id]));
            }
            return  redirect(route('invoice',['id'=>$payment->id]));
        }
        return  redirect()->back();

    }
    public function success(Request $request,$id)
    {

        if (Hash::make(env('APP_NAME')) !== $request->password) {
            echo Hash::make(env('APP_NAME'));
            echo $request->password;
            //return redirect(route('invoice',['id' => $id]));
        }
        $payment = Payment::find($id);
        if (!$payment || ($payment->transaction_status != 'Completed' && $payment->transaction_status != 'COMPLETED')) {
            return redirect(route('invoice', ['id' => $payment->id]));
        }
        $payment->status = 'completed';
        $payment->update();
        $order = $payment->order;
        if ($payment->status == 'completed' && $order->status != 'completed'){
            $order->status = 'completed';
            $order->paid_amount = $order->paid_amount + $payment->amount;
            $order->due = $order->due - $payment->amount;
            $order->update();
        }
        $items = $order->items;
        if ($order->status == 'completed' && $items){

            foreach ($items as $itm){
                if ($itm->item_type == 'App\Models\Course'){
                    $course = Course::find($itm->item_id);
                    $course->users()->sync([$order->user_id => [
                        'lifetime_access' => $course->lifetime_access, // Replace with the actual value you want to set
                        'access_expiry' => $course->expired_date, // Replace with the actual value or logic you want to set
                    ]]);
                }
            }
        }
        return redirect(route('invoice',['id'=>$payment->id]));
    }
    public function fail($id){
        $payment = Payment::find($id);
        if ($payment){
            $payment->status = 'failed';
            $payment->update();
            return redirect(route('invoice',['id'=>$payment->id]));
        }
        return redirect(route('invoice',['id'=>$payment->id]));
    }
}
