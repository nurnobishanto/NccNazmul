@extends('layouts.master')

@section('content')
    <!-- Start Contact Information Area -->
    <div class="contact-information-area pt-100 pb-75">
        <div class="container">
            <div class="section-title">
                <span>Contact us</span>
                <h2>Heading</h2>
                <p>Description</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="contact-information-card">
                        <div class="icon">
                            <i class="ri-map-pin-line"></i>
                        </div>
                        <h3>{{ 'Address' }}</h3>
                        <p>{{ getSetting('site_address') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="contact-information-card">
                        <div class="icon">
                            <i class="ri-mail-line"></i>
                        </div>
                        <h3>{{ 'Email Address' }}</h3>
                        <p><a href="mailto:{{ getSetting('site_email') }}">{{ getSetting('site_email') }}</a></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="contact-information-card">
                        <div class="icon">
                            <i class="ri-phone-line"></i>
                        </div>
                        <h3>{{ 'Phone Number' }}</h3>
                        <p><a href="tel:{{ getSetting('site_phone') }}">{{ getSetting('site_phone') }}</a></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="contact-information-card">
                        <div class="icon">
                            <i class="ri-time-line"></i>
                        </div>
                        <h3>{{ 'Working Hours' }}</h3>
                        <p>{{ 'Alawyas' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Information Area -->

    <!-- Start Contact Area -->
    <div class="contact-area pb-100">
        <div class="container">
            <div class="section-title">
                <h2>{{ 'Get In Touch' }}</h2>
            </div>



            <form class="contactForm" class="col" action="{{ route('contact_form.store') }}" method="POST">
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
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <select name="type" class="form-select">
                                <option value="">Select contact type</option>
                                <option value="Admission">Admission</option>
                                <option value="General Contact">General Contact</option>
                                <option value="English Special Batch">English Special Batch</option>
                                <option value="HSC Special Batch">HSC Special Batch</option>
                                <option value="HSC Batch">HSC Batch</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>{{ 'Your Name *' }}</label>
                            <input value="{{ old('name') }}" type="text" name="name" id="name"
                                class="form-control" placeholder="{{ 'Eg: Thomas Adison' }}"
                                data-error="Please enter your name">
                            <div class="help-block with-errors">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>{{ 'Email *' }}</label>
                            <input value="{{ old('email') }}" type="email" name="email" id="email"
                                class="form-control" placeholder="{{ 'Eg: example@accountingclubbd.com' }}"
                                data-error="Please enter your email">
                            <div class="help-block with-errors">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>{{ 'Phone *' }}</label>
                            <input value="{{ old('phone') }}" type="text" name="phone" id="phone_number"
                                placeholder="{{ 'Enter your phone number' }}" data-error="Please enter your number"
                                class="form-control">
                            <div class="help-block with-errors">
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>{{ 'Subject *' }}</label>
                            <input value="{{ old('subject') }}" type="text" name="subject" id="msg_subject"
                                placeholder="{{ 'Enter your subject' }}" class="form-control"
                                data-error="Please enter your subject">
                            <div class="help-block with-errors">
                                @if ($errors->has('subject'))
                                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>{{ 'Your Message' }}</label>
                            <textarea value="{{ old('message') }}" name="message" class="form-control" id="message"
                                placeholder="{{ 'Type your message' }}" cols="30" rows="6" data-error="Write your message"></textarea>
                            <div class="help-block with-errors">
                                @if ($errors->has('message'))
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <p class="form-cookies-consent">
                            <input type="checkbox" id="test1" required>
                            <label for="test1">{{ 'Accept' }} <a
                                    href="#">{{ 'Terms Of Services' }}</a>
                                {{ 'And' }} <a
                                    href="#">{{ 'Privacy Policy.' }}</a></label>
                        </p>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="send-btn">
                            <button type="submit" class="default-btn">Contact Now</button>
                        </div>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- End Contact Area -->
@endsection
