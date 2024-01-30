@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'Contact US','url'=>'#'])
    <!--Start Enquire Form-->
    <section class="contact-page pad-tb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 v-center">
                    <div class="common-heading text-l">
                        <span>Contact Now</span>
                        <h2 class="mt0 mb0">Have Question? Write a Message</h2>
                        <p class="mb60 mt20">We will catch you as early as we receive the message</p>
                    </div>
                    <div class="form-block">
                        <form id="contactForm" action="{{ route('contact_form.store') }}" method="post" data-bs-toggle="validator" class="shake">
                            @csrf
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <input type="text" name="name" value="{{old('name')}}" id="name" placeholder="Enter name"  data-error="Please fill Out">
                                    <div class="help-block with-errors">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="email" value="{{old('email')}}"  name="email" id="email" placeholder="Enter email" >
                                    <div class="help-block with-errors">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <input type="text" value="{{old('phone')}}" name="phone" id="mobile" placeholder="Enter mobile"  data-error="Please fill Out">
                                    <div class="help-block with-errors">
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">

                                    <select name="type" >
                                        <option value="">Select contact type</option>
                                        <option value="Admission">Admission</option>
                                        <option value="General Contact">General Contact</option>
                                        <option value="English Special Batch">English Special Batch</option>
                                        <option value="HSC Special Batch">HSC Special Batch</option>
                                        <option value="HSC Batch">HSC Batch</option>
                                    </select>
                                    <div class="help-block with-errors">
                                        @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="text" name="subject" value="{{old('subject')}}" id="subject" placeholder="Enter subject"  data-error="Please fill Out">
                                <div class="help-block with-errors">
                                    @if ($errors->has('subject'))
                                        <span class="text-danger">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <textarea id="message" name="message" rows="5" placeholder="Enter your message" >{{old('message')}}</textarea>
                                <div class="help-block with-errors">
                                    @if ($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" id="form-submit" class="btn lnk btn-main bg-btn">Submit <span class="circle"></span></button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 v-center">
                    <div class="contact-details">
                        <div class="contact-card wow fadeIn" data-wow-delay=".2s">
                            <div class="info-card v-center">
                                <span><i class="fas fa-phone-alt"></i> Phone:</span>
                                <div class="info-body">
                                    <p>Assistance hours: Saturday – Thursday, 9 am to 8 pm</p>
                                    <a href="tel:{{ getSetting('site_phone') }}">{{ getSetting('site_phone') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="email-card mt30 wow fadeIn" data-wow-delay=".5s">
                            <div class="info-card v-center">
                                <span><i class="fas fa-envelope"></i> Email:</span>
                                <div class="info-body">
                                    <p>Our support team will get back to in 24-h during standard business hours.</p>
                                    <a href="mailto:{{ getSetting('site_email') }}">{{ getSetting('site_email') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="skype-card mt30 wow fadeIn" data-wow-delay=".9s">
                            <div class="info-card v-center">
                                <span><i class="fa fa-map-marker-alt"></i> Address:</span>
                                <div class="info-body">
                                    <p>We Are Online: Monday – Friday, 9 am to 5 pm</p>
                                    <a href="#">{{ getSetting('site_address') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Enquire Form-->


@endsection
