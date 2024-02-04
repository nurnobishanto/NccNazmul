<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Library\UddoktaPay;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

use Illuminate\Support\Str;

class UddoktaPayController extends Controller
{


    public function createPayment($id) {

        $payment = Payment::find($id);
        if (!$payment || !$payment->amount || !$payment->transaction_id  || $payment->amount < 1){
            return redirect(route('invoice',['id' => $id]));
        }
        $order = $payment->order;
        $user = $order->user;

        $requestData = [
            'full_name'    => $user->name,
            'email'        => $user->email??env('MAIL_FROM_ADDRESS'),
            'amount'       => $payment->amount,
            'metadata'     => [
                'order_id'   => $order->id,
                'payment_id' => $payment->id,
                'password' => Hash::make(env('APP_NAME')),

            ],
            'redirect_url' => route('uddoktapay_callback'),
            'cancel_url'   => route('invoice',['id' => $id]),
            'webhook_url'  => route('api.uddoktapay.webhook'),
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => env('UDDOKTA_URL')."/api/checkout-v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => [
                "RT-UDDOKTAPAY-API-KEY: " . env('UDDOKTA_API_KEY'),
                "accept: application/json",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseArray = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                echo $responseArray['payment_url'];
                return redirect( $responseArray['payment_url'] );
            } else {
                echo "Error decoding JSON response";
            }
        }

       return redirect(route('invoice',['id' => $id]));
    }

    public function webhook( Request $request ) {

        $headerApi = $_SERVER['UDDOKTA_API_KEY'] ?? null;

        if ( $headerApi == null ) {
            return response( "Api key not found", 403 );
        }

        if ( $headerApi != env( "UDDOKTA_API_KEY" ) ) {
            return response( "Unauthorized Action", 403 );
        }

        $validatedData = $request->validate( [
            'full_name'      => 'required',
            'email'          => 'required',
            'amount'         => 'required',
            'invoice_id'     => 'required',
            'metadata'       => 'required',
            'payment_method' => 'required',
            'sender_number'  => 'required',
            'transaction_id' => 'required',
            'status'         => 'required',
        ] );

        if (Hash::make(env('APP_NAME'))!= $validatedData['metadata']['password']){
            return response( 'Payment Unauthorized' );
        }
        $payment = Payment::find($validatedData['metadata']['payment_id']);
        if (!$payment || $payment->transactionStatus != 'Completed'){
            return response( 'Payment Uncompleted' );
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

        return response( 'Payment Completed' );
    }

    public function callback(Request $request){

        $fields = [
            'invoice_id'     => $request->invoice_id,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => env('UDDOKTA_URL') . "/api/verify-payment",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => [
                "RT-UDDOKTAPAY-API-KEY: " . env('UDDOKTA_API_KEY'),
                "accept: application/json",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseArray = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                if (Hash::check(env('APP_NAME'), $responseArray['metadata']['password'])) {

                    $payment = Payment::where('id', $responseArray['metadata']['payment_id'])->first();

                    $payment->update([
                        'trx_id' => $responseArray['transaction_id'],
                        'transaction_status' => $responseArray['status'],
                        'amount' => $responseArray['amount'],
                        'currency' => 'BDT',
                        'payment_execute_time' => $responseArray['date'],
                        'merchant_invoice_number' => $responseArray['invoice_id'],
                        'customer_msisdn' => $responseArray['sender_number'],
                        'status_message' => $responseArray['status'],
                    ]);
                    if ($responseArray['status'] == 'COMPLETED'){

                        return redirect(route('payment_success',['id' => $payment->id]).'?password='.Hash::make(env('APP_NAME')));
                    }

                    return redirect(route('invoice',['id' => $payment->id]));
                } else {
                    return redirect(route('invoice',['id' => $responseArray['metadata']['payment_id']]));
                }
            } else {
                echo "Error decoding JSON response";
                return redirect(route('website'));
            }
        }

    }

}
