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
            background-color: #0f3460;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #0f3460;
            color: #ffffff;
            padding: 9px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            padding: 8px 12px;
            border-bottom: 1px solid #e8e8e8;
        }

        tr:nth-child(even) td { background-color: #f7f8fc; }

        .badge-code {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
        }

        .badge-active {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
        }

        .badge-inactive {
            background-color: #fce4ec;
            color: #c62828;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
        }

        .badge-profile {
            background-color: #f3e5f5;
            color: #6a1b9a;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
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
    <h1>Reporte de Usuarios</h1>
    <p>{{ config('app.name') }} — Sistema de Administración</p>
</div>

<div class="meta">
    <span>Generado: {{ now()->format('d/m/Y H:i:s') }}</span>
    <span>Total: {{ count($users) }}</span>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Perfil</th>
            <th>Estado</th>
            <th>Registro</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><span class="badge-code">{{ $user->code }}</span></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                {{ $user->phone_code ?? '' }}
                {{ $user->phone ?? '—' }}
            </td>
            <td>
                @if($user->profile)
                    <span class="badge-profile">{{ $user->profile->name }}</span>
                @else
                    <span style="color:#999">Sin perfil</span>
                @endif
            </td>
            <td>
                @if($user->is_active)
                    <span class="badge-active">Activo</span>
                @else
                    <span class="badge-inactive">Inactivo</span>
                @endif
            </td>
            <td>{{ $user->created_at?->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center; color:#999; padding:20px;">
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