<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Constants\GlobalConst;
use App\Models\Admin\Cars\Car;
use App\Models\Admin\SetupPage;
use App\Constants\LanguageConst;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Cars\CarBooking;
use App\Models\Admin\UserNotification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\bookingConfirmation;
use Illuminate\Support\Facades\Notification;
use App\Notifications\carBookingNotification;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Cars\CarPrice;
use App\Models\Admin\Cars\CarArea;
use App\Models\Admin\Cars\CarType;

class CarBookingController extends Controller
{
    public function booking($slug,$car_name)
    {

        $area_from = CarArea::all();
        $area_to = CarArea::all();
        $page_title = setPageTitle(__("Car Booking"));
        $car = Car::where('slug', $slug)->first();

        if (!$car) abort(404);

        $footer_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer = SiteSections::getData($footer_slug)->first();
        $type =  Str::slug(GlobalConst::USEFUL_LINKS);
        $policies = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->get();
        $policy = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->where('slug', 'privacy-policy')->first();
        $validated_user = auth()->user();
        $about_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about = SiteSections::getData($about_slug)->first();
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $default = LanguageConst::NOT_REMOVABLE;
        $car_prices = CarPrice::all(); // Adjust this based on your actual column names

        return view('frontend.pages.findcarbooking', compact(
            'page_title',
            'car',
            'footer',
            'validated_user',
            'policies',
            'policy',
            'about',
            'auth',
            'default',
            'area_from', // تمرير المناطق من
            'area_to',
            'car_prices',
            'car_name'
            // Add this line

        ));
    }
    public function multibooking()
    {

        $area_from = CarArea::all();
        $area_to = CarArea::all();
        $page_title = setPageTitle(__("Car Booking"));
        $cars = Car::join('car_types', 'cars.car_type_id', '=', 'car_types.id')
            ->select('cars.id as car_id', 'cars.slug  as car_slug', 'car_types.id as car_type_id', 'car_types.name as car_type_name')
            ->get();
        if (!$cars) abort(404);
        // dd($cars);
        $footer_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer = SiteSections::getData($footer_slug)->first();
        $type =  Str::slug(GlobalConst::USEFUL_LINKS);
        $policies = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->get();
        $policy = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->where('slug', 'privacy-policy')->first();
        $validated_user = auth()->user();
        $about_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about = SiteSections::getData($about_slug)->first();
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $default = LanguageConst::NOT_REMOVABLE;
        $car_prices = CarPrice::all(); // Adjust this based on your actual column names

        return view('frontend.pages.multi_car-booking', compact(
            'page_title',
            'cars',
            'footer',
            'validated_user',
            'policies',
            'policy',
            'about',
            'auth',
            'default',
            'area_from', // تمرير المناطق من
            'area_to',
            'car_prices' // Add this line

        ));
    }

