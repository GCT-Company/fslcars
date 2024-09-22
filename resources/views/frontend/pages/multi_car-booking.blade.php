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

    .destination-row {
        position: relative;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #e1e1e1;
        border-radius: 5px;
    }

    .remove-destination {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ff4d4d;
        border: none;
        color: white;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 14px;
        cursor: pointer;
        text-align: center;
    }

    .remove-destination:focus {
        outline: none;
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
                    <form class="booking-form" action="{{ route('frontend.car.booking.multistore') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_type" value="{{ __('Multi Booking') }}">

                        <input type="hidden" name="country_code" class="form--control place-input" value="{{ $basic_settings->country_code }}">
                                                <input type="hidden" id="phone_with_country_code" name="phone_with_country_code">

                        <input type="hidden" name="estimated_price" id="estimated_price"> <!-- Hidden field for estimated price -->
                        <div class="form-header-title pb-20">
                            <h2 class="title text--base text-center">{{ __("Multi Booking") }}</h2>
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
                            <div class="select-area">
                                <label>{{ __("Car Types") }}*</label>
                                <select name="cars[]" required class="form--control">
                                    <option disabled selected>{{ __('Select Type') }}</option>
                                    @foreach($cars as $car)
                                    <option value="{{ $car->car_slug }}">{{ $car->car_type_name }}</option>
                                    @endforeach
                                    <!-- <input type="hidden" name="cars[]" value="{{ $car->slug }}"> -->

                                </select>
                            </div>
                            <div class="col-lg-6 pb-10">
                                <div class="select-area">
                                    <label>{{ __("Pick-up Location") }}*</label>
                                    <select class="form--control select2-basic" name="location" spellcheck="false">
                                        <option disabled selected>{{ __('Select Area From') }}</option>
                                        @foreach ($area_from as $area)
                                        <option value="{{ $area->name }}">{{ $area->name }}</option>
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
                                        <option value="{{ $area_dest->name }}">{{ $area_dest->name }}</option>
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
                            <div id="destinations-container"></div> <!-- Container for dynamic destinations -->
                            <div class="col-lg-12 text-center pb-10">
                                <button type="button" id="add-destination" class="btn btn-primary" style="background-color: #2DA7B3;">
                                    + {{ __("Add Destination") }}
                                </button>
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
                                    <input type="text" name="estimated_price" id="price-field" class="form--control" readonly placeholder="Price will be displayed here">
                                </div>
                            </div>
                            <div class="col-lg-12 pb-10">
                                <div class="select-date">
                                    <label>{{ __("Note") }} <span>( {{ __("Optional") }} )</span></label>
                                    <textarea class="form--control" name="message" placeholder="Write Here..."></textarea>
                                </div>
                            </div>
                            <!-- <div class="return-trep-checkbox">
                                <div class="custom-check-group">
                                    <input type="checkbox" id="level-2" class="dependency-checkbox" data-target="book-check-form">
                                    <label for="level-2">{{ __("Round Trip?") }}</label>
                                </div>
                            </div> -->
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
                            <button class="btn--base w-100" style="background-color: #2DA7B3;">{{ __("Send Booking Request") }}</button>
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
        initializeQuantityControls();

        // حدث تغيير في تحديد الموقع أو الوجهة أو نوع السيارة
        $('select[name="location"], select[name="destination"], select[name="cars[]"]').on('change', function() {
            if ($('select[name="location"]').val() && $('select[name="destination"]').val() && $('select[name="cars[]"]').val()) {
                fetchPrice();
            }
        });

        // حدث عند النقر على زر إضافة وجهة
        $('#add-destination').on('click', function() {
            addDestinationRow();
        });

        function initializeQuantityControls() {
            $('#increase-number').on('click', function() {
                let numberOfCarsInput = $('input[name="number_of_cars"]');
                let currentValue = parseInt(numberOfCarsInput.val()) || 1;
                numberOfCarsInput.val(currentValue + 1);
                calculateTotalPrice();
            });

            $('#decrease-number').on('click', function() {
                let numberOfCarsInput = $('input[name="number_of_cars"]');
                let currentValue = parseInt(numberOfCarsInput.val()) || 1;
                if (currentValue > 1) {
                    numberOfCarsInput.val(currentValue - 1);
                    calculateTotalPrice();
                }
            });

            $('input[name="number_of_cars"]').on('input', function() {
                let numberOfCars = parseInt($(this).val()) || 1;
                if (numberOfCars <= 0) {
                    $(this).val(1);
                    numberOfCars = 1;
                }
                calculatePrice();
            });
        }

        function calculateTotalPrice() {
            let numberOfCars = parseInt($('input[name="number_of_cars"]').val()) || 1;
            let basePrice = parseFloat($('#estimated_price').val()) || 0;
            if (isNaN(basePrice)) {
                basePrice = 0; // تحديد السعر الأساسي إلى صفر إذا لم يكن رقم
            }
            if (isNaN(numberOfCars) || numberOfCars < 1) {
                numberOfCars = 1; // تعيين العدد إلى 1 إذا كان غير صحيح
            }
            // حساب السعر الإجمالي بناءً على السعر الأساسي وعدد السيارات
              let total=basePrice;
            // إضافة تكلفة الوجهات بناءً على عدد السيارات
            $('#destinations-container .destination-row').each(function() {
                let destinationPrice = parseFloat($(this).find('.destination-price').val()) || 0;
             
                total += destinationPrice ;
                                total = total * numberOfCars;
// مضاعفة تكلفة الوجهة بعدد السيارات
            });
            $('#price-field').val(`${total.toFixed(2)} ريال`);

            // $('#estimated_price').val(total.toFixed(2)); // تعيين السعر النهائي في الحقل المخفي
        }

        function fetchPrice() {
            let areaFrom = $('select[name="location"]').val();
            let areaTo = $('select[name="destination"]').val();
            let carId = $('select[name="cars[]"]').val();
             console.log(areaFrom);
             console.log(areaTo);
             console.log(carId);
            if (areaFrom && areaTo && carId) {
                $.ajax({
                    url: '{{ route("frontend.car.booking.multifetchPrice") }}',
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
                            $('#estimated_price').val(basePrice); // تعيين السعر الأساسي
                            calculateTotalPrice();
                        } else {
                            $('#price-field').val('N/A');
                            $('#estimated_price').val(0);
                            calculateTotalPrice(); // في حالة عدم الحصول على السعر
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#price-field').val('Error fetching price');
                        $('#estimated_price').val(0);
                        calculateTotalPrice(); // في حالة حدوث خطأ
                    }
                });
            }
        }

        function addDestinationRow() {
            let destinationCount = $('#destinations-container .destination-row').length;

            if (destinationCount >= 4) {
                alert('لا يمكنك إضافة أكثر من أربع وجهات.');
                return;
            }

            let newRow = `
        <div class="destination-row row">
            <div class="col-lg-6 pb-10">
                <div class="select-area">
                    <label>{{ __("Pick-up Location") }}*</label>
                    <select name="from[]" required class="form--control">
                        <option disabled selected>{{ __('Select Area From') }}</option>
                        @foreach($area_from as $area)
                            <option value="{{ $area->name }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 pb-10">
                <div class="select-area">
                    <label>{{ __("Destination") }}*</label>
                    <select name="destinations[]" required class="form--control">
                        <option disabled selected>{{ __('Select Area Destination') }}</option>
                        @foreach($area_to as $area_dest)
                            <option value="{{ $area_dest->name }}">{{ $area_dest->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 pb-10">
                <div class="select-date">
                    <label>{{ __("Pick-up Date") }}*</label>
                    <input type="date" name="pickup_dates[]" required class="form--control">
                </div>
            </div>
            <div class="col-lg-6 pb-10">
                <div class="select-date">
                    <label>{{ __("Pick-up Time") }}*</label>
                    <input type="time" name="pickup_times[]" required class="form--control">
                </div>
            </div>
            <input type="hidden" class="destination-price" value="0">
            <button type="button" class="remove-destination">x</button>
        </div>
        `;

            $('#destinations-container').append(newRow);

            // إعادة تسجيل الأحداث للصفوف الجديدة
            $('#destinations-container').on('change', '.destination-row select[name="destinations[]"]', function() {
                let $row = $(this).closest('.destination-row');
                let destinationId = $(this).val();
                let carId = $('select[name="cars[]"]').val();
                let areaFrom = $row.find('select[name="from[]"]').val();

                if (destinationId && carId && areaFrom) {
                    $.ajax({
                        url: '{{ route("frontend.car.booking.multifetchPrice") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            area_from: areaFrom,
                            area_to: destinationId,
                            car_id: carId
                        },
                        success: function(response) {
                            if (response.success) {
                                let destinationPrice = parseFloat(response.price) || 0;
                                $row.find('.destination-price').val(destinationPrice);
                                calculateTotalPrice();
                            } else {
                                $row.find('.destination-price').val(0);
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // تسجيل حدث إزالة الوجهات
            $('#destinations-container').on('click', '.remove-destination', function() {
                let $row = $(this).closest('.destination-row');
                $row.remove();
                calculateTotalPrice();
            });
        }
    });
</script>
@endpush