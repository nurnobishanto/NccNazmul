<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment($id)
    {
        return redirect(route('success',['id'=>$id]));
    }
    public function success($id)
    {
        $payment = Payment::find($id);
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
                    return $course;

                }
            }
        }

        return "Complete";
    }
}
