@extends('frontend.layouts.master')
@push('css')
<style>
    .quantity-controls {
        display: flex;
        align-items: center;
    }

    .quantity-btn {
        background-color: #ddd;
        border: 1px solid #ccc;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 16px;
        width: 30px;
        text-align: center;
    }

    .quantity-btn:disabled {
        background-color: #f0f0f0;
        cursor: not-allowed;
    }

    .hidden {
        display: none;
    }

    .readonly {
        pointer-events: none; /* Disable interactions */
        opacity: 0.6; /* Make it look disabled */
    }

    .disabled-checkbox {
        pointer-events: none; /* Disable interactions */
        opacity: 0.6; /* Make it look disabled */
    }
        .iti__dropdown {
        background-color: #2b2b2b;
        /* لون الخلفية الداكن */
        color: #ffffff;
        /* لون النص الأبيض */
    }

    /* تعديل مظهر النص في القائمة */
    .iti__country-name,
    .iti__dial-code {
        color: black;
        /* لون النص الأبيض */
    }

    /* تغيير لون الخلفية عند تمرير الماوس */
    .iti__country:hover,
    .iti__country--highlight {
        background-color: #1a1a1a;
        /* لون أغمق عند تمرير الماوس */
    }

    /* تعديل لون العلم والأيقونات إذا لزم الأمر */
    .iti__flag {
        border: none;
        /* إزالة حدود العلم */
    }

    /* تغيير لون الحدود إذا لزم الأمر */
    .iti__selected-flag {
        background-color: #2b2b2b;
        /* لون الخلفية للعلم المختار */
        color: #ffffff;
        /* لون النص للعلم المختار */
    }
</style>
@endpush
@section('content')

