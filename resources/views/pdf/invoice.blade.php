<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura_{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .company-info {
            width: 60%;
            float: left;
        }

        .invoice-info {
            width: 35%;
            float: right;
            text-align: right;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .title {
            font-size: 18px;
            font-bold;
            margin-bottom: 5px;
        }

        .clear {
            clear: both;
        }

        .client-info {
            width: 100%;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .items-table td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .totals {
            width: 40%;
            float: right;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px;
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="company-info">
            <div class="title">{{ $settings->name }}</div>
            <div>RIF: {{ $settings->rif }}</div>
            <div>{{ $settings->address }}</div>
            <div>Teléfono: {{ $settings->phone }}</div>
            <div>Email: {{ $settings->email }}</div>
        </div>
        <div class="invoice-info">
            <div style="font-size: 16px; font-weight: bold; color: red;">FACTURA</div>
            <div>N° de Control: 00-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div>Fecha: {{ $order->created_at->format('d/m/Y') }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="client-info">
        <div class="text-bold">DATOS DEL CLIENTE:</div>
        <div>Nombre: {{ $order->customer_name }}</div>
        <div>RIF/C.I.: {{ $order->customer_rif }}</div>
        <div>Dirección: {{ $order->address }}</div>
        <div>Email: {{ $order->customer_email }}</div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 10%;">CANT.</th>
                <th style="width: 50%;">DESCRIPCIÓN</th>
                <th style="width: 20%;">P. UNIT (BS)</th>
                <th style="width: 20%;">TOTAL (BS)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->name }}</td>
                    <td style="text-align: right;">{{ number_format($item->price * $item->exchange_rate, 2, ',', '.') }}
                    </td>
                    <td style="text-align: right;">{{ number_format($item->total_bs, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table class="totals-table">
            <tr>
                <td>SUBTOTAL:</td>
                <td class="text-bold">Bs. {{ number_format($order->total_bs, 2, ',', '.') }}</td>
            </tr>
            @if($order->taxable_base > 0)
                <tr>
                    <td>BASE IMPONIBLE:</td>
                    <td>Bs. {{ number_format($order->taxable_base, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>IVA ({{ number_format($order->items->first()?->tax_rate ?? 16, 0) }}%):</td>
                    <td>Bs. {{ number_format($order->tax_amount, 2, ',', '.') }}</td>
                </tr>
            @else
                <tr>
                    <td>EXENTO:</td>
                    <td>Bs. {{ number_format($order->total_bs, 2, ',', '.') }}</td>
                </tr>
            @endif
            <tr style="font-size: 14px; background-color: #f2f2f2;">
                <td class="text-bold">TOTAL A PAGAR:</td>
                <td class="text-bold">Bs. {{ number_format($order->total_bs, 2, ',', '.') }}</td>
            </tr>
        </table>
        <div style="margin-top: 10px; font-size: 10px; text-align: right;">
            Tasa de cambio: Bs. {{ number_format($order->exchange_rate, 2, ',', '.') }}
        </div>
    </div>
    <div class="clear"></div>

    <div class="footer">
        Esta factura es emitida según las regulaciones del SENIAT. <br>
        Gracias por su compra.
    </div>

</body>

</html>