<table>
    <thead>
    <tr>
        <th style="width: 40px;">ID</th>
        <th style="width: 40px;">Семейства</th>
        <th style="width: 40px;">Версия</th>
        <th style="width: 40px;">Раздел</th>
        <th style="width: 40px;">Категория</th>
        <th style="width: 40px;">Пользователь</th>
        <th style="width: 40px;">Email</th>
        <th style="width: 40px;">Дата загрузки</th>
        <th style="width: 40px;">Количество загрузок</th>
    </tr>
    </thead>
    <tbody>
    @for ($i=0; $i < sizeof($report); $i++)
    @php ($author = (new \App\Services\KeyCloakService())->getKeyCloakUser($report[$i]->user_hash))
    <tr>
            <td style="text-align: center">{{ $report[$i]->id }}</td>
            <td>{{ $report[$i]->original_name }}</td>
            <td style="text-align: left;">{{ $report[$i]->version }}</td>
            <td style="text-align: left;">{{ $report[$i]->name }}</td>
            <td>{{ $report[$i]->full_name  }}</td>
            <td>{{ $author->firstName ?? null }} {{ $author->lastName ?? null }}</td>
            <td>{{ $author->email ?? null }}</td>
            <td>{{ $report[$i]->date_download }}</td>
            <td>1</td>
        </tr>
    @endfor 
    </tbody>
</table>

