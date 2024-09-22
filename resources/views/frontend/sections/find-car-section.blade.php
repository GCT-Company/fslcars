@push('css')
<style>
  .nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #ffffff; /* لون الخط الأبيض */
    font-weight: 600;
    padding: 8px 12px;
    font-size: 0.875rem;
    background-color: #2DA7B3; /* لون خلفية الزر */
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.nav-tabs .nav-link.active {
    border-bottom-color: #ffffff; /* لون الحدود أسفل الزر النشط */
    background-color: #ffffff; /* لون خلفية الزر النشط عند التفعيل */
}

.nav-tabs .nav-link:hover {
    background-color: #1e8dbb; /* لون خلفية الزر عند التمرير بالماوس */
}



    .nav-item {
        padding: 2px;
    }

    .nav-tabs .nav-link.active {
        border-bottom-color: #007bff;
        color: #2DA7B3;
    }

    .banner-flotting-item-form {
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .form--control {
        flex: 1;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        font-size: 0.875rem;
        transition: border-color 0.3s ease;
    }

    .form--control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
    }

    .search-btn {
    margin-left: 10px;
    padding: 5px; /* تقليل حجم الحشو */
    border: none;
    background-color: #2DA7B3;
    color: #ffffff;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px; /* عرض الزر ليكون بحجم أيقونة */
    height: 40px; /* طول الزر ليكون بحجم أيقونة */
}

.search-btn:hover {
    background-color: #0056b3; /* لون خلفية عند التمرير */
}

.search-btn i {
    font-size: 1.25rem; /* تكبير الأيقونة قليلاً */
}
</style>
@endpush

