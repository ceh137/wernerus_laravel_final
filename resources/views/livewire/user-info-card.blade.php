<div class="p-7">
    <div class="font-semibold font-gray-700 text-2xl">{{ $confirmationTitle }}</div>

    <div class="py-2">
        <div class=" my-4 font-normal text-gray-600">{{ $confirmationDescription }}</div>
        <div>
            <h2 class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-gray-900 md:text-4xl dark:text-white">{{ $user->name }}</h2>
            <div class="grid grid-cols-3 gap-8">
                <div class="">
                    @if($user->what == 'company')
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">ИНН</dt>
                            <dd class="text-lg font-semibold">{{ $user->INN ?: "--"}}</dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Адрес</dt>
                            <dd class="text-lg font-semibold">{{ $user->address ?: "--"}}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Номер Телефона</dt>
                            <dd class="text-lg font-semibold">{{ $user->telnum ?: "--" }}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Адрес Эл. Почты</dt>
                            <dd class="text-lg font-semibold">{{ $user->email ?: "--" }}</dd>
                        </div>
                    </dl>
                    @else
                        <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Номер Телефона</dt>
                                <dd class="text-lg font-semibold">{{ $user->telnum ?: "--" }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Адрес Эл. Почты</dt>
                                <dd class="text-lg font-semibold">{{ $user->email ?: "--" }}</dd>
                            </div>
                        </dl>
                    @endif
                </div>
                <div class="">


                    <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($contacts as $contact)
                            @if($loop->index >= 4)
                                @break
                            @endif
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $contact->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{ $contact->email }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{ $contact->telnum }}
                                    </p>
                                </div>
{{--                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">--}}
{{--                                    $320--}}
{{--                                </div>--}}
                            </div>
                        </li>

                        @endforeach

                    </ul>

                </div>

                <div class="">


                    <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($contacts as $contact)
                            @if($loop->index < 4)
                                @continue
                            @endif
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $contact->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $contact->email }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $contact->telnum }}
                                        </p>
                                    </div>
                                    {{--                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">--}}
                                    {{--                                    $320--}}
                                    {{--                                </div>--}}
                                </div>
                            </li>
                        @endforeach

                    </ul>

                </div>

            </div>
            @if(count($user->orders()) >  0)
            <div class="font-semibold font-gray-700 text-2xl">Заказы</div>
            @endif
            <ul class=" divide-y divide-gray-200 dark:divide-gray-700 mx-8 mt-3">
                @foreach($user->orders() as $order)

                    <li class="py-3 sm:py-4" onclick="Livewire.emit('openModal', 'order-info', {{json_encode(['id' => $order->id])}})">
                        <div class="flex items-center space-x-4">
                            <div class=" text-xl font-bold flex-shrink-0">
                                {{$order->order_num}}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                                    {{$order->route->city_from->name}} -> {{$order->route->city_to->name}}
                                </p>
                                <p class="text-md font-bold text-gray-900 truncate dark:text-gray-400">
                                    &#129482; {{$order->volume}} [М<sup>3</sup>] &nbsp;&nbsp;&nbsp;&nbsp; &#9878;&#65039; {{$order->weight}} [кг]
                                </p>

                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{$order->order_prices->total}}
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>


        </div>
        <div class="space-x-2 flex justify-end mt-3">
            <button class="bg-gray-200 cursor-pointer text-black border border-gray-400 px-3 py-2 m-2 rounded text-lg"
                    wire:click="cancel">
                Закрыть
            </button>
        </div>
    </div>

</div>

