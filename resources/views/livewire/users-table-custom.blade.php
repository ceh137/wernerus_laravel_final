<div class="w-full overflow-x-auto">
    <table class="w-full whitespace-no-wrap">
        <thead>
        <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
        >
            <th class="px-4 py-3">
                <div class="mx-1 mb-3">
                    <input  type="text" id="name" wire:change="applyFilter" wire:model="name_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Поиск по названию/имени" required>
                </div>
                Название/ФИО
            </th>
            <th class="px-4 py-3">
                <div class="mx-1 mb-3">
                    <input  type="text" id="INN" wire:change="applyFilter" wire:model="INN_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Поиск по ИНН" required>
                </div>
                ИНН</th>
            <th class="px-4 py-3">
                <div class="mx-1 mb-3">
                    <input  type="text" id="tel" wire:change="applyFilter" wire:model="tel_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Поиск по телефону" required>
                </div>
                Телефон</th>
            <th class="px-4 py-3">С/Без НДС</th>
            <th class="px-4 py-3">
                <div class="mx-1 mb-3">
                <label for="countries" class="block mx-1 mb-2 text-sm  text-gray-900 w-full"></label>
                <select id="countries" wire:change="applyFilter" wire:model="manager_filter" name="manager_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="null">Не выбран</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach

                </select>
                </div>
                Менеджер</th>
            <th class="px-4 py-3">Действия</th>
        </tr>
        </thead>
        <tbody
            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
        >
        @foreach($customers as $customer)

            <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                        <!-- Avatar with inset shadow -->
                        <div onclick="Livewire.emit('openModal', 'user-info-card', {{json_encode(["who_is" => is_array($customer) ? $customer['what'] :  $customer->what,"id" => is_array($customer) ? $customer['id'] : $customer->id]) }})"
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                        >
                            <img class="object-cover w-full h-full rounded-full" src="{{ asset('images/user.png') }}" alt="" loading="lazy"/>
                            <div
                                class="absolute inset-0 rounded-full shadow-inner"
                                aria-hidden="true"
                            ></div>
                        </div>
                        <div>
                            <a href="#" onclick="Livewire.emit('openModal', 'user-info-card', {{json_encode(["who_is" => is_array($customer) ? $customer['what'] :  $customer->what,"id" => is_array($customer) ? $customer['id'] : $customer->id]) }})">
                                <p class="font-semibold">{{is_array($customer) ? $customer['name'] : $customer->name  }}</p>
                            </a>


                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm">
                    {{is_array($customer) ? $customer['INN'] : $customer->INN}}
                </td>
                <td class="px-4 py-3 text-xs">
                    <span class="px-2 py-1 font-semibold">
                        {{is_array($customer) ? $customer['telnum'] : $customer->telnum}}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm">
                    <div>
                        <p class="font-semibold">{{is_array($customer) ? ($customer['with_nds']  == true ? 'С НДС' : 'Без НДС') : ($customer->with_nds  == true ? 'С НДС' : 'Без НДС')}}</p>

                    </div>
                </td>

                <td class="px-4 py-3 text-sm">
                    {{is_array($customer) ? $customer['manager_name'] : $customer->manager_name}}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                        <button
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit"
                            onclick='Livewire.emit("openModal", "user-edit", {{ json_encode(["what" => is_array($customer) ? $customer['what'] :  $customer->what,"id" => is_array($customer) ? $customer['id'] : $customer->id]) }})'
                        >
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                ></path>
                            </svg>
                        </button>

                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