<div class="banner-flotting-section {{ $class ?? '' }}">
    <div class="container">
        <div class="banner-flotting-item">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="one-way-tab" data-bs-toggle="tab" data-bs-target="#one-way" type="button" role="tab" aria-controls="one-way" aria-selected="true">
                        <i class="fas fa-arrow-right"></i> {{ __('One Way') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="round-trip-tab" data-bs-toggle="tab" data-bs-target="#round-trip" type="button" role="tab" aria-controls="round-trip" aria-selected="false">
                        <i class="fas fa-sync-alt"></i> {{ __('Round trip') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="multi-tab" data-bs-toggle="tab" data-bs-target="#multi" type="button" role="tab" aria-controls="multi" aria-selected="false">
                        <a  href="{{ route('frontend.car.booking.multibooking') }}" >
                            <i class="fas fa-clock"></i> {{ __('Multi Booking') }}
                        </a> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="layover-tab" data-bs-toggle="tab" data-bs-target="#layover" type="button" role="tab" aria-controls="layover" aria-selected="false">
                        <i class="fas fa-clock"></i> {{ __('Full Day') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
                    <form class="banner-flotting-item-form" method="GET" action="{{ route('frontend.car.booking.bookingcore') }}">
                        @csrf
                        <input type="hidden" name="tab" id="current-tab" value="one-way">
                        <div class="form-group">
                            @php
                            $old_area = request()->get('area');
                            $old_type = request()->get('type');
                            @endphp
                            <select class="form--control select2-basic" name="area_from" spellcheck="false">
                                <option disabled selected>{{ __('Select Area From') }}</option>
                                @foreach ($areas as $area)
                                <option {{ $old_area == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form--control select2-basic" name="area_to" spellcheck="false">
                                <option disabled selected>{{ __('Select Area To') }}</option>
                                @foreach ($areas_destination as $area_dest)
                                <option {{ $old_area == $area_dest->id ? 'selected' : '' }} value="{{ $area_dest->id }}">{{ $area_dest->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                     <select class="form--control select2-basic" name="type" id="car_type" spellcheck="false">
                                <option disabled selected>{{ __("Select Type") }}</option>
                                @foreach($car_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base search-btn w-100"><i class="fas fa-search me-1"></i> {{ __("Search") }}</button>
                </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="round-trip" role="tabpanel" aria-labelledby="round-trip-tab">
                    <form class="banner-flotting-item-form" method="GET" action="{{ route('frontend.car.booking.bookingcore') }}">
                        @csrf
                        <input type="hidden" name="tab" id="current-tab" value="round-trip">
                        <div class="form-group">
                            @php
                            $old_area = request()->get('area');
                            $old_type = request()->get('type');
                            @endphp
                            <select class="form--control select2-basic" name="area_from" spellcheck="false">
                                <option disabled selected>{{ __('Select Area From') }}</option>
                                @foreach ($areas as $area)
                                <option {{ $old_area == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form--control select2-basic" name="area_to" spellcheck="false">
                                <option disabled selected>{{ __('Select Area To') }}</option>
                                @foreach ($areas_destination as $area_dest)
                                <option {{ $old_area == $area_dest->id ? 'selected' : '' }} value="{{ $area_dest->id }}">{{ $area_dest->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                     <select class="form--control select2-basic" name="type" id="car_type" spellcheck="false">
                                <option disabled selected>{{ __("Select Type") }}</option>
                                @foreach($car_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base search-btn w-100"><i class="fas fa-search me-1"></i> {{ __("Search") }}</button>
                </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="layover" role="tabpanel" aria-labelledby="layover-tab">
                    <form class="banner-flotting-item-form" method="GET" action="{{ route('frontend.car.booking.bookingcore') }}">
                        @csrf
                        <input type="hidden" name="tab" id="current-tab" value="layover">
                        <div class="form-group">
                            @php
                            $old_area = request()->get('area');
                            $old_type = request()->get('type');
                            @endphp
                            <select class="form--control select2-basic" name="area_from" spellcheck="false">
                                @foreach ($areas as $area)
                                @if ($area->name == 'مرابطة يوم كامل')
                                <option {{ $old_area == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ $area->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form--control select2-basic" name="area_to" spellcheck="false">
                                <option disabled selected>{{ __('Select Area To') }}</option>
                                @foreach ($areas_destination as $area_dest)
                                <option {{ $old_area == $area_dest->id ? 'selected' : '' }} value="{{ $area_dest->id }}">{{ $area_dest->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                     <select class="form--control select2-basic" name="type" id="car_type" spellcheck="false">
                                <option disabled selected>{{ __("Select Type") }}</option>
                                @foreach($car_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base search-btn w-100"><i class="fas fa-search me-1"></i> {{ __("Search") }}</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    var getTypeURL = "{{ route('frontend.get.area.types') }}";
    var old_type = "{{ $old_type }}";

    $(document).ready(function() {
        getAreaItems();

        $('select[name="area_from"], select[name="area_to"]').on('change', function() {
            getAreaItems();
        });

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            var tabId = $(e.target).attr('id'); // الحصول على الـ id للتبويب النشط
            $('#current-tab').val(tabId); // تحديث قيمة الحقل المخفي
        });

        function getAreaItems() {
            var area = $('select[name="area_from"]').val();

            if (area == "" || area == null) {
                return false;
            }

            $.post(getTypeURL, {
                area: area,
                _token: "{{ csrf_token() }}"
            }, function(response) {
                var option = '';
                if (response.data.area.types.length > 0) {
                    $.each(response.data.area.types, function(index, item) {
                        if (item.type != null) {
                            var selected_item = old_type == item.car_type_id ? "selected" : "";
                            option += `<option ${selected_item} value="${item.car_type_id}">${item.type.name}</option>`;
                        }
                    });

                    $("select[name='type']").html(option);
                    $("select[name='type']").select2();
                }
            }).fail(function(response) {
                alert('An error occurred.');
            });
        }

        $('#add-more').click(function() {
            var fieldGroup =
                `<div class="form-group inline-fields">
                    <select class="form--control select2-basic" name="area_from[]" spellcheck="false">
                        <option disabled selected>{{ __('Select Area From') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <select class="form--control select2-basic" name="area_to[]" spellcheck="false">
                        <option disabled selected>{{ __('Select Area To') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-secondary remove-field">-</button>
                </div>`;
            $('#additional-fields').append(fieldGroup);
        });

        $(document).on('click', '.remove-field', function() {
            $(this).parent('.inline-fields').remove();
        });
    });
</script>
@endpush