<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./pdfs/PE.css">
    <title>Document</title>
</head>

<body>
<div>
    <table class="nob">
        <tr class="nob">
            <td class="nob" colspan="5">
                <div class="title">
                    <span class="bold">Поручение экспедитору / Экспедиторская расписка</span>
                </div>
            </td>
            <td class="nob" rowspan="2" colspan="3">
                <div class="track_num bold right ">
                    {!! DNS1D::getBarcodeHTML($order->order_num, 'C39', 1.7, 38) !!}
                    {{--                    <img style="width: 100px; height: 40px" src="{{'data:image/png;base64, ' .  base64_encode(DNS1D::getBarcodePNG('T01-T611', 'C39+')) }}" alt="barcode"   />'--}}
                </div>
            </td>
            <td class="nob" rowspan="2" colspan="2">
                <div class="logo left">
                    <img class="logo-img" src="./images/werner-logo.png" alt="">
                </div>
            </td>

        </tr>
        <tr class="nob">
            <td class="nob">
                <div class=" tc up" style="width: 50px">
                    №
                </div>
            </td>
            <td class="nob">
                <div class="num border  up  tc">
                    {{ $order->order_num }}
                </div>
            </td>
            <td class="nob">
                <div class="up tc" style="width: 50px">
                    <div>
                        от
                    </div>
                </div>

            </td>
            <td class="nob">
                <div class="date border up  tc">
                    {{ \Carbon\Carbon::parse($order->time_to_order)->format('d.m.Y') }}
                </div>
            </td>
            <td class="nob"></td>

        </tr>
    </table>

    <hr class="divider">
    <div class="table-container top-table">
        <div class="inlineb" style="padding-right: 70px">

            <h1 class="table-header">ОТПРАВИТЕЛЬ</h1>
            <table>
                <tr>
                    <td>Город: <span class="table-info-text nob">{{ $order->route->city_from->name }}</span></td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Адрес получения груза
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            {{ $order->address_from }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>

                    <td>Телефоны: <span class="table-info-text nob">{{ $order->sender->telnum }}</span></td>

                </tr>
                <td class="">
                    <div class="td-header left">
                        ФИО отправителя
                    </div>
                    <div class="td-header right  border-l passport">
                        Паспорт
                    </div>
                    <div style="clear:both;"></div>
                    <div class="table-info-text left nob">
                        {{ $order->sender->name }}
                    </div>
                    <div class="table-info-text right nob passport">

                    </div>

                    <div style="clear:both;"></div>
                </td>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Наименование организации
                        </div>
                        <div class="td-header right  border-l passport">
                            ИНН
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            @if($order->sender_comp)
                                {{$order->sender_comp->name}}
                            @else
                                Физлицо
                            @endif
                        </div>
                        <div class="table-info-text right nob passport">
                            @if($order->sender_comp)
                                {{$order->sender_comp->INN}}
                            @else
                                --
                            @endif
                        </div>

                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Email
                        </div>
                        <div class="table-info-text nob">
                            {{ $order->sender->email }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Часы работы
                        </div>
                        <div class="table-info-text nob">
                            {{ $order->del_from_addr_time_from  ?: 'Не указано'}} - {{ $order->del_from_addr_time_to ?: 'Не указано'}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="inlineb">

            <h1 class="table-header">ПОЛУЧАТЕЛЬ</h1>
            <table>
                <tr>
                    <td>Город: <span class="table-info-text nob">{{ $order->route->city_to->name }}</span></td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Адрес получения груза
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            {{ $order->address_to }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>

                    <td>Телефоны: <span class="table-info-text nob">{{ $order->receiver->telnum }}</span></td>

                </tr>
                <td class="">
                    <div class="td-header left">
                        ФИО Получателя
                    </div>
                    <div class="td-header right  border-l passport">
                        Паспорт
                    </div>
                    <div style="clear:both;"></div>
                    <div class="table-info-text left nob">
                        {{ $order->receiver->name}}
                    </div>
                    <div class="table-info-text right nob passport">

                    </div>

                    <div style="clear:both;"></div>
                </td>
                <tr>
                    <div class="td-header left">
                        Наименование организации
                    </div>
                    <div class="td-header right  border-l passport">
                         ИНН
                    </div>
                    <div style="clear:both;"></div>
                    <div class="table-info-text left nob">
                        @if($order->receiver_comp)
                            {{$order->receiver_comp->name}}
                        @else
                            Физлицо
                        @endif
                    </div>
                    <div class="table-info-text right nob passport">
                        @if($order->receiver_comp)
                            {{$order->receiver_comp->INN}}
                        @else
                            --
                        @endif
                    </div>

                    <div style="clear:both;"></div>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Email
                        </div>
                        <div class="table-info-text nob">
                            {{$order->receiver->email}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Часы работы
                        </div>
                        <div class="table-info-text nob">
                            {{ $order->del_to_addr_time_from  ?: 'Не указано'}} - {{ $order->del_to_addr_time_to ?: 'Не указано'}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div>
        <div class="info-table middle-table">
            <h1 class="table-header mid">ГРУЗ</h1>
            <table>
                <tr>
                    <td class="td-header tc" colspan="2">Наименование</td>
                    <td class="td-header tc">Кол-во мест</td>
                    <td class="td-header tc">Масса</td>
                    <td class="td-header tc">Обьем</td>
                    <td class="td-header tc">Макс. Габарит</td>
                    <td class="td-header tc">Стоимость груза</td>
                </tr>
                <tr>
                    <td colspan="2" class="cargo-info">
                        @if($order->cargo_type->name == 'ТНП')
                            Товары народного потребления
                        @else
                            {{ $order->cargo_type->name }}
                        @endif
                    </td>
                    <td class="cargo-info">{{ $order->pieces }}</td>
                    <td class="cargo-info">{{ $order->weight }} кг</td>
                    <td class="cargo-info">{{ $order->volume }} м<sup>3</sup></td>
                    <td class="cargo-info">{{ $order->longest }} см</td>
                    <td class="cargo-info">{{ $order->worth }} &#8381;</td>
                </tr>
                <tr>
                    <td  class="cargo-info py nob">

                        <div class="cell w70  pr-5 inlineb ">Заказ доп. упаковки</div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 inlineb pl-5 tc">
                            <label class="check-container">
                                <div class="left ml-5">ЖУ</div>
                                <input type="checkbox" @if($order->rig_pac) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container mr-5">
                                <div class="left ml-5">П/Борт</div>
                                <input type="checkbox" @if($order->bort_pac) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container mr-10">
                                <div class="left ml-5">Мешок</div>
                                <input type="checkbox" >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td colspan="2" class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container  mr-10">
                                <div class="left ml-5">Паллетирование</div>
                                <input type="checkbox" @if($order->bort_pac) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container  mr-5">
                                <div class="left ml-5">Коробка</div>
                                <input type="checkbox" >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        <div style="margin-top: 2px">
            <table class="nob">
                <tr class="nob">
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Упаковка клиента не соответствует характеру груза/отсутствует</div>
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td class="nob" rowspan="2">
                        Счет на оплату направить
                    </td>
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Отправителю</div>
                            <input type="checkbox" @if($invoice_to_sender) checked="checked" @endif>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
                <tr class="nob">
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Имеются повреждения груза или упаковки</div>
                            <input type="checkbox" >
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Получателю</div>
                            <input type="checkbox" @if($invoice_to_receiver) checked="checked" @endif>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
            </table>
        </div>
        <div class="info-table">
            <h1 class="table-header">ОТМЕТКИ <span class="add-table-header">при заборе груза</span></h1>
            <div class="border max notes-field">
                Пометки
            </div>
            <div class="small border max">
                Клиент поручает Экспедитору застраховать груз на условиях и по тарифам, размещенным на сайте Экспедитора www.wernerus.ru. Клиент гарантирует, что объявленная стоимость не превышает его реальную (документально подтвержденную) стоимость, и возмещает все убытки, возникшие у Сторон вследствие нарушения Клиентом данной гарантии.
            </div>
            <h1 class="table-header tc inlineb max">Поручение согласовано:</h1>
            <div class="margin small tc consent">Подписанием данного документа Клиент подтверждает, что ознакомлен и согласен с условиями публичного договора транспортной экспедиции, правилами оказания услуг, тарифами, сроками доставки грузов, расположенными на сайте компании по адресу: www.wernerus.ru и гарантирует, что им получено от Плательщика и Грузополучателя согласие с условиями указанного договора, а также тарифами и условиями страхования.</div>
        </div>

    </div>
    <div class="footer mx-5">
        <div class=" left predstavitel">
            <div class="title my-5">
                <h1 class="bold text-footer">ПРЕДСТАВИТЕЛЬ экспедитора</h1>
            </div>
            <table class="nob">
                <tr class="nob">
                    <td class="nob">
                        <table class="nopad nob" style="width: 40px">
                            <tr class="nopad nob">
                                <td class="nopad  nob"><div class="tc">{{ \Carbon\Carbon::parse($order->time_to_order)->format('d.m.Y') }}</div></td>
                            </tr>
                            <tr class="nopad nob">
                                <td class="nopad nob">
                                    <div class=" tc max">
                                        <hr>
                                    </div>
                                </td>
                            </tr>
                            <tr class="nopad  nob">
                                <td class="nopad nob"><div class=" max tc">дата</div></td>
                            </tr>
                        </table>
                        {{--                        <div class="left">--}}
                        {{--                            <div class="left tc">25.07.2022</div>--}}
                        {{--                            <div style="clear:both;"></div>--}}
                        {{--                            <div class="left tc max">--}}
                        {{--                                <hr>--}}
                        {{--                            </div>--}}
                        {{--                            <div style="clear:both;"></div>--}}
                        {{--                            <div class="left max tc">дата</div>--}}
                        {{--                        </div>--}}
                    </td>
                    <td class="nob">
                        <div class="">
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell inlineb" style="width: 80px;">
                                            <div class="inlineb" style="width: 80px; position: relative;">
                                                <img class="sign" src="./images/sign.png" alt="">
                                                <img class="stamp" src="./images/stamp.png" alt="">
                                            </div>
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>
                                    <td class="nob">
                                        <div class="cell inlineb tc" style="width: 80px;">
                                            Бунчук С. В.
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>

                                </tr>
                            </table>
                            <div>
                                <hr class="max">
                            </div>
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">подпись</div>
                                    </td>
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">ФИО</div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{--                        <div class="inlineb">--}}
                        {{--                            <div class="inlineb" style="width: 150px; position: relative;">--}}
                        {{--                                <img class="sign" src="./images/sign.png" alt="">--}}
                        {{--                                <img class="stamp" src="./images/stamp.png" alt="">--}}
                        {{--                            </div>--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}

                        {{--                            <div class="inlineb" style="min-width: max-content;">/Бунчук С. В./</div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <hr>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="max">--}}
                        {{--                            <div class="inlineb  mx-5">подпись</div>--}}
                        {{--                            <div class="inlineb  mr-5">ФИО</div>--}}
                        {{--                        </div>--}}
                    </td>
                </tr>
            </table>

        </div>
        <div class="client-sign right">
            <div class="title my-5">
                <h1 class="bold text-footer">КЛИЕНТ (грузополучатель)</h1>
            </div>
            <table class=" nob">
                <tr  class="  nob">
                    <td class="nob nopad">
                        <table class="nopad nob" style="width: 40px; margin-right: 20px">
                            <tr class="nopad nob">
                                <td class="nopad  nob"><div class="tc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                            </tr>
                            <tr class="nopad nob">
                                <td class="nopad nob">
                                    <div class=" tc max">
                                        <hr>
                                    </div>
                                </td>
                            </tr>
                            <tr class="nopad  nob">
                                <td class="nopad nob"><div class=" max tc">дата</div></td>
                            </tr>
                        </table>
                    </td>
                    <td class="nob nopad">
                        <div class="mr-5">
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell inlineb" style="width: 80px;"></div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>
                                    <td class="nob">
                                        <div class="cell inlineb" style="width: 80px;">
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>

                                </tr>
                            </table>
                            <div>
                                <hr class="max">
                            </div>
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">подпись</div>
                                    </td>
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">ФИО</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="my-5">



            </div>
        </div>
    </div>
</div>

<hr class="cut-line">

<div>
    <table class="nob">
        <tr class="nob">
            <td class="nob" colspan="5">
                <div class="title">
                    <span class="bold">Поручение экспедитору / Экспедиторская расписка</span>
                </div>
            </td>
            <td class="nob" rowspan="2" colspan="3">
                <div class="track_num bold right ">
                    {!! DNS1D::getBarcodeHTML($order->order_num, 'C39', 1.7, 38) !!}
                    {{--                    <img style="width: 100px; height: 40px" src="{{'data:image/png;base64, ' .  base64_encode(DNS1D::getBarcodePNG('T01-T611', 'C39+')) }}" alt="barcode"   />'--}}
                </div>
            </td>
            <td class="nob" rowspan="2" colspan="2">
                <div class="logo left">
                    <img class="logo-img" src="./images/werner-logo.png" alt="">
                </div>
            </td>

        </tr>
        <tr class="nob">
            <td class="nob">
                <div class=" tc up" style="width: 50px">
                    №
                </div>
            </td>
            <td class="nob">
                <div class="num border  up  tc">
                    {{ $order->order_num }}
                </div>
            </td>
            <td class="nob">
                <div class="up tc" style="width: 50px">
                    <div>
                        от
                    </div>
                </div>

            </td>
            <td class="nob">
                <div class="date border up  tc">
                    {{ \Carbon\Carbon::parse($order->time_to_order)->format('d.m.Y') }}
                </div>
            </td>
            <td class="nob"></td>

        </tr>
    </table>

    <hr class="divider">
    <div class="table-container top-table">
        <div class="inlineb" style="padding-right: 70px">

            <h1 class="table-header">ОТПРАВИТЕЛЬ</h1>
            <table>
                <tr>
                    <td>Город: <span class="table-info-text nob">{{ $order->route->city_from->name }}</span></td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Адрес получения груза
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            {{ $order->route->address_from }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>

                    <td>Телефоны: <span class="table-info-text nob">{{ $order->sender->telnum }}</span></td>

                </tr>
                <td class="">
                    <div class="td-header left">
                        ФИО отправителя
                    </div>
                    <div class="td-header right  border-l passport">
                        Паспорт
                    </div>
                    <div style="clear:both;"></div>
                    <div class="table-info-text left nob">
                        {{ $order->sender->name }}
                    </div>
                    <div class="table-info-text right nob passport">
                        1231231231
                    </div>

                    <div style="clear:both;"></div>
                </td>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Наименование организации
                        </div>
                        <div class="td-header right  border-l passport">
                            ИНН
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            @if($order->sender_comp)
                                {{$order->sender_comp->name}}
                            @else
                                Физлицо
                            @endif
                        </div>
                        <div class="table-info-text right nob passport">
                            @if($order->sender_comp)
                                {{$order->sender_comp->INN}}
                            @else
                                --
                            @endif
                        </div>

                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Email
                        </div>
                        <div class="table-info-text nob">
                            {{ $order->sender->email }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Часы работы
                        </div>
                        <div class="table-info-text nob">
                            {{ $order->del_from_addr_time_from  ?: 'Не указано'}} - {{ $order->del_from_addr_time_to ?: 'Не указано'}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="inlineb">

            <h1 class="table-header">ПОЛУЧАТЕЛЬ</h1>
            <table>
                <tr>
                    <td>Город: <span class="table-info-text nob">{{ $order->route->city_to->name }}</span></td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Адрес получения груза
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            {{ $order->route->address_to }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>

                    <td>Телефоны: <span class="table-info-text nob">{{ $order->receiver->telnum }}</span></td>

                </tr>
                <td class="">
                    <div class="td-header left">
                        ФИО отправителя
                    </div>
                    <div class="td-header right  border-l passport">
                        Паспорт
                    </div>
                    <div style="clear:both;"></div>
                    <div class="table-info-text left nob">
                        {{ $order->sender->name}}
                    </div>
                    <div class="table-info-text right nob passport">

                    </div>

                    <div style="clear:both;"></div>
                </td>
                <tr>
                    <div class="td-header left">
                        Наименование организации
                    </div>
                    <div class="td-header right  border-l passport">
                        ИНН
                    </div>
                    <div style="clear:both;"></div>
                    <div class="table-info-text left nob">
                        @if($order->receiver_comp)
                            {{$order->receiver_comp->name}}
                        @else
                            Физлицо
                        @endif
                    </div>
                    <div class="table-info-text right nob passport">
                        @if($order->receiver_comp)
                            {{$order->receiver_comp->INN}}
                        @else
                            --
                        @endif
                    </div>

                    <div style="clear:both;"></div>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Email
                        </div>
                        <div class="table-info-text nob">
                            {{$order->receiver->email}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            Часы работы
                        </div>
                        <div class="table-info-text nob">
                            {{ $order->del_to_addr_time_from  ?: 'Не указано'}} - {{ $order->del_to_addr_time_to ?: 'Не указано'}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div>
        <div class="info-table middle-table">
            <h1 class="table-header mid">ГРУЗ</h1>
            <table>
                <tr>
                    <td class="td-header tc" colspan="2">Наименование</td>
                    <td class="td-header tc">Кол-во мест</td>
                    <td class="td-header tc">Масса</td>
                    <td class="td-header tc">Обьем</td>
                    <td class="td-header tc">Макс. Габарит</td>
                    <td class="td-header tc">Стоимость груза</td>
                </tr>
                <tr>
                    <td colspan="2" class="cargo-info">
                        @if($order->cargo_type->name == 'ТНП')
                            Товары народного потребления
                        @else
                            {{ $order->cargo_type->name }}
                        @endif
                    </td>
                    <td class="cargo-info">{{ $order->pieces }}</td>
                    <td class="cargo-info">{{ $order->weight }} кг</td>
                    <td class="cargo-info">{{ $order->volume }} м<sup>3</sup></td>
                    <td class="cargo-info">{{ $order->longest }} см</td>
                    <td class="cargo-info">{{ $order->worth }} &#8381;</td>
                </tr>
                <tr>
                    <td  class="cargo-info py nob">

                        <div class="cell w70  pr-5 inlineb ">Заказ доп. упаковки</div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 inlineb pl-5 tc">
                            <label class="check-container">
                                <div class="left ml-5">ЖУ</div>
                                <input type="checkbox" @if($order->rig_pac) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container mr-5">
                                <div class="left ml-5">П/Борт</div>
                                <input type="checkbox" @if($order->bort_pac) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container mr-10">
                                <div class="left ml-5">Мешок</div>
                                <input type="checkbox" >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td colspan="2" class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container  mr-10">
                                <div class="left ml-5">Паллетирование</div>
                                <input type="checkbox" @if($order->bort_pac) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>
                    <td class="nob">
                        <div class="cell w30 pr-5 inlineb">
                            <label class="check-container  mr-5">
                                <div class="left ml-5">Коробка</div>
                                <input type="checkbox" >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        <div style="margin-top: 2px">
            <table class="nob">
                <tr class="nob">
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Упаковка клиента не соответствует характеру груза/отсутствует</div>
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td class="nob" rowspan="2">
                        Счет на оплату направить
                    </td>
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Отправителю</div>
                            <input type="checkbox" @if($invoice_to_sender) checked="checked" @endif>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
                <tr class="nob">
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Имеются повреждения груза или упаковки</div>
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td class="nob">
                        <label class="check-container  mr-5">
                            <div class="left ml-5">Получателю</div>
                            <input type="checkbox" @if($invoice_to_receiver) checked="checked" @endif>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
            </table>
        </div>
        <div class="info-table">
            <h1 class="table-header">ОТМЕТКИ <span class="add-table-header">при заборе груза</span></h1>
            <div class="border max notes-field">
                Пометки
            </div>
            <div class="small border max">
                Клиент поручает Экспедитору застраховать груз на условиях и по тарифам, размещенным на сайте Экспедитора www.wernerus.ru. Клиент гарантирует, что объявленная стоимость не превышает его реальную (документально подтвержденную) стоимость, и возмещает все убытки, возникшие у Сторон вследствие нарушения Клиентом данной гарантии.
            </div>
            <h1 class="table-header tc inlineb max">Поручение согласовано:</h1>
            <div class="margin small tc consent">Подписанием данного документа Клиент подтверждает, что ознакомлен и согласен с условиями публичного договора транспортной экспедиции, правилами оказания услуг, тарифами, сроками доставки грузов, расположенными на сайте компании по адресу: www.wernerus.ru и гарантирует, что им получено от Плательщика и Грузополучателя согласие с условиями указанного договора, а также тарифами и условиями страхования.</div>
        </div>

    </div>
    <div class="footer mx-5">
        <div class=" left predstavitel">
            <div class="title my-5">
                <h1 class="bold text-footer">ПРЕДСТАВИТЕЛЬ экспедитора</h1>
            </div>
            <table class="nob">
                <tr class="nob">
                    <td class="nob">
                        <table class="nopad nob" style="width: 40px">
                            <tr class="nopad nob">
                                <td class="nopad  nob"><div class="tc">{{ \Carbon\Carbon::parse($order->time_to_order)->format('d.m.Y') }}</div></td>
                            </tr>
                            <tr class="nopad nob">
                                <td class="nopad nob">
                                    <div class=" tc max">
                                        <hr>
                                    </div>
                                </td>
                            </tr>
                            <tr class="nopad  nob">
                                <td class="nopad nob"><div class=" max tc">дата</div></td>
                            </tr>
                        </table>
                        {{--                        <div class="left">--}}
                        {{--                            <div class="left tc">25.07.2022</div>--}}
                        {{--                            <div style="clear:both;"></div>--}}
                        {{--                            <div class="left tc max">--}}
                        {{--                                <hr>--}}
                        {{--                            </div>--}}
                        {{--                            <div style="clear:both;"></div>--}}
                        {{--                            <div class="left max tc">дата</div>--}}
                        {{--                        </div>--}}
                    </td>
                    <td class="nob">
                        <div class="">
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell inlineb" style="width: 80px;">
                                            <div class="inlineb" style="width: 80px; position: relative;">
                                                <img class="sign" src="./images/sign.png" alt="">
                                                <img class="stamp" src="./images/stamp.png" alt="">
                                            </div>
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>
                                    <td class="nob">
                                        <div class="cell inlineb tc" style="width: 80px;">
                                            Бунчук С. В.
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>

                                </tr>
                            </table>
                            <div>
                                <hr class="max">
                            </div>
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">подпись</div>
                                    </td>
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">ФИО</div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{--                        <div class="inlineb">--}}
                        {{--                            <div class="inlineb" style="width: 150px; position: relative;">--}}
                        {{--                                <img class="sign" src="./images/sign.png" alt="">--}}
                        {{--                                <img class="stamp" src="./images/stamp.png" alt="">--}}
                        {{--                            </div>--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}
                        {{--                            &nbsp;--}}

                        {{--                            <div class="inlineb" style="min-width: max-content;">/Бунчук С. В./</div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <hr>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="max">--}}
                        {{--                            <div class="inlineb  mx-5">подпись</div>--}}
                        {{--                            <div class="inlineb  mr-5">ФИО</div>--}}
                        {{--                        </div>--}}
                    </td>
                </tr>
            </table>

        </div>
        <div class="client-sign right">
            <div class="title my-5">
                <h1 class="bold text-footer">КЛИЕНТ (грузополучатель)</h1>
            </div>
            <table class=" nob">
                <tr  class="  nob">
                    <td class="nob nopad">
                        <table class="nopad nob" style="width: 40px; margin-right: 20px">
                            <tr class="nopad nob">
                                <td class="nopad  nob"><div class="tc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                            </tr>
                            <tr class="nopad nob">
                                <td class="nopad nob">
                                    <div class=" tc max">
                                        <hr>
                                    </div>
                                </td>
                            </tr>
                            <tr class="nopad  nob">
                                <td class="nopad nob"><div class=" max tc">дата</div></td>
                            </tr>
                        </table>
                    </td>
                    <td class="nob nopad">
                        <div class="mr-5">
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell inlineb" style="width: 80px;"></div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>
                                    <td class="nob">
                                        <div class="cell inlineb" style="width: 80px;">
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>

                                </tr>
                            </table>
                            <div>
                                <hr class="max">
                            </div>
                            <table class="nob">
                                <tr class="nob">
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">подпись</div>
                                    </td>
                                    <td class="nob">
                                        <div class="cell tc " style="width: 80px;">ФИО</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="my-5">



            </div>
        </div>
    </div>
</div>
</body>

</html>
