<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Приложение №1</title>
    <meta name="author" content="b7" />
    <meta name="title" content="Приложение №1" />
    <meta name="company" content="b7" />
    <link rel="stylesheet" href="./pdfs/nakladnaya.css">
</head>

<body>
<div>
    <table class="nob">
        <tr class="nob">
            <td class="nob" colspan="5">
                <div class="title">
                    <span class="bold">Накладная на выдачу груза</span> по экспедиторской расписке
                </div>
            </td>
            <td class="nob" rowspan="2" colspan="3">
                <div class="track_num bold right ">
                    {!! DNS1D::getBarcodeHTML($order->order_num, 'C39', 1.7, 40) !!}
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

    <h1 class="table-header">ГРУЗОПОЛУЧАТЕЛЬ</h1>
    <div class="table-container top-table">
        <div class="inlineb" style="padding-right: 70px">
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
                    <td class="">
                        <div class="td-header left">
                            Телефоны
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            {{ $order->receiver->telnum }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Наименование организации
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            @if($order->receiver_comp)
                            {{$order->receiver_comp->name}}
                            @else
                            Физлицо
                            @endif
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            ИНН
                        </div>
                        <div class="table-info-text nob">
                            @if($order->receiver_comp)
                                {{$order->receiver_comp->INN}}
                            @else
                                --
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="inlineb">
            <table>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            ФИО представителя
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left">
                            {{ $order->receiver->name }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="" style="">
                        <div class="td-header left">
                            Документ подтверждающий личность
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text">
                            <div class="table-info-text-container  ">Серия</div>
                            <div class="table-info-text-container  "> </div>
                            <div class="table-info-text-container  ml-50">Номер</div>
                            <div class="table-info-text-container "></div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Доверенность
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text">
                            <div class="table-info-text-container  ">Серия</div>
                            <div class="table-info-text-container  "> </div>
                            <div class="table-info-text-container ml-50">Номер</div>
                            <div class="table-info-text-container "></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5  inlineb">
                            E-mail
                        </div>
                        <div class="table-info-text  inlineb">
                            {{ $order->receiver->email }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class=" ">
                        <div class="td-header mr-5 inlineb">
                            Время работы
                        </div>
                        <div class="table-info-text inlineb">
                            {{ $order->del_to_addr_time_from  ?: 'Не указано'}} - {{ $order->del_to_addr_time_to ?: 'Не указано'}}
                        </div>
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div>
    <div class="info-table middle-table">
        <h1 class="table-header">ГРУЗ</h1>
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
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>

            </tr>
        </table>
    </div>
    <div class="info-table">
        <h1 class="table-header">ОТМЕТКИ <span class="add-table-header">при заборе груза</span></h1>
        <div class="border max notes-field">
            {{$order->comment}}
        </div>
        <div class="border max">
            <ol class="small-ol">
                <li>Подтверждаю, что груз доставлен по указанному адресу и вручен грузополучателю</li>
                <li>Груз доставлен без внешних повреждений упаковки и соответствует сведениям указанным в заказе при
                    его приеме к экспедированию</li>
                <li>Коммерческий акт не составлялся</li>
                <li>Претензий по количеству мест, весу, объему принятого груза, а также к качеству и стоимости услуг
                    не имею.</li>
            </ol>
        </div>

        <div class="margin small">Подписанием данного документа Клиент подтверждает, что ознакомлен и согласен с
            условиями публичного
            договора транспортной экспедиции, правилами оказания услуг, тарифами, сроками доставки грузов,
            расположенными на сайте компании по адресу: www.wernerus.ru.</div>
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
                                                <img class="sign" style="top: 4px; right: 0; width: 120px" src="./images/sign_nds.png" alt="">
                                                <img class="stamp" src="./images/stamp_nds.png" alt="">
                                            </div>
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>
                                    <td class="nob">
                                        <div class="cell inlineb tc" style="width: 80px;">
                                            Тихоненко Р. С.
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
                    <span class="bold">Накладная на выдачу груза</span> по экспедиторской расписке
                </div>
            </td>
            <td class="nob" rowspan="2" colspan="3">
                <div class="track_num bold right ">
                    {!! DNS1D::getBarcodeHTML($order->order_num, 'C39', 1.7, 40) !!}
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

    <h1 class="table-header">ГРУЗОПОЛУЧАТЕЛЬ</h1>
    <div class="table-container top-table">
        <div class="inlineb" style="padding-right: 70px">
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
                    <td class="">
                        <div class="td-header left">
                            Телефоны
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            {{ $order->receiver->telnum }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Наименование организации
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left nob">
                            @if($order->receiver_comp)
                                {{$order->receiver_comp->name}}
                            @else
                                Физлицо
                            @endif
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5 left">
                            ИНН
                        </div>
                        <div class="table-info-text nob">
                            @if($order->receiver_comp)
                                {{$order->receiver_comp->INN}}
                            @else
                                --
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="inlineb">
            <table>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            ФИО представителя
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text left">
                            {{ $order->receiver->name }}
                        </div>
                        <div style="clear:both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="" style="">
                        <div class="td-header left">
                            Документ подтверждающий личность
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text">
                            <div class="table-info-text-container  ">Серия</div>
                            <div class="table-info-text-container  "> </div>
                            <div class="table-info-text-container  ml-50">Номер</div>
                            <div class="table-info-text-container "></div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header left">
                            Доверенность
                        </div>
                        <div style="clear:both;"></div>
                        <div class="table-info-text">
                            <div class="table-info-text-container  ">Серия</div>
                            <div class="table-info-text-container  "> </div>
                            <div class="table-info-text-container ml-50">Номер</div>
                            <div class="table-info-text-container "></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <div class="td-header mr-5  inlineb">
                            E-mail
                        </div>
                        <div class="table-info-text  inlineb">
                            {{ $order->receiver->email }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class=" ">
                        <div class="td-header mr-5 inlineb">
                            Время работы
                        </div>
                        <div class="table-info-text inlineb">
                            {{ $order->del_to_addr_time_from  ?: 'Не указано'}} - {{ $order->del_to_addr_time_to ?: 'Не указано'}}
                        </div>
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div>
        <div class="info-table middle-table">
            <h1 class="table-header">ГРУЗ</h1>
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
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        <div class="info-table">
            <h1 class="table-header">ОТМЕТКИ <span class="add-table-header">при заборе груза</span></h1>
            <div class="border max notes-field">
                {{$order->comment}}
            </div>
            <div class="border max">
                <ol class="small-ol">
                    <li>Подтверждаю, что груз доставлен по указанному адресу и вручен грузополучателю</li>
                    <li>Груз доставлен без внешних повреждений упаковки и соответствует сведениям указанным в заказе при
                        его приеме к экспедированию</li>
                    <li>Коммерческий акт не составлялся</li>
                    <li>Претензий по количеству мест, весу, объему принятого груза, а также к качеству и стоимости услуг
                        не имею.</li>
                </ol>
            </div>

            <div class="margin small">Подписанием данного документа Клиент подтверждает, что ознакомлен и согласен с
                условиями публичного
                договора транспортной экспедиции, правилами оказания услуг, тарифами, сроками доставки грузов,
                расположенными на сайте компании по адресу: www.wernerus.ru.</div>
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
                                                <img class="sign" style="top: 4px; right: 0; width: 120px" src="./images/sign_nds.png" alt="">
                                                <img class="stamp" src="./images/stamp_nds.png" alt="">
                                            </div>
                                        </div>
                                        <div class="cell inlineb">
                                            /
                                        </div>

                                    </td>
                                    <td class="nob">
                                        <div class="cell inlineb tc" style="width: 80px;">
                                            Тихоненко Р. С.
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

