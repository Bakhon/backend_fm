<table>
    <thead>
    <tr>
        <th style="width: 40px;">ID</th>
        <th style="width: 40px;">Семейства</th>
        <th style="width: 40px;">Версия</th>
        <th style="width: 40px;">Раздел</th>
        <th style="width: 40px;">Категория</th>
        <th style="width: 40px;">Количество загрузок</th>
    </tr>
    </thead>
    <tbody>
    @for ($i=0; $i < sizeof($report); $i++)
    <tr>
            <td style="text-align: center">{{ $report[$i]->id }}</td>
            <td>{{ $report[$i]->original_name }}</td>
            <td style="text-align: left;">{{ $report[$i]->version }}</td>
            <td style="text-align: left;">{{ $report[$i]->name }}</td>
            <td>{{ $report[$i]->full_name }}</td>
            <td>{{ $report[$i]->count }}</td>
        </tr>
    @endfor 
    </tbody>
</table>

