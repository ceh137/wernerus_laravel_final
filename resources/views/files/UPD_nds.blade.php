<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Приложение №1</title>
    <meta name="author" content="b7" />
    <meta name="title" content="Приложение №1" />
    <meta name="company" content="b7" />
    <link rel="stylesheet" href="./pdfs/UPD.css">
</head>
<body>
<div class="border-line" style="height: {{$height}}px"></div>
<div class="content">

    <div class="top-application-text right">
        Приложение No 1 к постановлению Правительства Российской Федерации от 26 декабря 2011 г. No 1137 <br> (в
        редакции постановления Правительства Российской Федерации от 2 апреля 2021 г. No 534)
    </div>
    <div class="top-application-text right">
        {!! DNS1D::getBarcodeHTML( $order->order_num, 'C39', 1, 30) !!}
    </div>
    <div class="top-info">
        <table class="nob">
            <tr class="nob">
                <td class="nob" rowspan="2" style="width: 40px; padding-right: 40px">
                    Универсальный передаточный документ
                </td>
                <td class="nob tc">Счет фактура №</td>
                <td class="nob top-app-info-cell">
                    <div class="borbtm top-app-info tc">{{ $order->order_num }}</div>
                </td>
                <td class="nob ot tc">
                    от</td>
                <td class="nob top-app-info-cell">
                    <div class="borbtm top-app-info tc rel">{{ stringDateRu($order->time_to_order) }} <div class="abs1">(1)</div></div>

                </td>
            </tr>
            <tr  class="nob">
                <td class="nob tc">Исправление №</td>
                <td class="nob top-app-info-cell">
                    <div class="borbtm top-app-info tc">--</div>
                </td>
                <td class="nob ot tc">от</td>
                <td class="nob top-app-info-cell">
                    <div class="borbtm top-app-info tc rel">--<div class="abs1">(1a)</div></div>
                </td>
            </tr>
        </table>
    </div>
    <div class="customers-info">
        <table class="nob">
            <tr class="nob">
                <td class="nob tc" rowspan="2" style="width: 100px; padding-right: 20px; margin-top: 100px">
                    <div class="inlineb">Статус</div><div style="margin-left: 10px" class="border inlineb"> 1 </div>
                </td>
                <td class="nob" style="width: 200px">
                    <h1 class="tdh">Продавец</h1>
                </td>

                <td class="nob" style="width: 240px">
                    <div class="borbtm top-user-info rel">ООО «ВЕРНЕР ЛОГИСТИКА РУС»<div class="abs1">(2)</div></div>
                </td>
                <td class="spacer nob"></td>
                <td class="nob" style="width: 200px">
                    <h1 class="tdh">Покупатель</h1>
                </td>
                <td class="nob" style="width: 240px">
                    <div class="borbtm top-user-info rel">
                        @if($payer->company)
                            {{$payer->company->name}}
                        @else
                            {{$payer->name}}
                        @endif
                        <div class="abs1">(6)</div></div>
                </td>
            </tr>
            <tr class="nob">

                <td class="nob" rowspan="2">
                    Адрес
                </td>
                <td class="nob" rowspan="2">
                    <div class="borbtm top-user-info rel">119620, г. Москва, ул. Богданова, 42-225<div class="abs1">(2a)</div></div>
                </td>
                <td class="spacer  nob"></td>
                <td class="nob" rowspan="2">Адрес</td>
                <td class="nob" rowspan="2">
                    <div class="borbtm top-user-info rel">{{ $payer->company_id ?  $payer->company->address : $payer->address}}<div class="abs1">(6а)</div></div>
                </td>
            </tr>
            <tr class="nob"></tr>
            <tr class="nob">
                <td class="nob" style="padding-right: 20px" rowspan="2">1 – счет-фактура и передаточный документ (акт)</td>
                <td class="nob">ИНН/КПП продавца</td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">7731622384 / 772901001<div class="abs1">(2б)</div></div>
                </td>
                <td class="spacer nob"></td>
                <td class="nob">ИНН/КПП покупателя</td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">
                        @if($payer->company_id)
                            {{$payer->company->INN}}
                        @else
                            --
                        @endif<div class="abs1">(6б)</div></div>
                </td>
            </tr>
            <tr class="nob">

                <td class="nob">Грузоотправитель и его адрес:</td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">--<div class="abs1">(3)</div></div>
                </td>
                <td class="spacer  nob"></td>
                <td class="nob">Валюта: наименование, код:</td>
                <td class="nob">
                    <div class="borbtm top-user-info  rel">Российский рубль, 643<div class="abs1">(7)</div></div>
                </td>
            </tr>
            <tr class="nob">
                <td class="nob" style="padding-right: 20px" rowspan="2">2 – передаточный документ (акт)</td>
                <td class="nob">
                    Грузополучатель и его адрес:
                </td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">--<div class="abs1">(4)</div></div>
                </td>
                <td class="spacer nob"></td>
                <td  class="nob" rowspan="2">Идентификатор государственного контракта, (5) договора (соглашения)<br> (при наличии):</td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">--<div class="abs1">(8)</div></div>
                </td>
            </tr>
            <tr class="nob">

                <td class="nob">
                    К платежно-расчетному документу №
                </td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">Счёт No {{ $order->order_num }} от {{ stringDateRu($order->time_to_order) }}<div class="abs1">(5)</div></div>
                </td>
                <td class="spacer nob"></td>
                <td class="nob">
                    <div class="borbtm top-user-info">--</div>
                </td>
            </tr>
            <tr class="nob">
                <td class="nob"></td>
                <td class="nob">
                    Документ об отгрузке
                </td>
                <td class="nob">
                    <div class="borbtm top-user-info rel">No п/п  {{ $order->order_num }} от {{ stringDateRu($order->time_to_order) }}<div class="abs1">(5a)</div></div>
                </td>
                <td class="spacer nob"></td>
                <td class="nob"></td>
                <td class="nob"></td>
            </tr>
        </table>
    </div>
    <div class="order-info">
        <table class="order-info-table">
            <tr class="ct">
                <td style="width: 100px;" class="h-td" rowspan="3">Код товара, работ, услуг</td>
                <td class="h-td" style="width: 25px;" rowspan="3">№ п/п</td>
                <td style="width: 220px" class="h-td" rowspan="3">Наименование товара (описание выполненных работ,
                    оказанных услуг),
                    имущественного права
                </td>
                <td class="h-td" style="width: 25px;" rowspan="3">Код вида товара</td>
                <td class="h-td"  colspan="2">Единица измерения</td>
                <td class="h-td" style="width: 30px;" rowspan="3">Коли- чество (объем)</td>
                <td class="h-td" style="width: 70px;" rowspan="3">Цена (тариф) за ед. изм.</td>
                <td class="h-td" style="width: 70px;" rowspan="3">Стоимость товаров (работ, услуг), имущест- венных прав без налога - всего
                </td>
                <td class="h-td" rowspan="3">Втом числе сумма акциза</td>
                <td class="h-td" rowspan="3">Налоговая ставка</td>
                <td class="h-td" rowspan="3">Сумма налога, предъявляемая
                    покупателю</td>
                <td class="h-td" style="width: 70px;" rowspan="3">Стоимость товаров (работ, услуг), имущест- венных прав
                    с налогом - всего</td>
                <td class="h-td" colspan="2">Страна происхождения</td>
                <td style="width: 50px;" class="h-td tt-sm" rowspan="3">Регистрационный номер таможенной декларации на
                    товары
                    или регистрационный
                    номер партии
                    товара,
                    подлежащего прослеживаемости</td>

            </tr>
            <tr>
                <td class="h-td" rowspan="2">код</td>
                <td class="h-td" rowspan="2">усл. обозн. (национал ьное)</td>
                <td class="h-td" rowspan="2">цифр. код</td>
                <td class="h-td" rowspan="2">краткое наиме- нование</td>
            </tr>
            <tr>

            </tr>
            <tr style="height: 10px">
                <td class="tc p0">А</td>
                <td class="tc p0">1</td>
                <td class="tc p0">1а</td>
                <td class="tc p0">1б</td>
                <td class="tc p0">2</td>
                <td class="tc p0">2а</td>
                <td class="tc p0">3</td>
                <td class="tc p0">4</td>
                <td class="tc p0">5</td>
                <td style="width: 70px;" class="tc p0">6</td>
                <td class="tc p0">7</td>
                <td class="tc p0">8</td>
                <td class="tc p0">9</td>
                <td class="tc p0">10</td>
                <td class="tc p0 ">10a</td>
                <td class="tc p0">11</td>
            </tr>
            @php
                $sum = 0.00;
                $tax = 0.00;
            @endphp
            @foreach($payment_rows as $payment_row)
                @php
                $sum += $payment_row['price'];
                @endphp
            <tr style>
                <td></td>
                <td class="tc p0">{{ $loop->index+2 }}.</td>
                <td class="str-td p0">{{ $payment_row['title'] }}</td>
                <td class="tc p0">--</td>
                <td class="tc p0">--</td>
                <td class="tc p0">--</td>
                <td class="tc p0">1</td>
                <td class="num-td p0">
                    @if( $payment_row['title'] == 'Страховка')
                        {{ $payment_row['price'] }} ₽
                    @else
                        {{ $payment_row['price'] * 0.80 }} ₽
                    @endif
                </td>
                <td class="num-td p0">
                    @if( $payment_row['title'] == 'Страховка')
                        @php
                        $tax += 0;
                        @endphp
                        {{ $payment_row['price'] }} ₽
                    @else
                        @php
                            $tax += $payment_row['price'] * 0.20;
                        @endphp
                        {{ $payment_row['price'] * 0.80 }} ₽
                    @endif</td>
                <td class="tc p0">без акциза</td>
                <td class="tc p0">
                    @if( $payment_row['title'] == 'Страховка')
                        --
                    @else
                        20%
                    @endif
                </td>
                <td class="num-td p0">
                    @if( $payment_row['title'] == 'Страховка')
                        0.00 ₽
                    @else
                        {{ $payment_row['price'] * 0.20 }} ₽
                    @endif
                </td>
                <td class="num-td p0">{{ $payment_row['price'] }} ₽</td>
                <td class="tc p0">--</td>
                <td class="tc p0">--</td>
                <td class="tc p0">--</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td class="str-td p0" colspan="6"><b>Всего к оплате</b></td>
                <td></td>
                <td  class="tc p0" colspan="2"> X </td>
                <td class="num-td p0">{{$tax}} ₽</td>
                <td class="num-td p0">{{ $sum }} ₽</td>
                <td colspan="3"></td>

            </tr>
        </table>
    </div>
    <div class="under-table">
        <table class="nob">
            <tr  class="nob">
                <td class="nob"  style="width: 90px; padding-left: 20px;" rowspan="2">Документ<br>составлен<br> на 1 листе</td>
                <td class="nob" style="width: 180px">
                    Руководитель организации
                    или иное уполномоченное лицо
                </td>
                <td class="nob" style="width: 100px">
                    <div class="borbtm under-table-input tc rel"><br> <div class="under">(подпись)</div><img class="sign" style="width: 150px" src="./images/sign_nds.png" alt=""></div>
                </td>
                <td class="nob" style="width: 100px">
                    <div class="borbtm under-table-input tc rel">Тихоненко Р. С. <div class="under">(ф.и.о)</div></div>
                </td>
                <td class="nob" class="spacer"></td>
                <td class="nob" style="width: 150px">
                    Главный бухгалтер или
                    иное уполномоченное лицо
                </td>
                <td class="nob" style="width: 100px">
                    <div class="borbtm under-table-input tc rel"><br> <div class="under">(подпись)</div> <img class="sign" style="width: 150px" src="./images/sign_nds.png" alt=""></div>
                </td>
                <td class="nob" style="width: 100px">
                    <div  class="borbtm under-table-input tc rel">Тихоненко Р. С.<div class="under">(ф.и.о)</div></div>
                </td>

            </tr>
{{--            <tr class="nob">--}}
{{--                <td class="nob"></td>--}}
{{--                <td class="nob"></td>--}}
{{--            </tr>--}}
            <tr class="nob">
                <td class="nob">
                    Индивидуальный предприниматель
                    или иное уполномоченное лицо
                </td>
                <td class="nob">
                    <div class="borbtm under-table-input tc rel"><br> <div class="under">(подпись)</div></div>
                </td>
                <td class="nob" colspan="2" style="width: 100px">
                    <div class="borbtm under-table-input tc rel"><br> <div class="under">(ф.и.о)</div></div>
                </td>
                <td class="nob" colspan="3">
                    <div class="borbtm under-table-input tc rel"><br> <div class="under" style="width: 350px">(реквизиты свидетельства о государственной регистрации индивидуального предпринимателя)</div></div>
                </td>
            </tr>
        </table>
    </div>
    <div class="osnovanie" st>
        <table class="nob">
            <tr class="nob">
                <td class="nob" style="padding: 3px 0;">
                    Основание передачи (сдачи) / получения (приемки)
                </td>
                <td class="nob" style="width: 700px">
                    <div class="borbtm under-table-input rel">
                        Договор-оферта, размещенный на сайте Экспедитора от 07.07.2021
                        <div class="abs1">[8]</div>
                        <div class="under">(договор, доверенность и др.)</div>
                    </div>
                </td>
            </tr>
            <tr class="nob"  >
                <td class="nob" style="padding: 4px 0;">
                    Данные о транспортировке и грузе
                </td>
                <td class="nob">
                    <div class="borbtm under-table-input rel">
                        Поручение экспедитору / экспедиторская расписка No {{ $order->order_num }}
                        <div class="abs1">[9]</div>
                        <div class="under" style="width: 900px; left: 70%;">(транспортная накладная, поручение экспедитору, экспедиторская / складская расписка и др. / масса нетто/ брутто груза, если не приведены ссылки на транспортные документы, содержащие эти сведения)</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="footer" style="margin-top: 10px">
        <table class="nob">
            <tr class="nob">
                <td  style="padding-right: 20px; border-style: none; border-right: solid; ">
                    <table class="nob">
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Товар (груз) передал / услуги, результаты работ, права сдал:
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    Бухгалтер
                                    <div class="under">(должность)</div>
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="under">(подпись)</div>
                                    <img class="sign" style="width: 150px" src="./images/sign_nds.png" alt="">
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    Тихоненко Р. С.
                                    <div class="abs2">[10]</div>
                                    <div class="under">(ф.и.о)</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="2">
                                Дата отгрузки, передачи (сдачи):
                            </td>
                            <td class="nob footer-inp-cell" >
                                <div class="borbtm under-table-input tc rel">
                                    {{ stringDateRu($order->time_to_order) }}
                                    <div class="abs2">[11]</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Иные сведения об отгрузке, передаче
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="abs2">[12]</div>
                                    <div class="under" style="width: 400px">(ссылки на неотъемлемые приложения, сопутствующие документы, иные документы и т.п.)</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Ответственный за правильность оформления факта хозяйственной жизни
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    Бухгалтер
                                    <div class="under">(должность)</div>
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="under">(подпись)</div>
                                    <img class="sign" style="width: 150px" src="./images/sign_nds.png" alt="">
                                    <img class="stamp" src="./images/stamp_nds.png" alt="">
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    Тихоненко Р.С.
                                    <div class="abs2">[13]</div>
                                    <div class="under">(ф.и.о)</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Наименование экономического субъекта – составителя документа (в т.ч. комиссионера / агента)
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                <div class="borbtm under-table-input tc rel">
                                    ООО «ВЕРНЕР ЛОГИСТИКА РУС», ИНН 7731622384, КПП 772901001
                                    <div class="abs2">[14]</div>
                                    <div class="under" style="width: 400px;">(может не заполняться при проставлении печати в М.П., может быть указан ИНН / КПП)</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="nob" style="padding-left: 10px; padding-right: 20px">
                    <table class="nob">
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Товар (груз) получил / услуги, результаты работ, права принял
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="under">(должность)</div>
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="under">(подпись)</div>
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="abs2">[15]</div>
                                    <div class="under">(ф.и.о)</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="2">
                                Дата получения (приемки)
                            </td>
                            <td class="nob footer-inp-cell" >
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="abs2">[16]</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Иные сведения о получении, приемке
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="abs2">[17]</div>
                                    <div class="under" style="width: 400px">(информация о наличии/отсутствии претензии; ссылки на неотъемлемые приложения, и другие документы и т.п.)</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Ответственный за правильность оформления факта хозяйственной жизни
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="under">(должность)</div>
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="under">(подпись)</div>
                                </div>
                            </td>
                            <td class="nob footer-inp-cell">
                                <div class="borbtm under-table-input tc rel">
                                    <br>
                                    <div class="abs2">[18]</div>
                                    <div class="under">(ф.и.о)</div>
                                </div>
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                Наименование экономического субъекта – составителя документа
                            </td>
                        </tr>
                        <tr class="nob footer-inp-row">
                            <td class="nob footer-inp-cell" colspan="3">
                                <div class="borbtm under-table-input  tc rel">
                                    @if($payer->company)
                                        {{$payer->company->name}}
                                    @else
                                        {{$payer->name}}
                                    @endif
                                        , ИНН
                                        @if($payer->company_id)
                                            {{$payer->company->INN}}
                                        @else
                                            --
                                        @endif
                                    <div class="abs2">[19]</div>
                                    <div class="under" style="width: 400px">(может не заполняться при проставлении печати в М.П., может быть указан ИНН / КПП)</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
