@extends('admin.layout.index')
@section('content')
    <div class="container px-6 mx-auto grid">
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 "
        >
            Добрый день, {{ auth()->user()->name }}
        </h2>
        <!-- CTA -->
        <!-- Cards -->
        <div class=" rounded-lg shadow-xs">
            <div class="w-full ">
                <livewire:manager-table></livewire:manager-table>

            </div>
        </div>

        <!-- Charts -->
    </div>
@endsection
