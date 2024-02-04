<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courses(){

        $courses = Course::where('status','published')->paginate(9);
        $title ="All Courses";
        SEOTools::setTitle($title);
        SEOTools::setDescription(getSetting('site_description'));

        return view('website.pages.courses',compact(['courses','title']));
    }
    public function course_category($slug){
        $category = CourseCategory::where('slug',$slug)->first();
        if (!$category){
            SEOTools::setTitle('404');
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.pages.404');
        }
        $courses = Course::where('status','published')->where('course_category_id',$category->id)->paginate(9);
        SEOTools::setTitle($category->title);
        SEOTools::setDescription(getSetting('site_description'));
        $title ="Category : ".$category->title;
        return view('website.pages.courses',compact(['courses','title']));
    }
    public function course(Request $request, $slug){
        $data = array();
        $course = Course::where('slug',$slug)->first();
        if (!$course){
            SEOTools::setTitle('404');
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.pages.404');
        }
        $offer = 0;
        if ($course){
            $code  = $request->code;
            $data['coupon'] = 0;
            $coupon = Coupon::where('code',$code)->where('model',get_class($course))->where('expired_at','>=',date('y-m-d'))->first();
            if ($coupon){
                if ($coupon->type=='fixed'){
                    $offer = $coupon->amount;
                }else{
                    $discount = ($coupon->amount/100)*$course->sale_price;
                    $offer = min($discount, $coupon->maximum);
                }
                $data['coupon'] = $coupon;

            }else if ($code){
                $data['coupon'] = "Invalid Coupon Code";
            }
            $data['course'] = $course;
            $data['offer'] = $offer;
            SEOTools::setTitle($course->title);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.pages.course',$data);
        }
    }
    public function learn(Request $request,$slug){
        $data = array();
        $data['course_item'] = false;
        $course_item = CourseItem::find($request->item??0);
        if ($course_item){
            $data['course_item'] = $course_item;
        }
        $course = Course::where('slug',$slug)->first();

        if ($course){
            if (!enrolledCourse($course)){
                return redirect(route('course',['slug' => $slug]));
            }
            $data['course'] = $course;
            SEOTools::setTitle($course->title);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.pages.learning',$data);
        }else{
            SEOTools::setTitle("404 Not found");
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.pages.404',$data);
        }

    }
    public function course_enroll(Request $request,$id){
        $coupon_code = $request->coupon;
        $payment_method = $request->payment_method??'uddoktapay';
        $course = Course::find($id);
        if ($course){
            $offer = 0;
            $coupon = Coupon::where('code',$coupon_code)->first();
            if ($coupon){
                if ($coupon->type=='fixed'){
                    $offer = $coupon->amount;
                }else{
                    $discount = ($coupon->amount/100)*$course->sale_price;
                    $offer = min($discount, $coupon->maximum);
                }
            }
            $price = $course->sale_price - $offer;
            $user = auth('web')->user();

            $order = Order::create([
                'user_id' => $user->id,
                'payment_method' => $payment_method,
                'payable_amount' => $price,
                'paid_amount' => 0,
                'due' => $price,
                'delivery_charge' => 0,
                'discount' => $offer,
                'ip' => $request->ip(),
                'note' => null,
                'shipping_address_id' => null,
                'billing_address_id' => null,
                'status' => 'pending',
            ]);
            $order_item = OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $course->id,
                'item_type' => get_class($course),
                'quantity' => 1,
                'price' => $price,
                'subtotal' => $price,
            ]);
            $payment = Payment::where('order_id',$order->id)->where('status','!=','completed')->where('amount',$order->due)->first();
            if (!$payment){
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $price,
                    'payment_method' => $payment_method,
                    'transaction_id' => Payment::generateUniqueTransactionID('CE'),
                    'status' => 'pending',
                ]);
            }else{
                $payment->payment_method = $payment_method;
                $payment->update();
            }
            return redirect(route('invoice',['id'=>$payment->id]));
        }
        return redirect()->back();
    }

}
