@extends('admin.layouts.master')

@push('css')
<style>
    .form-area {
        max-width: 600px;
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
        display: block;
        margin-bottom: 5px;
    }

    .form-group select,
    .form-group input[type="text"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-success {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>
@endpush

@section('breadcrumb')
@include('admin.components.breadcrumb', ['breadcrumbs' => [
    [
        'name' => __("Dashboard"),
        'url' => setRoute("admin.dashboard"),
    ]
], 'active' => __("Edit Car Price")])
@endsection

@section('content')
<div class="form-area">
    <form action="{{ route('admin.price.update', $carPrice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="car_type_id">نوع السيارة</label>
            <select name="car_type_id" id="car_type_id" class="form-control">
                @foreach($carTypes as $carType)
                    <option value="{{ $carType->id }}" {{ $carPrice->car_id == $carType->id ? 'selected' : '' }}>
                        {{ $carType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="from_id">الاستقبال</label>
            <select name="from_id" id="from_id" class="form-control">
                @foreach($carAreas as $carArea)
                    <option value="{{ $carArea->id }}" {{ $carPrice->from == $carArea->id ? 'selected' : '' }}>
                        {{ $carArea->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="destination_id">الوجهة</label>
            <select name="destination_id" id="destination_id" class="form-control">
                @foreach($carAreas as $carArea)
                    <option value="{{ $carArea->id }}" {{ $carPrice->destination == $carArea->id ? 'selected' : '' }}>
                        {{ $carArea->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">السعر</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ $carPrice->price }}">
        </div>

        <button type="submit" class="btn btn-success">تحديث</button>
    </form>
</div>
@endsection
