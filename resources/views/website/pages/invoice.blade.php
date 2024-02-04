@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'Invoice : '.$order->order_id])
<div class="container pad-tb">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-15">Invoice #{{$order->order_id}} <span class="badge bg-info font-size-12 ms-2">{{$order->status}}</span></h4>
                        <div class="mb-4">
                            <h2 class="mb-1 text-muted">{{getSetting('site_title')}}</h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">{{getSetting('site_address')}}</p>
                            <p class="mb-1"><i class="fa fa-envelope"></i> {{getSetting('site_email')}}</p>
                            <p><i class="fa fa-phone-square-alt"></i> {{getSetting('site_phone')}}</p>
                            <p><i class="fa fa-phone-alt"></i> {{getSetting('site_phone_2')}}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Billed To:</h5>
                                <h5 class="font-size-15 mb-2">{{$order->user->name??'Deleted'}}</h5>
                                <p class="mb-1">{{$order->user->address()??'Not Set yet'}}</p>
                                <p class="mb-1">{{$order->user->email??'Not Set yet'}}</p>
                                <p>{{$order->user->phone_number??'Not Set yet'}}</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                @if($order->status != 'completed')
                                <div class="mt-2">
                                    <form action="{{route('order_pay',['id'=>$order->id])}}" method="post" >
                                        @csrf
                                        <p class="text-info">Select Payment Method and click on pay now button</p>
                                        <div  role="group" >
                                            @error('payment_method')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            @if(env('BKASH_STATUS'))
                                            <input type="radio" class="btn-check" name="payment_method" value="bkash" id="bkash" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="bkash">Bkash</label>
                                            @endif
                                            @if(env('SSLCOMMERZ_STATUS'))
                                            <input  type="radio" class="btn-check" name="payment_method" value="sslcommerz"  id="sslcommerz" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="sslcommerz">SSLCOMERZ</label>
                                            @endif
                                            @if(env('UDDOKTA_STATUS'))
                                            <input  type="radio" class="btn-check" name="payment_method" value="uddoktapay" checked id="uddoktapay" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="uddoktapay">Uddoktapay</label>
                                            @endif
                                            <input type="submit" value="Pay Now" class="btn btn-danger">
                                        </div>

                                        <div class="form-group mt-2">

                                        </div>

                                    </form>
                                </div>
                                @endif
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                    <p>{{formatDateTime($order->created_at,false)}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="py-2">
                        <h5 class="font-size-15">Order Summary</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end" style="width: 120px;">Total</th>
                                </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                @php $sl = 1 @endphp
                                @foreach($order->items as $itm)
                                <tr>
                                    <th scope="row">{{$sl++}}</th>
                                    <td>
                                        <div>
                                            <h5 class="text-truncate font-size-14 mb-1">{{$itm->item->title}}</h5>
                                        </div>
                                    </td>
                                    <td>{{getSetting('currency')}} {{$itm->price}}</td>
                                    <td>1</td>
                                    <td class="text-end">{{getSetting('currency')}} {{$itm->price}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                    <td class="text-end">{{getSetting('currency')}} {{$order->items->sum('subtotal')}}</td>
                                </tr>
                                @if($order->discount>0)
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">
                                        Discount :</th>
                                    <td class="border-0 text-end">- {{getSetting('currency')}} {{$order->discount}}</td>
                                </tr>
                                @endif
                                @if($order->delivery_charge>0)
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">
                                        Shipping Charge :</th>
                                    <td class="border-0 text-end">{{getSetting('currency')}} {{$order->delivery_charge}}</td>
                                </tr>
                                @endif
                                <!-- end tr -->
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">{{getSetting('currency')}}
                                        {{$order->payable_amount}}</h4></td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">Paid</th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">{{getSetting('currency')}} {{$order->paid_amount}}</h4></td>
                                </tr>
                                @if($order->due>0)
                                <tr class="text-danger">
                                    <th scope="row" colspan="4" class="border-0 text-end">Due</th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">{{getSetting('currency')}} {{$order->due}}</h4></td>
                                </tr>
                                @endif
                                <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
{{--                        <div class="d-print-none mt-4">--}}
{{--                            <div class="float-end">--}}
{{--                                <a href="" class="btn btn-success me-1"><i class="fa fa-print"></i></a>--}}
{{--                                <a href="#" class="btn btn-primary w-md">Send</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    <h5 class="card-title">Payment History</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($order->payments as $payment)
                            <li class="list-group-item">#{{$payment->transaction_id}}, {{$payment->payment_method}}, {{$payment->amount}}, {{$payment->status}}
                                @if($payment->status != 'completed')
                                <a class="btn btn-danger" href="{{route('payment',['id'=>$payment->id])}}">Pay Now</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>
@endsection
