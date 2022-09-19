<div class=" rounded-lg shadow-xs">
    <h4
        class="my-6 text-xl font-semibold text-gray-700"
    >
        Поступления/Задолженность
    </h4>
    <div class="">
        <div  class="flex items-center">
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <input name="start" wire:change="applyDateFilter" wire:model="from"  type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
            </div>
            <span class="mx-4 text-gray-500">до</span>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <input name="end" wire:change="applyDateFilter"  wire:model="till"  type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
            </div>
        </div>
        <table class="">
            <thead>
            <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
            >
                <th class="px-4 py-3">Плательщик</th>
                <th class="px-4 py-3 text-right">Пдз (весь период)</th>
                <th class="px-4 py-3 text-right">Задолженность (весь период)</th>
                <th class="px-4 py-3">М<sup>3</sup> (Обьем)</th>
                <th class="px-4 py-3">М<sup>3</sup> (Обьемный вес)</th>
                <th class="px-4 py-3">Заказы, шт</th>
                <th class="px-4 py-3">Выручка</th>

            </tr>
            </thead>
            <tbody
                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
            @foreach($customers as $payer)
                <tr class="text-gray-700 dark:text-gray-400 @if($payer['is_red']) bg-red-200 @endif">
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div
                                class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                            >
                                <img
                                    class="object-cover w-full h-full rounded-full"
                                    src="{{ asset('images/user.png') }}" alt=""
                                    loading="lazy"
                                />
                                <div
                                    class="absolute inset-0 rounded-full shadow-inner"
                                    aria-hidden="true"
                                ></div>
                            </div>
                            <div onclick="Livewire.emit('openModal', 'user-info-card', {{json_encode(["who_is" => is_array($payer) ? $payer['what'] :  $payer->what,"id" => is_array($payer) ? $payer['id'] : $payer->id]) }})">
                                <p class="font-semibold text-base">{{$payer['name']}}</p>

                            </div>
                        </div>
                    </td>
                    <td class="px-4 pr-8 py-3 text-base font-bold text-right">
                        {{$payer['sum'] ? : "--"}}
                    </td>
                    <td class="px-4 pr-8 py-3 text-base font-bold text-right">
                        {{$payer['debt'] ? : "--"}}
                    </td>
                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-2 py-1 text-base font-semibold "
                                        >
                                          {{$payer['meters'] ?  : "--"}}
                                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-2 py-1 text-base font-semibold "
                                        >
                                          {{$payer['weight_volume'] ?  : "--"}}
                                        </span>
                    </td>
                    <td class="px-4 py-3 text-base text-sm">
                        {{$payer['orders_count'] ? : "--"}}
                    </td>
                    <td class="px-4 py-3 text-base text-sm">
                        {{$payer['revenue'] ? : "--"}}
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
