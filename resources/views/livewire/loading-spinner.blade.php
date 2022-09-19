<div  id="scope-{{ $cssScope }}" >
    <div  class="blur"></div>
    <div  class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <style>
        /* you will need to apply scopes yourself manually */
        #scope-{{ $cssScope }} .blur {
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
        #scope-{{ $cssScope }} .half-circle-spinner, .half-circle-spinner * {
            box-sizing: border-box;
            z-index: 9999;
        }

        #scope-{{ $cssScope }} .half-circle-spinner {
            top: 50%;
            right: 50%;
            width: 80px;
            height: 80px;
            transform: translate(-50%, -50%);
            border-radius: 100%;
            position: fixed;
        }

        #scope-{{ $cssScope }} .half-circle-spinner .circle {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 100%;
            border: calc(80px / 10) solid transparent;

        }

        #scope-{{ $cssScope }} .half-circle-spinner .circle.circle-1 {
            border-top-color: #1d8eff;
            animation: half-circle-spinner-animation 1s infinite;
        }

        #scope-{{ $cssScope }} .half-circle-spinner .circle.circle-2 {
            border-bottom-color: #1d8eff;
            animation: half-circle-spinner-animation 1s infinite alternate;
        }

        @keyframes #scope-{{ $cssScope }} half-circle-spinner-animation {
            0% {
                transform: rotate(0deg);

            }
            100%{
                transform: rotate(360deg);
            }
        }
    </style>
</div>
