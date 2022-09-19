@extends('index.layouts.main')

@section('content')
    <p><br>
        </p>
    <p><br>
        </p>
    <p>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp; СПАСИБО! Ваша Заявка уже в работе!<br>
        </p>
    <br>
    <div class="content-print">
        <div class='head-top-logo'><img src="../images/werner-logo.png"/></div>
        <div class='head-top-locations'>
            <h4 class='group-label'>{{ $order->route->city_from->name }}<span><!--&#10174;--><img src="../images/arrow2.png" style="width: 40px; top: 2px; position: relative;"></span>{{ $order->route->city_to->name }}</h4>
            <h6>{{ $order->address_from }}<span>&nbsp;<img src="../images/arrow2.png" style="width: 15px; position: relative;">&nbsp;</span>{{ $order->address_to }}</h6></div>
        <p>Объем:&nbsp;{{ $order->volume }}м&#179; Вес:&nbsp;{{ $order->weight }}кг.&nbsp; Вид доставки: {{ $order->method->name }} Тип Груза: {{ $order->cargo_type->name }}</p>

        <br>
        <div class='order' style="font-family: Tahoma">
            <ul>
                    <li>
            <span class='cost'>
                <span class='value'>{{ $order->order_prices->TT_price }} </span>р.
            </span>
                        <span class='label'>ТТ</span>
                    </li>
                    <li>
            <span class='cost'>
                <span class='value'>{{ $order->order_prices->pac_price }} </span>р.
            </span>
                        <span class='label'>Упаковка (
                        {{ $order->stretch_pac ? "Cтрейч " : '' }}
                            {{ $order->rig_pac ? "Жесткая " : '' }}
                            {{ $order->bort_pac ? "Паллет-борт " : '' }} )</span>
                    </li>
                    <li>
            <span class='cost'>
                <span class='value'>{{ $order->order_prices->prr_to_addr_price }} </span>р.
            </span>
                        <span class='label'>ПРР при доставке</span>
                    </li>
                    <li>
            <span class='cost'>
                <span class='value'>{{ $order->order_prices->prr_from_addr_price }} </span>р.
            </span>
                        <span class='label'>ПРР при заборе</span>
                    </li>
                    <li>
            <span class='cost'>
                <span class='value'>{{ $order->order_prices->to_addr_price }} </span>р.
            </span>
                        <span class='label'>Доставка до адреса</span>
                    </li>
                    <li>
            <span class='cost'>
                <span class='value'>{{ $order->order_prices->from_addr_price }} </span>р.
            </span>
                        <span class='label'>Забор на адресе</span>
                    </li>
                    <li>
                <span class='cost'>
                    <span class='value'>{{ $order->order_prices->insurance_price }} </span>р.
                </span>
                        <span class='label'>Страховка (Ценность: {{ $order->worth }})</span>
                    </li>
                </ul>
            <ul class='total'>

                    <li>
            <span class='cost total-sum'>
                <span class='value'>{{ $order->order_prices->total }} </span>р.
            </span>
                        <span style="color: #1E90FF" class='label total-sum'>Стоимость заказа</span>
                    </li>

            </ul>
            <p>

                    {{ $order->sender->name }}, {{ optional($order->sender_comp)->INN ?: 'физлицо' }}
                    <br>
                    Дата и время создания заявки: {{ $order->created_at }}</p></div>
        Уважаемые коллеги, значимая информация для улучшения нашего сотрудничества!
        <div style="caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0);
 font-size: 16px; font-style: normal; font-variant-caps: normal;
font-weight: normal; letter-spacing: normal; orphans: auto;
text-align: start; text-indent: 0px; text-transform: none;
white-space: normal; widows: auto; word-spacing: 0px;
-webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;
text-decoration: none;">&nbsp;</div>
        <div style="caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0);
        font-size: 16px; font-style: normal; font-variant-caps: normal;
font-weight: normal; letter-spacing: normal; orphans: auto;
text-align: start; text-indent: 0px; text-transform: none;
white-space: normal; widows: auto; word-spacing: 0px;
-webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;
text-decoration: none;" align="justify">Если вы планируете
            отправить груз по услуге<strong><span
                    class="Apple-converted-space">&nbsp;</span>"Реальный
                экспресс"</strong><span class="Apple-converted-space"> </span><span
                style="font-size: 16px; line-height: 24px;"> и<span
                    class="Apple-converted-space">&nbsp;</span></span>мы должны
            забрать ваш груз от адреса отправителя, то просим<span
                class="Apple-converted-space">&nbsp;</span><strong>разместить
                заявку<span class="Apple-converted-space">&nbsp;</span></strong>на нашем сайте<strong><span class="Apple-converted-space"> </span></strong><strong><span
                    class="Apple-converted-space"><span
                        class="Apple-converted-space"></span><span
                        style="font-size: 20px; line-height: 28px;"><strong> накануне<span
                                class="Apple-converted-space"></span></strong></span>
дня забора </span></strong><span style="font-size: 20px;
line-height:
28px;"><strong><span class="Apple-converted-space"></span></strong></span><strong>до
                18.00<span class="Apple-converted-space"></span></strong></div>
        <div style="caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0);
font-size:16px; font-style: normal; font-variant-caps: normal;
font-weight: normal; letter-spacing: normal; orphans: auto;
text-align: start; text-indent: 0px; text-transform: none;
white-space: normal; widows: auto; word-spacing: 0px;
-webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;
text-decoration: none;" align="justify">
            <div align="justify">Если вы планируете отправить груз по услуге<strong><span
                        class="Apple-converted-space">&nbsp;</span>"Реальный
                    экспресс"</strong><span class="Apple-converted-space">&nbsp;</span><span
                    style="font-size: 20px; line-height: 28px;"><strong>сегодня<span
                            class="Apple-converted-space">&nbsp;</span></strong></span><span
                    style="font-size: 16px; line-height: 24px;">и хотите<span
                        class="Apple-converted-space"> </span><strong><br>
самостоятельно привезти</strong><span
                        class="Apple-converted-space">&nbsp;</span>груз к нам на
терминал</span>, то просим сделать<strong><span
                        class="Apple-converted-space">&nbsp;</span></strong>это<span
                    class="Apple-converted-space"> <br>
</span><span style="font-size: 20px; line-height: 28px;"><strong>сегодня<span
                            class="Apple-converted-space">&nbsp;</span></strong></span><strong>до
                    15.00</strong></div>
            <div><br>
            </div>
        </div>
        <div style="caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0);
         font-size: 16px; font-style: normal; font-variant-caps: normal;
         font-weight: normal; letter-spacing: normal;
text-align: start; text-indent: 0px; text-transform: none;
white-space: normal; widows: auto; word-spacing: 0px;
-webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px;
text-decoration: none;">
            <div align="justify">Данная просьба обусловлена нашим
                стремлением выполнять данные вам обязательства в 100%
                отправок.<br>
            </div>
            <div><a href="javascript:(print()); " class="button-print"><font
                        face="courier">Печать</font></a></div>
        </div>


    </div>
    <link href="/static/v1.0/css/lib/icons.scss" type="text/css"
          rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        document.getElementById('print').addEventListener('click', () =>{
            print();
        })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
@endsection
