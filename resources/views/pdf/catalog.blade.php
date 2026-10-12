<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Catálogo Amuletos Mary</title>
    <style>
        @page { margin: 28pt 34pt 24pt 34pt; }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; background: #f2e4d4; }
        body { font-family: 'DejaVu Serif', serif; color: #2b1a1f; font-size: 10pt; }

        /* ---------- Encabezado ---------- */
        .header { width: 100%; border-collapse: collapse; border-bottom: 1.5pt solid #5a1228; margin-bottom: 14pt; }
        .header td { vertical-align: middle; padding-bottom: 8pt; }
        .brand { font-size: 24pt; font-weight: bold; color: #5a1228; letter-spacing: 1pt; }
        .tagline { font-family: 'DejaVu Sans', sans-serif; font-style: italic; font-size: 8pt; color: #4a7a1c; letter-spacing: 1.2pt; text-transform: uppercase; margin-top: 3pt; }
        .pill { background: #5a1228; color: #fff; font-family: 'DejaVu Sans', sans-serif; font-weight: bold; font-size: 7.5pt; letter-spacing: 1.4pt; padding: 7pt 14pt; border-radius: 14pt; text-align: center; text-transform: uppercase; }

        /* ---------- Página y filas de producto ---------- */
        .page { page-break-after: always; }
        .page:last-child { page-break-after: auto; }

        .product { width: 100%; border-collapse: collapse; height: 215pt; page-break-inside: avoid; }
        .product td { vertical-align: middle; }
        .col-img { width: 46%; padding-right: 18pt; }
        .col-txt { width: 54%; }

        .photo { width: 100%; height: 180pt; border: 3pt solid #fff; background: #e8d3bd; }
        .photo-empty { width: 100%; height: 180pt; background: #e8d3bd; color: #a07f6a; text-align: center; font-size: 9pt; line-height: 180pt; }

        .eyebrow { font-family: 'DejaVu Sans', sans-serif; font-weight: bold; font-size: 7.5pt; letter-spacing: 2pt; color: #4a7a1c; text-transform: uppercase; }
        .title { font-size: 17pt; font-weight: bold; color: #5a1228; line-height: 1.15; margin: 4pt 0 5pt 0; }
        .subtitle { font-style: italic; font-size: 9.5pt; color: #6b7a99; padding-bottom: 5pt; border-bottom: .5pt solid #c9b8b0; margin-bottom: 8pt; }
        .label { font-family: 'DejaVu Sans', sans-serif; font-weight: bold; font-size: 8pt; letter-spacing: 1.2pt; color: #5a1228; text-transform: uppercase; margin: 6pt 0 5pt 0; }
        .chip { display: inline-block; border: 1pt solid #5a1228; border-radius: 4pt; background: #fff; color: #5a1228; font-family: 'DejaVu Sans', sans-serif; font-weight: bold; font-size: 7.5pt; padding: 3pt 7pt; margin: 0 4pt 4pt 0; }
        .desc { font-size: 9pt; line-height: 1.45; color: #2b1a1f; }
        .price { margin-top: 8pt; font-family: 'DejaVu Sans', sans-serif; font-weight: bold; font-size: 11pt; color: #4a7a1c; }
        .price small { font-weight: normal; color: #6b7a99; font-size: 8pt; }
        .old { text-decoration: line-through; color: #a07f6a; font-weight: normal; font-size: 9pt; margin-left: 4pt; }
        .soldout { font-family: 'DejaVu Sans', sans-serif; font-size: 7.5pt; color: #fff; background: #a07f6a; padding: 2pt 6pt; border-radius: 3pt; }

        .footer { text-align: center; font-family: 'DejaVu Sans', sans-serif; font-size: 7pt; color: #a07f6a; letter-spacing: 1pt; margin-top: 4pt; }
    </style>
</head>
<body>

@foreach ($products->chunk(3) as $pageIndex => $chunk)
    <div class="page">

        {{-- Encabezado repetido en cada página --}}
        <table class="header">
            <tr>
                <td>
                    <div class="brand">AMULETOS MARY</div>
                    <div class="tagline">Transforma tu energía &bull; Bisutería holística</div>
                </td>
                <td style="width: 190pt;">
                    <div class="pill">Colección Piedras Sagradas</div>
                </td>
            </tr>
        </table>

        @foreach ($chunk as $product)
            <table class="product">
                <tr>
                    <td class="col-img">
                        @if (!empty($images[$product->id]))
                            <img class="photo" src="{{ $images[$product->id] }}" alt="{{ $product->name }}">
                        @else
                            <div class="photo-empty">Sin imagen</div>
                        @endif
                    </td>

                    <td class="col-txt">
                        <div class="eyebrow">{{ $product->category?->name ?? 'Pulsera intencionada' }}</div>
                        <div class="title">{{ $product->name }}</div>

                        @php
                            $subtitle = $product->landing_subheadline ?: $product->meta_description;
                        @endphp
                        @if ($subtitle)
                            <div class="subtitle">{{ \Illuminate\Support\Str::limit($subtitle, 90) }}</div>
                        @endif

                        @if ($product->stones->isNotEmpty())
                            <div class="label">Piedras naturales</div>
                            <div>
                                @foreach ($product->stones as $stone)
                                    <span class="chip">{{ $stone->name }}</span>
                                @endforeach
                            </div>
                        @endif


                        <div class="price">
                            ${{ number_format($product->price, 2) }}
                            @if ($product->hasDiscount())
                                <span class="old">${{ number_format($product->compare_price, 2) }}</span>
                            @endif
                            @if ($product->stock <= 0)
                                &nbsp;<span class="soldout">AGOTADO</span>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        @endforeach

        <div class="footer">Amuletos Mary &mdash; Catálogo {{ now()->format('d/m/Y') }} &mdash; Página {{ $pageIndex + 1 }}</div>
    </div>
@endforeach

</body>
</html>