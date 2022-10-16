@extends('admin.layout.index')
@section('content')
    <div class="container px-6" style="width: 100%; max-width: 90vw">
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 "
        >
            Заявки
        </h2>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full ">
                <livewire:application-table></livewire:application-table>
{{--                <livewire:bulk-application-to-order-modal></livewire:bulk-application-to-order-modal>--}}
            </div>
        </div>

        <!-- Charts -->
    </div>
@endsection


