<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

use Illuminate\Support\Str;

class BkashController extends Controller
{
    private $base_url;
    public function __construct()
    {
        $this->base_url = env('BKASH_BASE_URL');
    }
    public function authHeaders(){
        return array(
            'Content-Type:application/json',
            'Authorization:' .$this->grant(),
            'X-APP-Key:'.env('BKASH_APP_KEY')
        );
    }
    public function curlWithBody($url,$header,$method,$body_data_json){
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function grant()
    {
        $header = array(
            'Content-Type:application/json',
            'username:'.env('BKASH_USER_NAME'),
            'password:'.env('BKASH_PASSWORD')
        );
        $header_data_json=json_encode($header);

        $body_data = array('app_key'=> env('BKASH_APP_KEY'), 'app_secret'=>env('BKASH_APP_SECRET'));
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/token/grant',$header,'POST',$body_data_json);

        $token = json_decode($response)->id_token;

        return $token;
    }

    public function createPayment($id)
    {
        $payment = Payment::find($id);
        if (!$payment || !$payment->amount || !$payment->transaction_id  || $payment->amount < 1){
            return redirect(route('invoice',['id' => $id]));
        }
        $header =$this->authHeaders();


        $body_data = array(
            'mode' => '0011',
            'payerReference' => $payment->transaction_id,
            'callbackURL' => route('bkash_url_callback'),
            'amount' => $payment->amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "INV".Str::random(8)
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/create',$header,'POST',$body_data_json);

        return redirect((json_decode($response)->bkashURL));
    }
    public function executePayment($paymentID)
    {

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID
        );

        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/execute',$header,'POST',$body_data_json);

        $res_array = json_decode($response,true);

        if(isset($res_array['trxID'])){
            // your database insert operation
        }

        return $response;
    }

    public function queryPayment($paymentID)
    {

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID,
        );

        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/status',$header,'POST',$body_data_json);

        $res_array = json_decode($response,true);

        if(isset($res_array['trxID'])){
            // your database insert operation
        }

        return $response;
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();


        if(isset($allRequest['status']) && $allRequest['status'] == 'failure'){
            return view('Bkash.fail')->with([
                'response' => 'Payment Failed !!'
            ]);

        }else if(isset($allRequest['status']) && $allRequest['status'] == 'cancel'){
            return view('Bkash.fail')->with([
                'response' => 'Payment Cancelled !!'
            ]);

        }else{


            $response = $this->executePayment($allRequest['paymentID']);
            $res_array = json_decode($response,true);


            if(array_key_exists("statusCode",$res_array) && $res_array['statusCode'] != '0000'){
                return view('Bkash.fail')->with([
                    'response' => $res_array['statusMessage'],
                ]);
            }

            if(array_key_exists("message",$res_array)){
                // if execute api failed to response
                sleep(1);
                $query = $this->queryPayment($allRequest['paymentID']);
                return view('Bkash.success')->with([
                    'response' => $query,
                    'invoice' => 0,
                ]);
            }

            if ($res_array['statusCode'] == '0000' && $res_array['transactionStatus'] == 'Completed'){

                $payment = Payment::where('transaction_id',$res_array['payerReference'])->first();
                $payment->update([
                    'payment_id' => $res_array['paymentID'],
                    'trx_id' => $res_array['trxID'],
                    'transaction_status' => $res_array['transactionStatus'],
                    'amount' => $res_array['amount'],
                    'currency' => $res_array['currency'],
                    'intent' => $res_array['intent'],
                    'payment_execute_time' => $res_array['paymentExecuteTime'],
                    'merchant_invoice_number' => $res_array['merchantInvoiceNumber'],
                    'customer_msisdn' => $res_array['customerMsisdn'],
                    'status_code' => $res_array['statusCode'],
                    'status_message' => $res_array['statusMessage'],
                ]);
                return redirect(route('payment_success',['id' => $payment->id,'pass' => Hash::make(env('APP_NAME'))]));
                //completeInvoiceBkash($res_array['payerReference'],$res_array['amount'],$res_array['trxID'],$res_array['paymentID']);
            }

            return view('Bkash.success')->with([
                'response' => $res_array['trxID'],
                'invoice' => $res_array['payerReference'],
            ]);

        }

    }

    public function getRefund(Request $request)
    {
        return view('Bkash.refund');
    }

    public function refundPayment(Request $request)
    {
        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => 'sku',
            'reason' => 'Quality issue'
        );

        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund',$header,'POST',$body_data_json);

        $res_array = json_decode($response,true);

        if(isset($res_array['refundTrxID'])){

        }

        return view('Bkash.refund')->with([
            'response' => $response,
        ]);
    }

}
