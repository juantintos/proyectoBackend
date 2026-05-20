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
            background-color: #1b5e20;
            color: #ffffff;
            padding: 18px 24px;
            margin-bottom: 20px;
        }

        .header h1 { font-size: 18px; margin-bottom: 4px; }
        .header p  { font-size: 10px; opacity: 0.75; }

        .meta {
            padding: 0 24px 14px;
            font-size: 10px;
            color: #555;
            display: flex;
            justify-content: space-between;
        }

        table { width: 100%; border-collapse: collapse; }

        th {
            background-color: #1b5e20;
            color: #ffffff;
            padding: 9px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            padding: 8px 12px;
            border-bottom: 1px solid #e8e8e8;
            vertical-align: top;
        }

        tr:nth-child(even) td { background-color: #f7f8fc; }

        .badge-code {
            background-color: #e8f5e9;
            color: #1b5e20;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
        }

        .badge-perm {
            background-color: #fff8e1;
            color: #e65100;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 9px;
            margin-right: 3px;
        }

        .footer {
            margin-top: 20px;
            padding: 10px 24px;
            border-top: 1px solid #e0e0e0;
            font-size: 9px;
            color: #999;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Reporte de Perfiles</h1>
    <p>{{ config('app.name') }} — Sistema de Administración</p>
</div>

<div class="meta">
    <span>Generado: {{ now()->format('d/m/Y H:i:s') }}</span>
    <span>Total: {{ count($profiles) }}</span>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Permisos</th>
            <th>Usuarios</th>
            <th>Registro</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($profiles as $index => $profile)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><span class="badge-code">{{ $profile->code }}</span></td>
            <td>{{ $profile->name }}</td>
            <td>
                @foreach($profile->permissions ?? [] as $perm)
                    <span class="badge-perm">{{ $perm }}</span>
                @endforeach
            </td>
            <td style="text-align:center;">
                {{ $profile->users_count ?? 0 }}
            </td>
            <td>{{ $profile->created_at?->format('d/m/Y') }}</td>
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

<div class="footer">
    Documento generado automáticamente — {{ config('app.name') }}
</div>

</body>
</html>