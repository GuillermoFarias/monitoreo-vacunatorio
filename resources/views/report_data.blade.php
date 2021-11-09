<html>

<head>
    @include('bootstrap')
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="33%">Temperatura</th>
                <th width="33%">Tipo de alerta</td>
                <th width="34%">Fecha / Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
            <tr>
                <td>{{ $entry->temperatura }}º</td>
                <td>{{ $entry->tipo_alerta }}</td>
                <td>{{ $entry->fecha_hora }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
