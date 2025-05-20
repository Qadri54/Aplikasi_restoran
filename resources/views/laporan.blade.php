<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Receipt</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                width: 300px;
                margin: auto;
                font-size: 12px;
            }

            .center {
                text-align: center;
            }

            .bold {
                font-weight: bold;
            }

            .line {
                border-top: 1px dashed #000;
                margin: 10px 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td {
                padding: 4px 0;
            }

            .right {
                text-align: right;
            }

            .total {
                font-weight: bold;
                font-size: 14px;
            }

            .thank-you {
                margin-top: 20px;
                text-align: center;
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <div class="center">******************************</div>
        <div class="center bold">RECEIPT</div>
        <div class="center bold">COMPANY NAME</div>

        <table>
            <thead>
                <tr class="bold">
                    <td>Description</td>
                    <td class="right">Qty</td>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index =>$item)
                    <tr>
                        <td>{{ $item }}</td>
                        <td class="right">{{ $qty[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>
        <table>
            <tr>
                <td class="bold">Meja:</td>
                <td class="right">{{ $nomor_meja }}</td>
            </tr>
            
            <tr>
                <td class="total">TOTAL ITEM</td>
                <td class="right">{{ $total_qty }}</td>
            </tr>

            <tr>
                <td class="total">TOTAL Bayar</td>
                <td class="right">{{  $final_amount }}</td>
            </tr>
        </table>


        <div class="line"></div>

        <div class="thank-you">THANK YOU</div>
        <div class="center">******************************</div>
    </body>

</html>