<!DOCTYPE html>
<html  x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
{{--    <script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.5.2/dist/datepicker.js"></script>
    @if(request()->route()->getName() != 'admin.application.edit' && request()->route()->getName() != 'admin.orders.repeat')
    @livewireStyles
    @powerGridStyles


    @elseif(request()->route()->getName() == 'admin.application.edit')
{{--            <script src="{{ asset('js/app.js') }}"></script>--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        <!--        <link rel="stylesheet" href="css/uikit.min.css" />-->
        <!--        <script src="js/uikit.min.js"></script>-->
        <!--        <script src="js/uikit-icons.min.js"></script>-->
        <link rel="stylesheet" href="{{ asset('css/uikit.css') }}" />
        <script src=" {{asset('js/uikit.js')}}"></script>
        <script src="{{ asset('js/uikit-icons.js') }}"></script>


    @elseif(request()->route()->getName() == 'admin.orders.repeat')
        {{--            <script src="{{ asset('js/app.js') }}"></script>--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        <!--        <link rel="stylesheet" href="css/uikit.min.css" />-->
        <!--        <script src="js/uikit.min.js"></script>-->
        <!--        <script src="js/uikit-icons.min.js"></script>-->
        <link rel="stylesheet" href="{{ asset('css/uikit.css') }}" />
        <script src=" {{asset('js/uikit.js')}}"></script>
        <script src="{{ asset('js/uikit-icons.js') }}"></script>
        <script src=" {{asset('js/uikit.js')}}"></script>
    @endif
</head>
<body>
<script>
    window.addEventListener('showAlert', event => {
        Livewire.emit( 'openModal', 'bulk-application-to-order-modal', {'ids': event.detail.ids });
    })
</script>
<div
    class="flex h-screen bg-gray-50"
    :class="{ 'overflow-hidden': isSideMenuOpen }"
>
    <!-- Desktop sidebar -->
    <aside
        class="z-1 hidden w-64 overflow-y-auto bg-white  md:block flex-shrink-0"
    >
        <div class="py-4 text-gray-500 ">
            <a
                class="ml-6 text-lg font-bold text-gray-800 "
                href="#"
            >
                Wernerus
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    @if(request()->route() == 'admin.orders.index')
              <span
                  class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                  aria-hidden="true"
              ></span>
                    @endif
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold @if(request()->route() == 'admin.orders.index') text-gray-800  @endif transition-colors duration-150 hover:text-gray-800 "
                        href="{{ route('admin.orders.index') }}"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            ></path>
                        </svg>
                        <span class="ml-4">Заказы </span>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="relative px-6 py-3">
                    @if(request()->route()->getName() == 'admin.application.index')
                        <span
                            class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"
                        ></span>
                    @endif
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors @if(request()->route()->getName() == 'admin.application.index') text-gray-800  @endif duration-150 hover:text-gray-800 "
                        href="{{ route('admin.application.index') }}"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                            ></path>
                        </svg>
                        <span class="ml-4">Заявки</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    @if(request()->route()->getName() == 'admin.user.index')
                        <span
                            class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"
                        ></span>
                    @endif
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors @if(request()->route()->getName() == 'admin.user.index') text-gray-800 @endif duration-150 hover:text-gray-800 "
                        href="{{ route('admin.user.index') }}"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                            ></path>
                        </svg>
                        <span class="ml-4">Клиенты</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    @if(request()->route()->getName() == 'admin.debt.index')
                        <span
                            class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"
                        ></span>
                    @endif
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 @if(request()->route()->getName() == 'admin.debt.index') text-gray-800 @endif hover:text-gray-800"
                        href="{{ route('admin.debt.index') }}"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                            ></path>
                        </svg>
                        <span class="ml-4">Задолженность</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  hover:text-gray-800"
                        href="#" onclick="Livewire.emit('openModal', 'registration-form')"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
                            ></path>
                            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <span class="ml-4">Зарегистрировать Пользователя</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
    <div
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    ></div>
    <aside
        class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white  md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -translate-x-20"
        @click.away="closeSideMenu"
        @keydown.escape="closeSideMenu"
    >
        <div class="py-4 text-gray-500 ">
            <a
                class="ml-6 text-lg font-bold text-gray-800"
                href="#"
            >
                Windmill
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
              <span
                  class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                  aria-hidden="true"
              ></span>
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800"
                        href="index.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            ></path>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                        href="forms.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                            ></path>
                        </svg>
                        <span class="ml-4">Forms</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                        href="cards.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                            ></path>
                        </svg>
                        <span class="ml-4">Cards</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 "
                        href="charts.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
                            ></path>
                            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <span class="ml-4">Charts</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                        href="buttons.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"
                            ></path>
                        </svg>
                        <span class="ml-4">Buttons</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                        href="modals.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                            ></path>
                        </svg>
                        <span class="ml-4">Modals</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                        href="tables.html"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span class="ml-4">Tables</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <button
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
                        @click="togglePagesMenu"
                        aria-haspopup="true"
                    >
                <span class="inline-flex items-center">
                  <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                  >
                    <path
                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                    ></path>
                  </svg>
                  <span class="ml-4">Pages</span>
                </span>
                        <svg
                            class="w-4 h-4"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                    <template x-if="isPagesMenuOpen">
                        <ul
                            x-transition:enter="transition-all ease-in-out duration-300"
                            x-transition:enter-start="opacity-25 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-xl"
                            x-transition:leave="transition-all ease-in-out duration-300"
                            x-transition:leave-start="opacity-100 max-h-xl"
                            x-transition:leave-end="opacity-0 max-h-0"
                            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50"
                            aria-label="submenu"
                        >
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
                            >
                                <a class="w-full" href="pages/login.html">Login</a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
                            >
                                <a class="w-full" href="pages/create-account.html">
                                    Create account
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
                            >
                                <a class="w-full" href="pages/forgot-password.html">
                                    Forgot password
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
                            >
                                <a class="w-full" href="pages/404.html">404</a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800"
                            >
                                <a class="w-full" href="pages/blank.html">Blank</a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
            <div class="px-6 my-6">
                <button
                    class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                    Create account
                    <span class="ml-2" aria-hidden="true">+</span>
                </button>
            </div>
        </div>
    </aside>
    <div class="flex flex-col flex-1 w-full">
        <header class="z-10 py-4 bg-white shadow-md">
            <div
                class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600"
            >
                <!-- Mobile hamburger -->
                <button
                    class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
                    @click="toggleSideMenu"
                    aria-label="Menu"
                >
                    <svg
                        class="w-6 h-6"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
                <!-- Search input -->
                <ul class="flex items-center flex-shrink-0 space-x-6">
                    <!-- Theme toggler -->
                    <li class="flex">
                        <button
                            class="rounded-md focus:outline-none focus:shadow-outline-purple"
                            @click="toggleTheme"
                            aria-label="Toggle color mode"
                        >
                            <template x-if="!dark">
                                <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
                                    ></path>
                                </svg>
                            </template>
                            <template x-if="dark">
                                <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </template>
                        </button>
                    </li>
                    <!-- Notifications menu -->
{{--                    <li class="relative">--}}
{{--                        <button--}}
{{--                            class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"--}}
{{--                            @click="toggleNotificationsMenu"--}}
{{--                            @keydown.escape="closeNotificationsMenu"--}}
{{--                            aria-label="Notifications"--}}
{{--                            aria-haspopup="true"--}}
{{--                        >--}}
{{--                            <svg--}}
{{--                                class="w-5 h-5"--}}
{{--                                aria-hidden="true"--}}
{{--                                fill="currentColor"--}}
{{--                                viewBox="0 0 20 20"--}}
{{--                            >--}}
{{--                                <path--}}
{{--                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"--}}
{{--                                ></path>--}}
{{--                            </svg>--}}
{{--                            <!-- Notification badge -->--}}
{{--                            <span--}}
{{--                                aria-hidden="true"--}}
{{--                                class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"--}}
{{--                            ></span>--}}
{{--                        </button>--}}
{{--                        <template x-if="isNotificationsMenuOpen">--}}
{{--                            <ul--}}
{{--                                x-transition:leave="transition ease-in duration-150"--}}
{{--                                x-transition:leave-start="opacity-100"--}}
{{--                                x-transition:leave-end="opacity-0"--}}
{{--                                @click.away="closeNotificationsMenu"--}}
{{--                                @keydown.escape="closeNotificationsMenu"--}}
{{--                                class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700"--}}
{{--                            >--}}
{{--                                <li class="flex">--}}
{{--                                    <a--}}
{{--                                        class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"--}}
{{--                                        href="#"--}}
{{--                                    >--}}
{{--                                        <span>Messages</span>--}}
{{--                                        <span--}}
{{--                                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600"--}}
{{--                                        >--}}
{{--                          13--}}
{{--                        </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="flex">--}}
{{--                                    <a--}}
{{--                                        class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"--}}
{{--                                        href="#"--}}
{{--                                    >--}}
{{--                                        <span>Sales</span>--}}
{{--                                        <span--}}
{{--                                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600"--}}
{{--                                        >--}}
{{--                          2--}}
{{--                        </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="flex">--}}
{{--                                    <a--}}
{{--                                        class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"--}}
{{--                                        href="#"--}}
{{--                                    >--}}
{{--                                        <span>Alerts</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </template>--}}
{{--                    </li>--}}
{{--                    <!-- Profile menu -->--}}
                    <li class="relative">
                        <a
                            class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                            href="{{ route('admin.manager_account') }}"
                            aria-label="Account"
                            aria-haspopup="true"
                        >
                            <img
                                class="object-cover w-8 h-8 rounded-full"
                                src="{{ asset('images/user.png') }}"
                                alt=""
                                aria-hidden="true"
                            />
                        </a>
{{--                        <template x-if="isProfileMenuOpen">--}}
{{--                            <ul--}}
{{--                                x-transition:leave="transition ease-in duration-150"--}}
{{--                                x-transition:leave-start="opacity-100"--}}
{{--                                x-transition:leave-end="opacity-0"--}}
{{--                                @click.away="closeProfileMenu"--}}
{{--                                @keydown.escape="closeProfileMenu"--}}
{{--                                class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"--}}
{{--                                aria-label="submenu"--}}
{{--                            >--}}
{{--                                <li class="flex">--}}
{{--                                    <a--}}
{{--                                        class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"--}}
{{--                                        href="#"--}}
{{--                                    >--}}
{{--                                        <svg--}}
{{--                                            class="w-4 h-4 mr-3"--}}
{{--                                            aria-hidden="true"--}}
{{--                                            fill="none"--}}
{{--                                            stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"--}}
{{--                                            stroke-width="2"--}}
{{--                                            viewBox="0 0 24 24"--}}
{{--                                            stroke="currentColor"--}}
{{--                                        >--}}
{{--                                            <path--}}
{{--                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"--}}
{{--                                            ></path>--}}
{{--                                        </svg>--}}
{{--                                        <span>Profile</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="flex">--}}
{{--                                    <a--}}
{{--                                        class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"--}}
{{--                                        href="#"--}}
{{--                                    >--}}
{{--                                        <svg--}}
{{--                                            class="w-4 h-4 mr-3"--}}
{{--                                            aria-hidden="true"--}}
{{--                                            fill="none"--}}
{{--                                            stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"--}}
{{--                                            stroke-width="2"--}}
{{--                                            viewBox="0 0 24 24"--}}
{{--                                            stroke="currentColor"--}}
{{--                                        >--}}
{{--                                            <path--}}
{{--                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"--}}
{{--                                            ></path>--}}
{{--                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>--}}
{{--                                        </svg>--}}
{{--                                        <span>Settings</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="flex">--}}
{{--                                    <a--}}
{{--                                        class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"--}}
{{--                                        href="#"--}}
{{--                                    >--}}
{{--                                        <svg--}}
{{--                                            class="w-4 h-4 mr-3"--}}
{{--                                            aria-hidden="true"--}}
{{--                                            fill="none"--}}
{{--                                            stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"--}}
{{--                                            stroke-width="2"--}}
{{--                                            viewBox="0 0 24 24"--}}
{{--                                            stroke="currentColor"--}}
{{--                                        >--}}
{{--                                            <path--}}
{{--                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"--}}
{{--                                            ></path>--}}
{{--                                        </svg>--}}
{{--                                        <span>Log out</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </template>--}}
                    </li>
                </ul>
            </div>
        </header>
        <main  class="h-full overflow-y-auto">
<div id="app">
    @yield('content')
</div>


        </main>
    </div>
</div>

@if(request()->route()->getName() == 'admin.application.edit')

<script src="{{ asset('js/arrays.js') }}"></script>
<script src="{{ asset('js/ADarrays.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@elseif(request()->route()->getName() == 'admin.orders.repeat')

    <script src="{{ asset('js/arrays.js') }}"></script>
    <script src="{{ asset('js/ADarrays.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@else

    @livewireScripts
    @wireUiScripts
    @powerGridScripts
    @livewire('livewire-ui-modal')
@endif
</body>
</html>