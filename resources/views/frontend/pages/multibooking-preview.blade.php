@extends('frontend.layouts.master')
@section('content')

<!-- Car booking preview -->

<section class="appointment-preview ptb-60">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 col-md-12 mb-30">
                <div class="booking-area">
                    <div class="content pt-0">
                        <h3 class="title"><i class="fas fa-info-circle text--base mb-20"></i> {{ __("Booking Preview") }}</h3>
                        <div class="list-wrapper">
                            <ul class="list">
                                <li>{{ __("Pick-up Location") }} :<span>{{ @$customer->value->location }}</span></li>
                                <li>{{ __("Destination") }} :<span>{{ @$customer->value->destination }}</span></li>
                                <li>{{ __("Pick-up Date") }} :<span>{{ @$customer->value->pickup_date ? \Carbon\Carbon::parse($customer->value->pickup_date)->format('d-m-Y') : '' }}</span>
                                </li>
                                <li>{{ __("Pick-up Time") }} :<span>{{ @$customer->value->pickup_time ? \Carbon\Carbon::parse($customer->value->pickup_time)->format('h:i A') : '' }}</span>
                                </li>
                                <!-- عرض الوجهات وتواريخ وأوقات الاستلام بشكل ديناميكي -->
                                @if(isset($customer->value->destinations) && is_array($customer->value->destinations))
                                @foreach($customer->value->destinations as $index => $destination)
                                <li>{{ __("Pick-up Location") }} {{ $index + 1 }}:<span>{{ $customer->value->from[$index] ?? '' }}</span></li>
                                <li>{{ __("Destination") }}  :<span>{{ $destination }}</span></li>
                                <li>{{ __("Pick-up Date") }} :<span>{{ isset($customer->value->pickup_dates[$index]) ? \Carbon\Carbon::parse($customer->value->pickup_dates[$index])->format('d-m-Y') : '' }}</span></li>
                                <li>{{ __("Pick-up Time") }} :<span>{{ isset($customer->value->pickup_times[$index]) ? \Carbon\Carbon::parse($customer->value->pickup_times[$index])->format('h:i A') : '' }}</span></li>
                                @endforeach
                                @endif
                               
                                <li>{{ __("Round Trip Date") }} :<span>{{ @$customer->value->round_pickup_date ? \Carbon\Carbon::parse($customer->value->round_pickup_date)->format('d-m-Y') : 'N/A' }}</span>
                                </li>
                                <li>{{ __("Round Trip Time") }} :<span>{{ @$customer->value->round_pickup_time ? \Carbon\Carbon::parse($customer->value->round_pickup_time)->format('h:i A') : 'N/A' }}</span>
                                </li>
                                <li>{{ __("Car Model") }} :<span>{{ @$car->car_model }}</span></li>
                                <!--<li>{{ __("Car Number") }} :<span>{{ @$car->car_number }}</span></li>-->
                                <li>{{ __("Number of Cars") }} :<span>{{ @$customer->value->number_of_cars }}</span></li>
                                <li>{{ __("Estimated Price") }} :<span>{{ @$customer->value->estimated_price }} ريال</span></li>



                                @if(@$customer->value->booking_type=='round-trip')
                                <li>{{ __("Booking Type") }} :<span>{{ __('Round trip') }} </span></li>
                                @endif
                                @if(@$customer->value->booking_type=='one-way')
                                <li>{{ __("Booking Type") }} :<span>{{ __('One Way') }} </span></li>
                                @endif
                                @if(@$customer->value->booking_type=='layover')
                                <li>{{ __("Booking Type") }} :<span>{{ __('Full Day') }} </span></li>
                                @endif
                                {{-- <li>{{ __("Fees") }} :<span>5 USD</span></li> --}}
                                <!-- <li>{{ __("Rate") }} :<span>{{ get_amount(@$car->fees)}}{{ __("/KM") }} {{ $default_currency->code }}</span></li> -->
                                {{-- <li>{{ __("Total Amount") }}:<span>Will Calculate</span></li> --}}
                            </ul>
                        </div>
                        <div class="btn-area mt-20">
                            @if($customer->status == 1)
                            <button disabled type="submit" class="btn--base w-100">{{ __("Already Confirmed") }} <i class="fas fa-check-circle ms-1"></i></button>
                            @else
                            <a class="btn--base w-100" href="{{ setRoute('frontend.car.booking.confirm', $customer->token) }}">{{ __("Confirm Booking") }} <i class="fas fa-check-circle ms-1"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection