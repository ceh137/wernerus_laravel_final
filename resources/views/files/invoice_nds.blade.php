<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Приложение №1</title>
    <meta name="author" content="b7" />
    <meta name="title" content="Приложение №1" />
    <meta name="company" content="b7" />
    <link rel="stylesheet" href="./pdfs/invoice.css">
</head>

<body>
<div class="content">
    <div class="barcode-container">
        {!! DNS1D::getBarcodeHTML( $order->order_num, 'C39', 1.7, 50) !!}
        <div class="barcode-text tc">{{ $order->order_num }}</div>
    </div>
    <div class="credentials-table-container">
        <table class="credentials-table">
            <tr class="nobb">
                <td colspan="2" class="nobb">АЛЬФА-БАНК (АО), ДО «РУМЯНЦЕВО» г. Москва</td>
                <td>БИК</td>
                <td>044525593</td>

            </tr>
            <tr class="nobt">
                <td colspan="2"  class="nobt  sm">Банк получателя</td>
                <td>Сч. №</td>
                <td>30101810200000000593</td>

            </tr>
            <tr>
                <td>ИНН 7731622384</td>
                <td>КПП 772901001</td>
                <td rowspan="3">Сч. №</td>
                <td rowspan="3">40702810402010000130</td>
            </tr>
            <tr class="nobb">
                <td colspan="2" class="nobb">ООО «ВЕРНЕР ЛОГИСТИКА РУС»</td>

            </tr>
            <tr class="nobt">

                <td colspan="2" class="nobt sm ">Получатель</td>

            </tr>
        </table>
    </div>
    <div>
        <h1 class="header">Счёт на оплату № {{ $order->order_num }} от {{ stringDateRu($order->time_to_order) }}</h1>
    </div>
    <hr class="divider">
    <div class="customers">
        <table class="nob ">
            <tr class="nob">
                <td class="nob customer-h-cell">
                    <h1 class="customer-h">
                        Поставщик:
                    </h1>
                </td>
                <td class="nob customer-info">
                    ООО «ВЕРНЕР ЛОГИСТИКА РУС», ИНН: 7731622384, КПП: 772901001,<br>
                    119620, г. Москва, ул. Богданова, 42-225
                </td>
            </tr>
            <tr class="nob">
                <td class="nob customer-h-cell">
                    <h1 class="customer-h">
                        Покупатель:

                    </h1>
                </td>
                <td class="nob customer-info">
                    {{ $payer->company_id ?  $payer->company->name : $payer->name}}, ИНН: {{ $payer->company_id ?  $payer->company->INN : '--'}} <br>
                    {{ $payer->company_id ?  $payer->company->address : $payer->address}}
                </td>
            </tr>
        </table>
    </div>
    <div class="info">
        <table class="info-table nob">
            <tr>
                <td class="th">
                    <h1 class="th">№</h1>
                </td>
                <td  class="th">
                    <h1 class="th">Товары (работы, услуги)</h1>
                </td>
                <td  class="th">
                    <h1 class="th">Кол-во</h1>
                </td>
                <td class="th">
                    <h1 class="th">Ед.</h1>

                </td>
                <td  class="th">
                    <h1 class="th">Цена</h1>
                </td>
                <td class="th">
                    <h1 class="th">% НДС</h1>

                </td>
                <td class="th">
                    <h1 class="th">НДС</h1>
                </td>
                <td class="th">
                    <h1 class="th">Сумма</h1>
                </td>
            </tr>
            @php
                $sum = 0.00;
                $tax = 0.00;
            @endphp
            @foreach($payment_rows  as $payment_row)
                @php
                    $sum += $payment_row['price'];
                @endphp
            <tr>
                <td class="th"><h1 class="th">{{ $loop->index+1 }}</h1></td>
                <td>{{$payment_row['title']}}</td>
                <td class="tc">1</td>
                <td class="tc">услуга</td>
                <td>
                    @if( $payment_row['title'] == 'Страховка')
                        {{ $payment_row['price'] }} ₽
                        @php
                            $tax += 0;
                        @endphp
                    @else
                        {{ $payment_row['price'] * 0.80 }} ₽
                        @php
                            $tax += $payment_row['price'] * 0.20;
                        @endphp
                    @endif
                </td>
                <td>
                    @if( $payment_row['title'] == 'Страховка')
                        0 %
                    @else
                        20 %
                    @endif
                        </td>
                <td>
                    @if( $payment_row['title'] == 'Страховка')
                        0 ₽
                    @else
                        {{ $payment_row['price'] * 0.20 }} ₽
                    @endif </td>
                <td>{{$payment_row['price']}} ₽</td>
            </tr>
            @endforeach
            <tr class="nob">

                <td colspan="6" class="right nob">Итого:</td>
                <td class="th"><h1 class="th">{{$tax}} ₽</h1></td>
                <td class="th"><h1 class="th">{{$sum}} ₽</h1></td>
            </tr>

        </table>
    </div>
    <div class="numbers">
        <div class="total-num">Всего 4 наименования на общую сумму {{$sum}} ₽</div>
        <div class="total-words"><i>({{ num2str($sum) }})</i></div>
    </div>
    <hr class="divider">
    <div class="legal inlineb">
        <div class="inlineb">
            <div class="text inlineb">Генеральный директор</div>
            <div class="borbtm under-table-input inlineb rel" style="width: 300px"><br><img class="sign" style="right: 0;" src="./images/sign_nds.png" alt=""></div>
            <div class="text inlineb">(Тихоненко Р.С.)</div>
        </div>
        <div class="inlineb" style="margin-top: 20px">
            <div class="text inlineb">Бухгалтер</div>
            <div class="borbtm under-table-input inlineb rel" style="width: 300px"><br><img class="stamp" src="./images/stamp_nds.png" alt=""></div>

        </div>

    </div>
    <div class="qr-text-top">
        Оплатите быстрее с помощью QR-кода
    </div>
    <div class="qr-code">
        {!!  DNS2D::getBarcodeHTML('ST00012|Name=ООО "ВЕРНЕР ЛОГИСТИКА РУС"|PersonalAcc=40702810402010000130|BankName=АЛЬФА-БАНК (АО), ДО «РУМЯНЦЕВО» г. Москва|BIC=044525593|CorrespAcc=30101810200000000593|LastName=|FirstName=|Purpose=Счёт на оплату № '.$order->order_num.' от '.stringDateRu($order->time_to_order).'|PayeeINN=7731622384|PayeeKPP=772901001|PayerAddress=-|Sum='.$sum*100, 'QRCODE', 3, 3)  !!}
    </div>
    <div class="qr-text-btm"><i>Спасибо, что Вы стали нашим Партнёром! Ориентировочно, на этой перевозке Ваша экономия составила 100 ₽. Экономия может быть больше, если возить чаще.</i></div>
</div>
</body>


