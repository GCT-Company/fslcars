@extends('admin.layouts.master')

@push('css')
<style>
    .fileholder {
        min-height: 374px !important;
    }

    .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,
    .fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view {
        height: 330px !important;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-search {
        display: flex;
        align-items: center;
        order: 2;
    }

    .table-btn-area {
        display: flex;
        align-items: center;
        order: 1;
    }

    .table-search input[type="text"] {
        flex: 1;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .table-search button {
        padding: 6px 12px;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .table-search button:hover {
        background-color: #0056b3;
    }

    .pagination-wrapper {
        margin-top: 20px;
        text-align: center;
    }

    .table-btn-area form, .table-btn-area a, .table-btn-area button {
        margin-right: 10px;
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
                <form action="{{ route('admin.price.index') }}" method="GET" style="display: flex;">
                    <input type="text" name="search" placeholder="ابحث عن نوع السيارة أو الوجهة" value="{{ request()->query('search') }}">
                    <button type="submit">بحث</button>
                </form>
            </div>
            <div class="table-btn-area">
                <form action="{{ route('admin.price.generate') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-primary">توليد</button>
                </form>
                @include('admin.components.link.add-default', [
                    'text' => __("Add Type"),
                    'href' => route('admin.price.create'),
                    'class' => "modal-btn",
                    'permission' => "admin.car..",
                ])
                <form id="deleteSelectedForm" action="{{ route('admin.price.deleteSelected') }}" method="POST" style="margin-left: 10px;">
                    @csrf
                    <button type="button" id="delete-selected-btn" class="btn btn-danger">حذف المحدد</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <form id="deleteSelectedItemsForm">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>نوع السيارة</th>
                            <th>الاستقبال</th>
                            <th>الوجهة</th>
                            <th>السعر</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carPrices as $item)
                        <tr data-item="{{ $item }}">
                            <td><input type="checkbox" name="selected[]" value="{{ $item->id }}"></td>
                            <td>{{ $item['car_type_name'] }}</td>
                            <td>{{ $item['from_name'] }}</td>
                            <td>{{ $item['destination_name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>
                                @include('admin.components.link.edit-default',[
                                    'href'          => setRoute('admin.price.edit',$item->id),
                                    'class'         => "edit-modal-button",
                                    'permission'    => "admin.car.edit",
                                ])
                                <button type="button" class="btn btn--base btn--danger delete-modal-button"><i class="las la-trash-alt"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">لا توجد بيانات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $carPrices->links() }}
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    // Select/Deselect all checkboxes
    $('#select-all').click(function() {
        $('input[name="selected[]"]').prop('checked', this.checked);
    });

    // Handle individual checkbox click
    $('input[name="selected[]"]').click(function() {
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        }
    });

    // Handle delete button click
    $(".delete-modal-button").click(function(){
        var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
        var actionRoute = "{{ setRoute('admin.car.price.delete') }}";
        var target = oldData.id;
        var message = `هل أنت متأكد من <strong>حذف</strong> هذا النوع؟`;
        openDeleteModal(actionRoute, target, message);
    });

    // Handle delete selected items button click
    $('#delete-selected-btn').click(function() {
        // Get selected checkboxes
        var selectedItems = $('input[name="selected[]"]:checked');

        // Check if any item is selected
        if (selectedItems.length > 0) {
            var message =' هل انت متاكد من حذف هذه البيانات';
            if (confirm(message)) {
                // Append selected checkboxes to the delete form
                selectedItems.each(function() {
                    var input = $('<input>').attr('type', 'hidden').attr('name', 'selected[]').val($(this).val());
                    $('#deleteSelectedForm').append(input);
                });

                // Submit the delete form
                $('#deleteSelectedForm').submit();
            }
        } else {
            alert('يرجى تحديد عنصر واحد على الأقل لحذفه.');
        }
    });
</script>
@endpush
