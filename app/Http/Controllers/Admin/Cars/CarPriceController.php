<?php

namespace App\Http\Controllers\Admin\Cars;

use App\Http\Controllers\Controller; // استيراد Controller
use Illuminate\Http\Request;
use Exception;

use App\Models\Admin\Cars\CarPrice;
use App\Models\Admin\Cars\CarType;
use App\Models\Admin\Cars\CarArea;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
// use App\Models\CarPrice as ModelsCarPrice;



class CarPriceController extends Controller
{
    protected $CarPrice;

    protected $CarType;
    protected $CarArea;
    public function __construct()
    {
        $this->CarPrice = CarPrice::class;;
        $this->CarType = CarType::class;
        $this->CarArea = CarArea::class;
    }


    public function index(Request $request)
    {
        try {
            // بناء الاستعلام الأساسي
            $query = CarPrice::query()
                ->select(
                    'car_prices.*',
                    'car_types.name as car_type_name',
                    'car_types.id as car_type_id',
                    'car_areas_from.name as from_name',
                    'car_areas_from.id as from_id',
                    'car_areas_to.name as destination_name',
                    'car_areas_to.id as destination_id'
                )
                ->leftJoin('car_types', 'car_prices.car_id', '=', 'car_types.id')
                ->leftJoin('car_areas as car_areas_from', 'car_prices.from', '=', 'car_areas_from.id')
                ->leftJoin('car_areas as car_areas_to', 'car_prices.destination', '=', 'car_areas_to.id')
                ->whereNotNull('car_prices.car_id') // تأكد من أن السيارة ليست فارغة
                ->whereNotNull('car_prices.from') // تأكد من أن نقطة الانطلاق ليست فارغة
                ->whereNotNull('car_prices.destination') // تأكد من أن الوجهة ليست فارغة
                ->orderBy('car_prices.id', 'desc');
    
            // تطبيق فلتر البحث إذا كان موجودًا
            if ($search = $request->query('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('car_types.name', 'LIKE', "%{$search}%")
                        ->orWhere('car_areas_from.name', 'LIKE', "%{$search}%")
                        ->orWhere('car_areas_to.name', 'LIKE', "%{$search}%");
                });
            }
            //  dd($carPrices);
            // جلب البيانات مع التصفح
            $carPrices = $query->paginate(10);
    
            return view('admin.sections.cars.car-price.index', compact('carPrices'));
        } catch (\Exception $e) {
            // معالجة الأخطاء
            dd($e->getMessage());
        }
    }
    



    public function create()
    {
        $carTypes = CarType::all();
        $carAreas = CarArea::all();
        return view('admin.sections.cars.car-price.add', compact('carTypes', 'carAreas'));

        // return view('admin.sections.cars.car-price.add', compact('carTypes', 'carAreas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'from_id' => 'required|exists:car_areas,id',
            'destination_id' => 'required|exists:car_areas,id',
            'price' => 'required|numeric',
        ]);
    
        // التحقق من وجود السجل مسبقًا
        $existingCarPrice = CarPrice::where('car_id', $request->car_type_id)
            ->where('from', $request->from_id)
            ->where('destination', $request->destination_id)
            ->first();
    
        if ($existingCarPrice) {
            // في حالة وجود السجل مسبقًا، يمكنك إعادة توجيه المستخدم مع رسالة
            return redirect()->back()->withErrors(['error' => 'هذا السجل موجود بالفعل.']);
        }
    
        // إذا لم يكن السجل موجودًا، قم بإنشائه
        $carPrice = new CarPrice();
        $carPrice->car_id = $request->car_type_id;
        $carPrice->from = $request->from_id;
        $carPrice->destination = $request->destination_id;
        $carPrice->price = $request->price;
        $carPrice->save();
    
        return redirect()->route('admin.price.index')->with('success', 'تم إضافة السعر بنجاح.');    }





    public function generate(Request $request)
    {
        $areas = CarArea::all();
        $carTypes = CarType::all();

        $carPrices = [];
        foreach ($carTypes as $carType) {
            foreach ($areas as $from) {
                foreach ($areas as $to) {
                    if ($from->id != $to->id) {
                        $carPrices[] = [
                            'from_id' => $from->id,
                            'from_name' => $from->name,
                            'destination_id' => $to->id,
                            'destination_name' => $to->name,
                            'car_type_id' => $carType->id,
                            'car_type_name' => $carType->name,
                            'price' => '',
                        ];

                        // حفظ البيانات في قاعدة البيانات
                        CarPrice::create([
                            'car_id' => $carType->id,
                            'from' => $from->id,
                            'destination' => $to->id,
                            'price' => 0, // أو أي قيمة افتراضية للسعر
                        ]);
                    }
                }
            }
        }
        // تمرير البيانات إلى الـView
        return view('admin.sections.cars.car-price.genrate', compact('carPrices'));
    }




    // PriceController.php

  public function deleteSelected(Request $request)
    {
        $ids = $request->input('selected', []);
        if (!empty($ids)) {
            CarPrice::whereIn('id', $ids)->delete();
        }
        return redirect()->route('admin.price.index')->with('success', 'تم حذف العناصر المحددة بنجاح.');
    }

    public function updateAll(Request $request)
    {
        $prices = $request->input('prices', []);
        $carTypeIds = $request->input('car_type_ids', []);
        $fromIds = $request->input('from_ids', []);
        $destinationIds = $request->input('destination_ids', []);

        foreach ($prices as $key => $price) {
            list($car_type_id, $from_id, $destination_id) = explode('_', $key);

            $carPrice = CarPrice::where('car_id', $car_type_id)
                ->where('from_id', $from_id)
                ->where('destination', $destination_id)
                ->first();

            if ($carPrice) {
                $carPrice->price = $price;
                $carPrice->save();
            } else {
                // Create new record if it doesn't exist
                CarPrice::create([
                    'car_id' => $car_type_id,
                    'from_id' => $from_id,
                    'destination_id' => $destination_id,
                    'price' => $price,
                ]);
            }
        }

        return redirect()->route('admin.price.index')->with('success', 'تم حفظ جميع التعديلات.');
    }







    public function edit($id)
    {
        // البحث عن السجل باستخدام ID
        $carPrice = CarPrice::findOrFail($id);
    
        // جلب أنواع السيارات والمناطق
        $carTypes = CarType::all();
        $carAreas = CarArea::all();
        // DD($carPrice);
    
        return view('admin.sections.cars.car-price.edit', compact('carPrice', 'carTypes', 'carAreas'));
    }
    

    public function update(Request $request, $id)
    {
        $carPrice = CarPrice::findOrFail($id);

        $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'from_id' => 'required|exists:car_areas,id',
            'destination_id' => 'required|exists:car_areas,id',
            'price' => 'required|numeric',
        ]);

        $carPrice->update([
            'car_id' => $request->car_type_id,
            'from' => $request->from_id,
            'destination' => $request->destination_id,
            'price' => $request->price,
        ]);
        // return view('admin.sections.cars.car-price.index', compact('carPrices'));

        return redirect()->route('admin.price.index')->with('success', 'تم تحديث السعر بنجاح');
    }




    public function statusUpdate(Request $request)
    {
        // منطق لتحديث الحالة
    }

    public function delete(Request $request){
        $request->validate([
            'target' => 'required|numeric',
        ]);

        // ابحث عن العنصر باستخدام الـID
        $carPrice = CarPrice::find($request->target);

        if (!$carPrice) {
            return back()->with(['error' => __('Item not found.')]);
        }

        try {
            // حاول حذف العنصر
            $carPrice->delete();
        } catch (Exception $e) {
            // في حالة حدوث خطأ
            return back()->with(['error' => __('Something went wrong! Please try again.')]);
        }

        // في حالة النجاح
        return back()->with(['success' => __('Car Price Deleted Successfully!')]);
    }
    public function getAreaTypes(Request $request)
    {
        // منطق للحصول على أنواع المناطق
    }
}
