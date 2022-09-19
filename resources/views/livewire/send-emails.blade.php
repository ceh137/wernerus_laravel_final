<div class="p-7">
    <div class="font-semibold font-gray-700 text-2xl">{{ $confirmationTitle }}</div>

    <div class="py-2">
        @if($order->id)
            ID Заявки: {{ $order->id }}
            TrackNum: {{$order->order_num}}
        @endif

        <div class=" my-4 font-normal text-gray-600">
            @if($status == 'accepted')
                <div class="flex flex-col mx-5">
                <div class="flex flex-col ">
                    @if(!is_null($order->files->check))
                        @foreach(json_decode($order->files->check) as $key => $invoice)
                            @php
                                if ($key == 'sender') {
                                    $name = $order->sender->name;
                                } elseif ($key == 'receiver') {
                                    $name = $order->receiver->name;
                                } elseif ($key == 'third_party') {
                                    $name = $order->tp->name;
                                }
                            @endphp
                        <div class="flex flex-row my-3">
                            <div>
                                <a class="block  py-2 px-4 w-full text-white bg-blue-700  cursor-pointer rounded-md" href="{{ route('admin.files', ['order_id'=>$order->id, 'file'  =>  explode('/', $invoice)[1]]) }}" target="_blank">Счет на оплату {{$name}}</a>
                            </div>
                            <div class="text-center mt-2 mx-8">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z"/></svg>
                            </div>
                            <div>
                                <input wire:model="{{$key.'InvoiceEmail'}}" style="width: 300px;" type="email" id="first_name" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex flex-row my-3 w-full">
                        <div>
                            <a class="block  py-2 px-4 w-full text-white bg-blue-700   cursor-pointer rounded-md" href="{{ route('admin.files', ['order_id'=>$order->id, 'file'  =>  explode('/', $order->files->PE)[1]]) }}"  target="_blank">Поручение экспедитору</a>
                        </div>
                        <div class="text-center mt-2 mx-8">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z"/></svg>
                        </div>
                        <div class="">
                            <input wire:model="peEmail" style="width: 300px;" type="email" id="first_name" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
                        </div>
                    </div>

                </div>
            </div >
            @elseif($status == 'delivered')
                <div class="flex flex-col mx-5">

                    <div class="flex flex-col ">
                        @if(!is_null($order->files->UPD))
                            @foreach(json_decode($order->files->UPD) as $key => $UPD)
                                @php
                                    if ($key == 'sender') {
                                        $name = $order->sender->name;
                                    } elseif ($key == 'receiver') {
                                        $name = $order->receiver->name;
                                    } elseif ($key == 'third_party') {
                                        $name = $order->tp->name;
                                    }
                                @endphp
                                <div class="flex flex-row my-3">
                                    <div>
                                        <a class="block  py-2 px-4 w-full text-white bg-blue-700  cursor-pointer rounded-md" href="{{ route('admin.files', ['order_id'=>$order->id, 'file'  =>  explode('/', $UPD)[1]]) }}" target="_blank">УПД {{$name}}</a>
                                    </div>
                                    <div class="text-center mt-2 mx-8">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z"/></svg>
                                    </div>
                                    <div>
                                        <input wire:model="{{$key.'UPDEmail'}}" style="width: 300px;" type="email" id="first_name" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div >
            @endif
            <div class="space-x-2 flex justify-end mt-3">

                <button class="bg-gray-200 cursor-pointer text-black border border-gray-400 px-3 py-2 m-2 rounded text-lg"
                        wire:click="cancel">
                    Отменить
                </button>
                <button class="bg-green-500 cursor-pointer text-white px-3 py-2 m-2 rounded text-lg"
                        wire:click="confirm">
                    Отправить
                </button>
            </div>
        </div>
    </div>

