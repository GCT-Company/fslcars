@extends('admin.layouts.master')

@push('css')
<style>
    .editable-price {
        cursor: pointer;
        color: #007bff;
        text-decoration: underline;
    }

    .price-input {
        display: none;
    }

    .price-value {
        display: inline;
    }
</style>
@endpush

@section('breadcrumb')
@include('admin.components.breadcrumb', ['breadcrumbs' => [
[
'name' => __("Dashboard"),
'url' => setRoute("admin.dashboard"),
]
], 'active' => __("Car Types")])
@endsection

@section('content')
<div class="table-area">
    <div class="table-wrapper">
        <div class="table-header">
            <div class="table-search">
                <form action="{{ route('admin.price.index') }}" method="post" style="display: flex;">
                    @csrf
                    <input type="text" name="search" placeholder="ابحث عن نوع السيارة أو الوجهة" value="{{ request()->query('search') }}">
                    <button type="submit">بحث</button>
                </form>
            </div>
            <div class="table-btn-area">
                <form action="{{ route('admin.price.generate') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
                @include('admin.components.link.add-default', [
                'text' => __("Add Type"),
                'href' => route('admin.price.index'),
                'class' => "modal-btn",
                'permission' => "admin.car.types.store",
                ])
                <!-- Add a button to submit the form for saving prices -->
                <form id="save-prices-form" action="{{ route('admin.price.updateAll') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Save All</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <form id="price-form" action="{{ route('admin.price.updateAll') }}" method="POST">
                @csrf
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>نوع السيارة</th>
                            <th>الاستقبال</th>
                            <th>الوجهة</th>
                            <th>السعر</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carPrices as $item)
                        <tr>
                            <td>{{ $item['car_type_name'] }}</td>
                            <td>{{ $item['from_name'] }}</td>
                            <td>{{ $item['destination_name'] }}</td>
                            <td>
                                <form action="{{ route('admin.price.create') }}" method="POST">
                                    @csrf
                                    <!-- <input type="hidden" name="car_type_id" value="{{ $item['car_type_id'] }}">
                                    <input type="hidden" name="from_id" value="{{ $item['from_id'] }}">
                                    <input type="hidden" name="destination_id" value="{{ $item['destination_id'] }}"> -->
                                    <input type="text" name="price" value="{{ $item['price'] ?: '0' }}" />
                                    <!-- <button type="submit" class="btn btn--base btn--primary add-modal-button">Add</button> -->
                                </form>
                            </td>
                            <td>
                                <button class="btn btn--base btn--danger delete-modal-button"><i class="las la-trash-alt"></i></button>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5">لا توجد بيانات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection