<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a2e;
        }

        .header {
            background-color: #1a1a2e;
            color: #ffffff;
            padding: 18px 24px;
            margin-bottom: 20px;
        }

        .header h1 { font-size: 18px; margin-bottom: 4px; }
        .header p  { font-size: 10px; opacity: 0.75; }

        .meta {
            display: flex;
            justify-content: space-between;
            padding: 0 24px 14px;
            font-size: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            padding: 0 24px;
        }

        th {
            background-color: #16213e;
            color: #ffffff;
            padding: 9px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 8px 12px;
            border-bottom: 1px solid #e8e8e8;
            color: #333;
        }

        tr:nth-child(even) td { background-color: #f7f8fc; }
        tr:last-child td      { border-bottom: none; }

        .badge {
            background-color: #e8f4fd;
            color: #1565c0;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            padding: 10px 24px;
            border-top: 1px solid #e0e0e0;
            font-size: 9px;
            color: #999;
            text-align: right;
        }

        .total-row {
            margin: 10px 24px 0;
            text-align: right;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Reporte de Productos</h1>
    <p>{{ config('app.name') }} — Sistema de Administración</p>
</div>

<div class="meta">
    <span>Generado: {{ now()->format('d/m/Y H:i:s') }}</span>
    <span>Total de registros: {{ count($products) }}</span>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Marca</th>
            <th>Precio</th>
            <th>Fecha de creación</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><span class="badge">{{ $product->code }}</span></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->brand }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>{{ $product->created_at?->format('d/m/Y H:i') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center; color:#999; padding:20px;">
                Sin registros
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="total-row">
    Precio promedio:
    ${{ count($products) > 0 ? number_format($products->avg('price'), 2) : '0.00' }}
</div>

<div class="footer">
    Documento generado automáticamente — {{ config('app.name') }}
</div>

</body>
</html>