    public function multifetchPrice(Request $request)
    {
        // استقبال name من الـ request
        $areaFromName = $request->input('area_from');
        $areaToName = $request->input('area_to');
        $slug = $request->input('car_id');

        // جلب id بناءً على name من جدول car_area
        $areaFrom = CarArea::where('name', $areaFromName)->first();
        $areaTo = CarArea::where('name', $areaToName)->first();

        if ($areaFrom && $areaTo) {
            // استخدام id في الاستعلام على جدول car_prices
            $car = Car::where('slug', $slug)->first(); // أو استخدام `firstOrFail` إذا كنت تريد إلقاء استثناء إذا لم يتم العثور على النتيجة
            // استخدام id في الاستعلام على جدول car_prices
            $price = CarPrice::where('from', $areaFrom->id)
                ->where('destination', $areaTo->id)
                ->where('car_id', $car->car_type_id)
                ->first();

            if ($price) {
                return response()->json([
                    'success' => true,
                    'price' => $price->price
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'price' => 0
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'price' => 0
            ]);
        }
    }

    public function fetchPrice(Request $request)
    {
        // استقبال name من الـ request
        $areaFromName = $request->input('area_from');
        $areaToName = $request->input('area_to');
        $carId = $request->input('car_id');

        // جلب id بناءً على name من جدول car_area
        $areaFrom = CarArea::where('name', $areaFromName)->first();
        $areaTo = CarArea::where('name', $areaToName)->first();

        if ($areaFrom && $areaTo) {
            // استخدام id في الاستعلام على جدول car_prices
            $price = CarPrice::where('from', $areaFrom->id)
                ->where('destination', $areaTo->id)
                ->where('car_id', $carId)
                ->first();

            if ($price) {
                return response()->json([
                    'success' => true,
                    'price' => $price->price
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'price' => 0
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'price' => 0
            ]);
        }
    }



    public function bookingcore(Request $request)
    {
        // dd($request);
        $booking_type = $request->input('tab');
        // dd($booking_type);

        // استرجاع القيم من الطلب
        $area_from_id = $request->input('area_from');
        $area_to_id = $request->input('area_to');
        $car_id = $request->input('type');
         $car = CarType::find($car_id); // يفترض أن لديك موديل CarType

        
            $car_name = $car->name; // هنا تحصل على اسم السيارة
            // dd($car_name); // تعرض اسم السيارة
      
        // تحقق من القيم المدخلة
        if (!$area_from_id || !$area_to_id || !$car_id) {
            return redirect()->back()->withErrors(__('Please provide all required fields.'));
        }

        // جلب السيارة
        $car = Car::where('car_type_id', $car_id)->first();
        if (!$car) {
            abort(404);
        }
        // جلب السعر من جدول car_price
        $car_price = CarPrice::where('car_id', $car_id)
            ->where('from', $area_from_id)
            ->where('destination', $area_to_id)
            ->first();
        if (!$car_price) {
            return redirect()->back()->withErrors(__('Price not found for the selected route.'));
        }

        // جلب أسماء المناطق من جدول car_areas
        $area_from = CarArea::find($area_from_id);
        $area_to = CarArea::find($area_to_id);
        // تحقق من وجود المناطق
        if (!$area_from || !$area_to) {
            return redirect()->back()->withErrors(__('One or both of the specified areas do not exist.'));
        }

        // إعداد البيانات المطلوبة للعرض
        $page_title = setPageTitle(__("Car Booking"));
        $footer_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer = SiteSections::getData($footer_slug)->first();
        $type = Str::slug(GlobalConst::USEFUL_LINKS);
        $policies = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->get();
        $policy = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->where('slug', 'privacy-policy')->first();
        $validated_user = auth()->user();
        $about_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about = SiteSections::getData($about_slug)->first();
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $default = LanguageConst::NOT_REMOVABLE;
        return view('frontend.pages.car-booking', compact(
            'page_title',
            'car',
            'footer',
            'validated_user',
            'policies',
            'policy',
            'about',
            'auth',
            'default',
            'car_price',
            'area_from',   // إضافة أسماء المناطق إلى البيانات المعروضة
            'area_to',
            'booking_type',
            'car_name'
        ));
    }

    public function multistore(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return back()->with(['error' => [__('You must be logged in to complete the booking.')]]);
        }

        $validator = Validator::make($request->all(), [
            'cars'                => 'required',
            'location'           => 'required',
            'destination'        => 'required',
            'credentials'        => 'required|email',
            'pickup_time'        => 'required',
            'pickup_date'        => 'required',
            'mobile'             => 'nullable',
            'round_pickup_date'  => 'nullable',
            'round_pickup_time'  => 'nullable',
            'message'            => 'nullable',
            'number_of_cars'     => 'required|integer|min:1',
            'estimated_price'    => '',
            'booking_type'       => '|string' ,
            'from'               =>'',
            'destinations'               =>'',
            'pickup_dates'               =>'',
            'pickup_times'               =>'',

            

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all());
        }
        $validated = $validator->validate();

        $pickupDateTime = Carbon::parse($validated['pickup_date'] . ' ' . $validated['pickup_time']);
        if ($pickupDateTime->isPast()) {
            return back()->with(['error' => [__('Pickup date and time must be in the future.')]]);
        }

        if (!empty($validated['round_pickup_date']) && !empty($validated['round_pickup_time'])) {
            $roundPickupDateTime = Carbon::parse($validated['round_pickup_date'] . ' ' . $validated['round_pickup_time']);
            if ($roundPickupDateTime->isPast()) {
                return back()->with(['error' => [__('Round pickup date and time must be in the future.')]]);
            }

            if ($roundPickupDateTime->lte($pickupDateTime)) {
                return back()->with(['error' => [__('Round pickup date and time must be greater than pickup date and time.')]]);
            }
        }

        $validated['email'] = $validated['credentials'];
        $validated['phone'] = $validated['mobile'];
        $validated['slug']  = Str::uuid();
        $car_slug           = $validated['cars'];

        $findCar            = Car::where('slug', $car_slug)->first();
        // dd($findCar);

        if (!$findCar) {
            return back()->with(['error' => [__('Car not found!')]]);
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['car_id'] = $findCar->id;

        $already_booked_car = CarBooking::where('car_id', $findCar->id)
            ->where('pickup_date', $validated['pickup_date'])
            ->count();
        // if ($already_booked_car > 0) {
        //     return back()->with(['error' => [__('This car is already booked at the selected date')]]);
        // }

        try {
            $car_booking = TemporaryData::create([
                'token' => generate_unique_string("temporary_datas", "token", 20),
                'value' => $validated,
            ]);
            // dd( $car_booking->token);

            return redirect()->route('frontend.car.booking.multipreview', $car_booking->token);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something Went Wrong! Please try again.')]]);
        }
    }
    public function store(Request $request)
    {

        // Check if the user is authenticated
        if (!auth()->check()) {
            return back()->with(['error' => [__('You must be logged in to complete the booking.')]]);
        }

        $validator = Validator::make($request->all(), [
            'car'                => 'required',
            'location'           => 'required',
            'destination'        => 'required',
            'credentials'        => 'required|email',
            'pickup_time'        => 'required',
            'pickup_date'        => 'required',
            'mobile'             => 'nullable',
            'round_pickup_date'  => 'nullable',
            'round_pickup_time'  => 'nullable',
            'message'            => 'nullable',
            'number_of_cars'     => 'required|integer|min:1',
            'estimated_price'    => 'required|numeric',
            'booking_type'       => '|string' // Ensure this validation rule exists

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all());
        }
        $validated = $validator->validate();

        $pickupDateTime = Carbon::parse($validated['pickup_date'] . ' ' . $validated['pickup_time']);
        if ($pickupDateTime->isPast()) {
            return back()->with(['error' => [__('Pickup date and time must be in the future.')]]);
        }

        if (!empty($validated['round_pickup_date']) && !empty($validated['round_pickup_time'])) {
            $roundPickupDateTime = Carbon::parse($validated['round_pickup_date'] . ' ' . $validated['round_pickup_time']);
            if ($roundPickupDateTime->isPast()) {
                return back()->with(['error' => [__('Round pickup date and time must be in the future.')]]);
            }

            if ($roundPickupDateTime->lte($pickupDateTime)) {
                return back()->with(['error' => [__('Round pickup date and time must be greater than pickup date and time.')]]);
            }
        }

        $validated['email'] = $validated['credentials'];
        $validated['phone'] = $validated['mobile'];
        $validated['slug']  = Str::uuid();
        $car_slug           = $validated['car'];
        $findCar            = Car::where('slug', $car_slug)->first();

        if (!$findCar) {
            return back()->with(['error' => [__('Car not found!')]]);
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['car_id'] = $findCar->id;

        $already_booked_car = CarBooking::where('car_id', $findCar->id)
            ->where('pickup_date', $validated['pickup_date'])
            ->count();
        // if ($already_booked_car > 0) {
        //     return back()->with(['error' => [__('This car is already booked at the selected date')]]);
        // }
        $lastBooking = CarBooking::orderBy('Booking_no', 'desc')->first();
        $nextBookingNo = $lastBooking ? $lastBooking->Booking_no + 1 : 5001;

        $validated['booking_no'] = $nextBookingNo;
        // dd($nextBookingNo);
        try {
            $car_booking = TemporaryData::create([
                'token' => generate_unique_string("temporary_datas", "token", 20),
                'value' => $validated,
            ]);

            return redirect()->route('frontend.car.booking.preview', $car_booking->token);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something Went Wrong! Please try again.')]]);
        }
    }

    public function multipreview($token)
    {
        
        $page_title = setPageTitle(__("Booking Preview"));
        $footer_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer = SiteSections::getData($footer_slug)->first();
        $type =  Str::slug(GlobalConst::USEFUL_LINKS);
        $policies = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->get();
        $policy = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->where('slug', 'privacy-policy')->first();
        $validated_user = auth()->user();
        $about_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about = SiteSections::getData($about_slug)->first();
        $customer = TemporaryData::where('token', $token)->first();
        // dd($customer);
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $car = Car::where('id', $customer->value->car_id)->first();
        $default = LanguageConst::NOT_REMOVABLE;
        return view('frontend.pages.multibooking-preview', compact(
            'page_title',
            'about',
            'customer',
            'footer',
            'policy',
            'policies',
            'car',
            'auth',
            'default'
        ));
    }

    public function preview($token)
    {

        $page_title = setPageTitle(__("Booking Preview"));
        $footer_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer = SiteSections::getData($footer_slug)->first();
        $type =  Str::slug(GlobalConst::USEFUL_LINKS);
        $policies = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->get();
        $policy = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->where('slug', 'privacy-policy')->first();
        $validated_user = auth()->user();
        $about_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about = SiteSections::getData($about_slug)->first();
        $customer = TemporaryData::where('token', $token)->first();
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $car = Car::where('id', $customer->value->car_id)->first();
        $default = LanguageConst::NOT_REMOVABLE;
        return view('frontend.pages.booking-preview', compact(
            'page_title',
            'about',
            'customer',
            'footer',
            'policy',
            'policies',
            'car',
            'auth',
            'default'
        ));
    }

  
    public function confirm($token)
    {
        
        Log::info('Confirm booking called with token: ' . $token);

        $temp_booking = TemporaryData::where('token', $token)->first();
        if (!$temp_booking) {
            Log::error('Booking not found for token: ' . $token);
            return back()->with(['error' => [__('Booking Not Found!')]]);
        }

        Log::info('Temporary booking found: ', $temp_booking->toArray());

        $temp_data = json_decode(json_encode($temp_booking->value), true);
        $send_code = generate_random_code();
        $temp_data['verification_code'] = $send_code;
        $car = Car::where('id', $temp_booking->value->car_id)->first();
        if (!$car) {
            Log::error('Car not found for id: ' . $temp_booking->value->car_id);
            return back()->with(['error' => [__('Car Not Found!')]]);
        }
        $data = [
            'verification_code' => $send_code,
            'token' => $token,
        ];

        try {

            $temp_booking->update([
                'value' => $temp_data,
            ]);


            Log::info('Temporary booking updated with verification code.');
            // dd( $temp_booking);
            Notification::route("mail", $temp_booking->value->email)->notify(new bookingConfirmation((object) $data));
                                // dd($temp_booking);

            Log::info('Notification sent to: ' . $temp_booking->value->email);
        } catch (Exception $e) {
            Log::error('Error during booking confirmation: ' . $e->getMessage());
            return back()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

        return redirect()->route('frontend.car.booking.mail', ['token' => $token])->with(['Success' => [__('Please check your email to get the OTP')]]);
    }

    public function multiconfirm($token)
    {
        
        Log::info('Confirm booking called with token: ' . $token);

        $temp_booking = TemporaryData::where('token', $token)->first();
        if (!$temp_booking) {
            Log::error('Booking not found for token: ' . $token);
            return back()->with(['error' => [__('Booking Not Found!')]]);
        }

        Log::info('Temporary booking found: ', $temp_booking->toArray());

        $temp_data = json_decode(json_encode($temp_booking->value), true);
        $send_code = generate_random_code();
        $temp_data['verification_code'] = $send_code;
        $car = Car::where('id', $temp_booking->value->car_id)->first();

        if (!$car) {
            Log::error('Car not found for id: ' . $temp_booking->value->car_id);
            return back()->with(['error' => [__('Car Not Found!')]]);
        }
        $data = [
            'verification_code' => $send_code,
            'token' => $token,
        ];

        try {

            $temp_booking->update([
                'value' => $temp_data,
            ]);

            Log::info('Temporary booking updated with verification code.');
            Notification::route("mail", $temp_booking->value->email)->notify(new bookingConfirmation((object) $data));
            Log::info('Notification sent to: ' . $temp_booking->value->email);
        } catch (Exception $e) {
            Log::error('Error during booking confirmation: ' . $e->getMessage());
            return back()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

        return redirect()->route('frontend.car.booking.mail', ['token' => $token])->with(['Success' => [__('Please check your email to get the OTP')]]);
    }

    public function showMailForm($token)
    {
        $page_title = setPageTitle(__("Mail Verification"));
        return view('admin.sections.cars.verify-booking', compact("page_title", "token"));
    }

    public function mailVerify(Request $request, $token)
    {
        $request->merge(['token' => $token]);
        $request->validate([
            'token'     => "required|string|exists:temporary_datas,token",
            'code'      => "required",
        ]);
        $temp_data = TemporaryData::where('token', $token)->first();
        $temporary_data = json_decode(json_encode($temp_data->value), true);
        if (!isset($temporary_data['verification_code'])) {
            return redirect()->back()->with(['error' => [__('Verification code not found in temporary data')]]);
        }
        $code = implode($request->code);
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = TemporaryData::where("token", $request->token)->where('value->verification_code', $code)->first();

        if (!$auth_column) {
            return redirect()->back()->with(['error' => [__('Invalid otp code')]]);
        }
        if ($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            return redirect()->route('frontend.car.booking.preview', $token)->with(['error' => [__('Session expired. Please try again')]]);
        }
        try {
            $booking_data = CarBooking::create([
                'car_id'    => $temp_data->value->car_id,
                'user_id'   => auth()->user()->id ?? null,
                'slug'      => $temp_data->value->slug,
                'phone'     => $temp_data->value->phone,
                'email'     => $temp_data->value->email,
                'location'  => $temp_data->value->location,
                'destination' => $temp_data->value->destination,
                'finalprice' => $temp_data->value->estimated_price,
                'numcar' => $temp_data->value->number_of_cars,
                'booking_type'          => $temp_data->value->booking_type,
                'trip_id'     => generate_unique_code(),
                'pickup_time'   => $temp_data->value->pickup_time,
                'round_pickup_time' => $temp_data->value->round_pickup_time,
                'pickup_date'   => $temp_data->value->pickup_date,
                'round_pickup_date' => $temp_data->value->round_pickup_date,
                'message'           => $temp_data->value->message ?? "",
                'status'            => 1,
                'Booking_no'        =>$temp_data->value->booking_no
            ]);

            $confirm_booking = CarBooking::with('cars')->where('slug', $booking_data->slug)->first();
            $auth_column->delete();
            Notification::route("mail", $confirm_booking->email)->notify(new carBookingNotification($confirm_booking));
            if (auth()->check()) {
                $notification_content = [
                    'title'   => __("Booking"),
                    'message' => __("Your Booking (Car Model: ") . $confirm_booking->cars->car_model .
                        __(", Car Number: ") . $confirm_booking->cars->car_number .
                        __(", Pick-up Date: ") . ($confirm_booking->pickup_date ? Carbon::parse($confirm_booking->pickup_date)->format('d-m-Y') : '') .
                        __(", Pick-up Time: ") . ($confirm_booking->pickup_time ? Carbon::parse($confirm_booking->pickup_time)->format('h:i A') : '') . __(") Successfully booked."),
                ];
                UserNotification::create([
                    'user_id'   => auth()->user()->id,
                    'message'   => $notification_content,
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('frontend.car.booking.preview', $token)->with(['error' => [__('Something went wrong! Please try again')]]);
        }
        return redirect()->intended(route("frontend.find.car"))->with(['success' => [__('Congratulations! Car Booking Confirmed Successfully.')]]);
    }

    public function multimailVerify(Request $request, $token)
    {
        $request->merge(['token' => $token]);
        $request->validate([
            'token'     => "required|string|exists:temporary_datas,token",
            'code'      => "required",
        ]);
        $temp_data = TemporaryData::where('token', $token)->first();
        $temporary_data = json_decode(json_encode($temp_data->value), true);
        if (!isset($temporary_data['verification_code'])) {
            return redirect()->back()->with(['error' => [__('Verification code not found in temporary data')]]);
        }
        $code = implode($request->code);
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = TemporaryData::where("token", $request->token)->where('value->verification_code', $code)->first();

        if (!$auth_column) {
            return redirect()->back()->with(['error' => [__('Invalid otp code')]]);
        }
        if ($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            return redirect()->route('frontend.car.booking.preview', $token)->with(['error' => [__('Session expired. Please try again')]]);
        }
        try {
            $booking_data = CarBooking::create([
                'car_id'    => $temp_data->value->car_id,
                'user_id'   => auth()->user()->id ?? null,
                'slug'      => $temp_data->value->slug,
                'phone'     => $temp_data->value->phone,
                'email'     => $temp_data->value->email,
                'location'  => $temp_data->value->location,
                'destination' => $temp_data->value->destination,
                'finalprice' => $temp_data->value->estimated_price,
                'numcar' => $temp_data->value->number_of_cars,
                'booking_type'          => $temp_data->value->booking_type,
                'trip_id'     => generate_unique_code(),
                'pickup_time'   => $temp_data->value->pickup_time,
                'round_pickup_time' => $temp_data->value->round_pickup_time,
                'pickup_date'   => $temp_data->value->pickup_date,
                'round_pickup_date' => $temp_data->value->round_pickup_date,
                'message'           => $temp_data->value->message ?? "",
                'status'            => 1,
            ]);

            $confirm_booking = CarBooking::with('cars')->where('slug', $booking_data->slug)->first();
            $auth_column->delete();
            Notification::route("mail", $confirm_booking->email)->notify(new carBookingNotification($confirm_booking));
            if (auth()->check()) {
                $notification_content = [
                    'title'   => __("Booking"),
                    'message' => __("Your Booking (Car Model: ") . $confirm_booking->cars->car_model .
                        __(", Car Number: ") . $confirm_booking->cars->car_number .
                        __(", Pick-up Date: ") . ($confirm_booking->pickup_date ? Carbon::parse($confirm_booking->pickup_date)->format('d-m-Y') : '') .
                        __(", Pick-up Time: ") . ($confirm_booking->pickup_time ? Carbon::parse($confirm_booking->pickup_time)->format('h:i A') : '') . __(") Successfully booked."),
                ];
                UserNotification::create([
                    'user_id'   => auth()->user()->id,
                    'message'   => $notification_content,
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('frontend.car.booking.preview', $token)->with(['error' => [__('Something went wrong! Please try again')]]);
        }
        return redirect()->intended(route("frontend.find.car"))->with(['success' => [__('Congratulations! Car Booking Confirmed Successfully.')]]);
    }

    public function mailResendToken($token)
    {
        // استرجع السجل بناءً على التوكن
        $temporary_data = TemporaryData::where("token", $token)->first();

        // تحقق مما إذا تم العثور على السجل
        if (!$temporary_data) {
            return redirect()->route('frontend.car.booking.mail', $token)->withErrors([
                'error' => __("لم يتم العثور على سجل للتوكن المقدم."),
            ]);
        }

        // قم بتحويل القيمة من JSON إلى مصفوفة
        $form_data = json_decode(json_encode($temporary_data->value), true);

        // قم بتوليد رمز تحقق جديد
        $resend_code = generate_random_code();
        $form_data['verification_code'] = $resend_code;

        try {
            // قم بتحديث السجل مع رمز التحقق الجديد
            $temporary_data->update([
                'value' => json_encode($form_data), // تأكد من تخزين القيمة بتنسيق JSON
            ]);

            // إعداد البيانات للإشعار
            $data = [
                'verification_code' => $resend_code,
                'token' => $token,
            ];

            // إرسال الإشعار
            Notification::route("mail", $form_data['email'])->notify(new bookingConfirmation((object) $data));
        } catch (Exception $e) {
            // التعامل مع الاستثناء وتقديم رسالة خطأ
            return redirect()->route('frontend.car.booking.mail', $token)->withErrors([
                'error' => __("حدث خطأ! يرجى المحاولة مرة أخرى."),
            ]);
        }

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('frontend.car.booking.mail', $token)->with(['success' => [__('تم إرسال البريد الإلكتروني بنجاح!')]]);
    }
}