<!-- Car Booking -->
<section class="car-searching-area ptb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="car-booking-area">
                    <form class="booking-form" action="{{ route('frontend.car.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="car" value="{{ $car->slug }}">
                        <input type="hidden" name="country_code" class="form--control place-input" value="{{ $basic_settings->country_code }}">
                        <input type="hidden" name="estimated_price" id="estimated_price"> <!-- Hidden field for estimated price -->
                        <input type="hidden" name="booking_type" value="{{ $booking_type }}"> <!-- Hidden field for booking type -->
                        <input type="hidden" id="phone_with_country_code" name="phone_with_country_code">


                        <div class="form-header-title pb-20">
                        <h2 class="title text--base text-center">{{ __("Booking A Car").":".$car_name }}</h2>
                        @if($booking_type=='round-trip')
                        <h4 class="title text--base text-center">{{ __('Round trip') }}</h4>
                        @endif
                        @if($booking_type=='one-way')
                        <h4 class="title text--base text-center">{{ __('One Way') }}</h4>
                        @endif
                        @if($booking_type=='layover')
                        <h4 class="title text--base text-center">{{ __('Full Day') }}</h4>
                        @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-6 pb-10">
                                <label>{{ __("Email") }}*</label>
                                @php
                                $email = auth()->user()->email ?? "";
                                @endphp
                                <input type="email" name="credentials" required class="form--control" value="{{ $email }}" @if($email) readonly @endif>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <label>{{ __("Phone No") }}.</label>
                                <input type="tel" id="phone" name="mobile" class="form--control" value="{{ auth()->user()->mobile ?? "" }}">
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-area">
                                    <label>{{ __("Pick-up Location") }}*</label>
                                    <input type="text" name="location" required class="form--control place-input" value="{{ $area_from->name ?? '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-area">
                                    <label>{{ __("Destination") }}*</label>
                                    <input type="text" name="destination" required class="form--control place-input" value="{{ $area_to->name ?? '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-date">
                                    <label>{{ __("Pick-up Date") }}*</label>
                                    <input type="date" name="pickup_date" required class="form--control">
                                </div>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-date">
                                    <label>{{ __("Pick-up Time") }}*</label>
                                    <input type="time" name="pickup_time" required class="form--control">
                                </div>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-date">
                                    <label>{{ __("Number of Cars") }}*</label>
                                    <div class="quantity-controls">
                                        <button type="button" id="decrease-number" class="quantity-btn">-</button>
                                        <input type="number" name="number_of_cars" min="1" required class="form--control" placeholder="Enter number of cars" value="1">
                                        <button type="button" id="increase-number" class="quantity-btn">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-area">
                                    <label>{{ __("Estimated Price") }}</label>
                                    <input type="text" id="price-field" class="form--control" readonly placeholder="Price will be displayed here" value="{{ $car_price->price ? $car_price->price . ' ريال' : 'N/A' }}">
                                </div>
                            </div>
                            <div class="col-lg-12 pb-10">
                                <div class="select-date">
                                    <label>{{ __("Note") }} <span>( {{ __("Optional") }} )</span></label>
                                    <textarea class="form--control" name="message" placeholder="Write Here..."></textarea>
                                </div>
                            </div>
                            <!-- Checkbox for round trip -->
                            <div class="return-trip-checkbox">
                                <div class="custom-check-group">
                                    <input type="checkbox" id="round-trip-checkbox" class="dependency-checkbox {{ $booking_type != 'round-trip' ? 'hidden' : 'disabled-checkbox' }}" {{ $booking_type == 'round-trip' ? 'checked' : '' }}>
                                    <label for="round-trip-checkbox">{{ __("Round Trip?") }}</label>
                                </div>
                            </div>
                            <!-- Additional fields for round trip -->
                            <div class="book-check-form {{ $booking_type != 'round-trip' ? 'hidden' : '' }}">
                                <div class="row">
                                    <div class="col-lg-6 pb-10">
                                        <div class="select-date">
                                            <label>{{ __("Return Date") }}*</label>
                                            <input type="date" name="round_pickup_date" class="form--control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pb-10">
                                        <div class="select-date">
                                            <label>{{ __("Return Time") }}*</label>
                                            <input type="time" name="round_pickup_time" class="form--control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="searching-btn pt-3">
                            <button class="btn--base w-100">{{ __("Send Booking Request") }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        var phoneInput = document.querySelector("#phone");
        var iti = window.intlTelInput(phoneInput, {
            // options here
            separateDialCode: true,
                    initialCountry: "SA", // Set Saudi Arabia as the default country

            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js"
        });

        // Get phone number with country code on form submit
        $('form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            var phoneNumber = iti.getNumber(); // Get phone number with country code
            $('#phone_with_country_code').val(phoneNumber); // Set it in the hidden field

            // Optionally, you might want to submit the form programmatically
            this.submit();
        });
        // Initialize quantity controls
        initializeQuantityControls();

        // Calculate price on page load and whenever input changes
        calculatePrice();

        // Handle checkbox state based on booking type
        handleCheckboxState();
    });

    function initializeQuantityControls() {
        // Increase quantity
        $('#increase-number').on('click', function() {
            let numberOfCarsInput = $('input[name="number_of_cars"]');
            let currentValue = parseInt(numberOfCarsInput.val()) || 1;
            numberOfCarsInput.val(currentValue + 1);
            calculatePrice();
        });

        // Decrease quantity
        $('#decrease-number').on('click', function() {
            let numberOfCarsInput = $('input[name="number_of_cars"]');
            let currentValue = parseInt(numberOfCarsInput.val()) || 1;
            if (currentValue > 1) {
                numberOfCarsInput.val(currentValue - 1);
                calculatePrice();
            }
        });

        // Reset quantity if input is empty or invalid
        $('input[name="number_of_cars"]').on('input', function() {
            let numberOfCars = $(this).val();
            if (numberOfCars === '' || numberOfCars <= 0) {
                $(this).val(1);
                numberOfCars = 1;
            }
            calculatePrice();
        });
    }

    function calculatePrice() {
        // Calculate and update the price based on number of cars and trip type
        let basePrice = parseFloat('{{ $car_price->price ?? 100 }}'); // Ensure basePrice is a number
        if (isNaN(basePrice)) {
            basePrice = 100; // Fallback if basePrice is not a number
        }

        let numberOfCars = $('input[name="number_of_cars"]').val();
        let isRoundTrip = $('#round-trip-checkbox').is(':checked'); // Check if round trip checkbox is checked
        let totalPrice = numberOfCars * basePrice;

        // Double the price for round trip
        if (isRoundTrip) {
            totalPrice *= 2;
        }
        
        $('#price-field').val(`${totalPrice} ريال`);
        $('#estimated_price').val(totalPrice); // Update the hidden input field
    }

    function handleCheckboxState() {
    let bookingType = '{{ $booking_type }}'; // Get booking type
    if (bookingType === 'round-trip') {
        $('#round-trip-checkbox').prop('checked', true); // Ensure checkbox is checked
        $('#round-trip-checkbox').prop('disabled', true); // Disable checkbox
        $('#round-trip-checkbox').parent().show(); // Ensure the checkbox container is visible
    } else {
        $('#round-trip-checkbox').prop('checked', false); // Ensure checkbox is unchecked
        $('#round-trip-checkbox').prop('disabled', false); // Enable checkbox
        $('#round-trip-checkbox').parent().hide(); // Hide the checkbox container
    }
}

    $(document).on("change", ".dependency-checkbox", function() {
        dependencyCheckboxHandle($(this));
        calculatePrice(); // Recalculate price when checkbox changes
    });

    $(document).ready(function() {
        let dependencyCheckbox = $(".dependency-checkbox");
        $.each(dependencyCheckbox, function(index, item) {
            dependencyCheckboxHandle($(item));
        });
    });

    function dependencyCheckboxHandle(targetCheckbox) {
        let target = $(targetCheckbox).attr("data-target");
        if ($(targetCheckbox).is(":checked")) {
            $("." + target).slideDown(300);
        } else {
            $("." + target).slideUp(300);
        }
    }

    loadGoogleAutocompleteInput($("input[name='country_code']").val());
</script>
@endpush
