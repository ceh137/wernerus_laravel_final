<div class="p-7">
    <div wire:loading  class="blur"></div>
    <div wire:loading class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>
    <div class="font-semibold font-gray-700 text-2xl">{{ $confirmationTitle }}</div>

    <div class="py-2">


        <div class=" my-4 font-normal text-gray-600">
            <div class="space-x-2 flex justify-end mt-3">
                <button class="bg-gray-200 cursor-pointer text-black border border-gray-400 px-3 py-2 m-2 rounded text-lg"
                        wire:click="cancel">
                    Отменить
                </button>
                <button class="bg-green-500 cursor-pointer text-white px-3 py-2 m-2 rounded text-lg"
                        wire:click="confirm">
                    Перевести в заказы
                </button>
            </div>
        </div>
    </div>
    <style>
        .blur {
            z-index: 9998;
            position: fixed;
            top: 0;
            right: 0;
            width: 100vw;
            height: 100vh;
            /*-webkit-filter: blur(5px);*/
            /*-moz-filter: blur(5px);*/
            /*-o-filter: blur(5px);*/
            /*-ms-filter: blur(5px);*/
            background-color: rgba(0, 0, 0, 0.25);
        }
        .half-circle-spinner, .half-circle-spinner * {
            box-sizing: border-box;
            z-index: 9999;
        }

        .half-circle-spinner {
            top: 50%;
            right: 50%;
            width: 80px;
            height: 80px;
            transform: translate(-50%, -50%);
            border-radius: 100%;
            position: fixed;
        }

        .half-circle-spinner .circle {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 100%;
            border: calc(80px / 10) solid transparent;

        }

        .half-circle-spinner .circle.circle-1 {
            border-top-color: #1d8eff;
            animation: half-circle-spinner-animation 1s infinite;
        }

        .half-circle-spinner .circle.circle-2 {
            border-bottom-color: #1d8eff;
            animation: half-circle-spinner-animation 1s infinite alternate;
        }

        @keyframes half-circle-spinner-animation {
            0% {
                transform: rotate(0deg);

            }
            100%{
                transform: rotate(360deg);
            }
        }
    </style>
</div>
