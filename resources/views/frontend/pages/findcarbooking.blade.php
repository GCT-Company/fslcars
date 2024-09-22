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
                        @php
                        $old_area = request()->get('area-from');
                        $old_area_to = request()->get('area-to');
                        $old_price = request()->get('price');
                        @endphp
                        <input type="hidden" name="car" value="{{ $car->slug }}">
                        <input type="hidden" id="phone_with_country_code" name="phone_with_country_code">
                        <input type="hidden" name="country_code" class="form--control place-input" value="{{ $basic_settings->country_code }}">
                        <input type="hidden" name="estimated_price" id="estimated_price"> <!-- Hidden field for estimated price -->
                        <input type="hidden" name="booking_type" value="One Way"> <!-- Hidden field for booking type -->

                        <div class="form-header-title pb-20">
                        <h2 class="title text--base text-center">{{ __("Booking A Car") }}</h2>
                        <h3 class="title text--base text-center" style="color: #ffff">{{ $car_name }}</h3>
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
                                    <select class="form--control select2-basic" name="location" spellcheck="false">
                                        <option disabled selected>{{ __('Select Area From') }}</option>
                                        @foreach ($area_from as $area)
                                        <option {{ $old_area == $area->id ? 'selected' : '' }} value="{{ $area->name }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-area">
                                    <label>{{ __("Destination") }}*</label>
                                    <select class="form--control select2-basic" name="destination" spellcheck="false">
                                        <option disabled selected>{{ __('Select Area To') }}</option>
                                        @foreach ($area_to as $area_dest)
                                        <option {{ $old_area_to == $area_dest->id ? 'selected' : '' }} value="{{ $area_dest->name }}">{{ $area_dest->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <input type="text" id="price-field" class="form--control" readonly placeholder="Price will be displayed here">
                                </div>
                            </div>
                            <div class="col-lg-12 pb-10">
                                <div class="select-date">
                                    <label>{{ __("Note") }} <span>( {{ __("Optional") }} )</span></label>
                                    <textarea class="form--control" name="message" placeholder="Write Here..."></textarea>
                                </div>
                            </div>
                            <div class="return-trep-checkbox">
                                <div class="custom-check-group">
                                    <input type="checkbox" id="level-2" class="dependency-checkbox" data-target="book-check-form">
                                    <label for="level-2">{{ __("Round Trip?") }}</label>
                                </div>
                            </div>
                            <div class="book-check-form" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-6 pb-10">
                                        <div class="select-date">
                                            <label>{{ __("Pick-up Date") }}*</label>
                                            <input type="date" name="round_pickup_date" class="form--control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pb-10">
                                        <div class="select-date">
                                            <label>{{ __("Pick-up Time") }}*</label>
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
        // Initialize phone input with international format
        var phoneInput = document.querySelector("#phone");
        var iti = window.intlTelInput(phoneInput, {
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

        // Event listeners for area changes
        $('select[name="location"], select[name="destination"]').on('change', function() {
            setBookingType(); // تحديث قيمة booking_type عند تغيير الحالة

            if ($('select[name="location"]').val() && $('select[name="destination"]').val()) {
                fetchPrice();
            }
        });
    });

    function setBookingType() {
        let locationValue = $('select[name="location"]').val();
        let isRoundTripChecked = $('#level-2').is(':checked');
        let bookingType = 'one-way'; // القيمة الافتراضية

        if (isRoundTripChecked) {
            bookingType = 'round-trip';
        } else if (locationValue && locationValue.includes('مرابطة يوم كامل')) {
            bookingType = 'Full Day';
        }

        $('input[name="booking_type"]').val(bookingType);
    }

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
            let numberOfCars = parseInt($(this).val()) || 1;
            if (numberOfCars <= 0) {
                $(this).val(1);
                numberOfCars = 1;
            }
            calculatePrice();
        });
    }

    function fetchPrice() {
        let areaFrom = $('select[name="location"]').val();
        let areaTo = $('select[name="destination"]').val();
        let carId = '{{ $car->car_type_id }}';
        $.ajax({
            url: '{{ route("frontend.car.booking.fetch_price") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                area_from: areaFrom,
                area_to: areaTo,
                car_id: carId
            },
            success: function(response) {
                if (response.success) {
                    let basePrice = parseFloat(response.price) || 0;
                    $('#price-field').val(`${basePrice} ريال`);
                    $('#estimated_price').val(basePrice).data('base-price', basePrice); // حفظ السعر الأساسي كبيانات
                    calculatePrice(); // إعادة حساب السعر الإجمالي
                } else {
                    $('#price-field').val('N/A');
                    $('#estimated_price').val(0);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#price-field').val('Error fetching price');
                $('#estimated_price').val(0);
            }
        });
    }

    function calculatePrice() {
        // استرجاع السعر الأساسي من الحقل المخفي
        let basePrice = parseFloat($('#estimated_price').data('base-price')) || 0;

        // التحقق من صحة السعر الأساسي
        if (isNaN(basePrice)) {
            basePrice = 0; // تحديد السعر الأساسي إلى صفر إذا لم يكن رقم
        }

        // استرجاع عدد السيارات
        let numberOfCars = parseInt($('input[name="number_of_cars"]').val()) || 1;

        // التحقق من صحة عدد السيارات
        if (isNaN(numberOfCars) || numberOfCars < 1) {
            numberOfCars = 1; // تعيين العدد إلى 1 إذا كان غير صحيح
        }

        // حساب السعر الإجمالي بناءً على عدد السيارات
        let totalPrice = numberOfCars * basePrice;

        // مضاعفة السعر إذا كان خيار Round Trip محدد
        if ($('#level-2').is(':checked')) {
            totalPrice *= 2;
        }

        // تحديث الحقول بقيمة السعر الإجمالي
        $('#price-field').val(`${totalPrice} ريال`);
        $('#estimated_price').val(totalPrice); // تحديث الحقل المخفي بقيمة السعر الإجمالي
    }

    $(document).on("change", ".dependency-checkbox", function() {
        dependencyCheckboxHandle($(this));
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
        calculatePrice(); // إعادة حساب السعر عند تغيير حالة الـ checkbox
    }

    loadGoogleAutocompleteInput($("input[name='country_code']").val());
</script>
@endpush