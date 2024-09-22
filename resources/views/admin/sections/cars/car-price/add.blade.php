@extends('admin.layouts.master')

@push('css')
<style>
    .form-area {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        border-radius: 4px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
@endpush

@section('breadcrumb')
@include('admin.components.breadcrumb', ['breadcrumbs' => [
[
'name' => __("Dashboard"),
'url' => setRoute("admin.dashboard"),
]
], 'active' => __("Add Car Price")])
@endsection

@section('content')
<div class="form-area">
    <h2 class="mb-4">إضافة سعر سيارة</h2>
    <form action="{{ route('admin.price.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="car_type_id">نوع السيارة</label>
            <select name="car_type_id" id="car_type_id" class="form-control">
                @foreach($carTypes as $carType)
                    <option value="{{ $carType->id }}">
                        {{ $carType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="from_id">الاستقبال</label>
            <select name="from_id" id="from_id" class="form-control">
                @foreach($carAreas as $carArea)
                    <option value="{{ $carArea->id }}">
                        {{ $carArea->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="destination_id">الوجهة</label>
            <select name="destination_id" id="destination_id" class="form-control">
                @foreach($carAreas as $carArea)
                    <option value="{{ $carArea->id }}">
                        {{ $carArea->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">السعر</label>
            <input type="text" name="price" id="price" class="form-control" value="">
        </div>

        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection
