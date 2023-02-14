<table>
    <thead>
    <tr>
        <th style="width: 40px;">Название</th>
        <th style="width: 40px;">Автор</th>
        <th style="width: 40px;">Семейства</th>
        <th style="width: 40px;">Ошибок</th>
        <th style="width: 40px;">Дата и время создания</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $report['name'] }}</td>
            <td>{{ $report['author'] }}</td>
            <td style="text-align: left;">{{ $report['families_count'] }}</td>
            <td style="text-align: left;">{{ $report['family_errors'] }}</td>
            <td>{{ $report['created_at'] }}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th style="width: 40px;">Название</th>
        <th style="width: 40px;">Статус</th>
        <th style="width: 40px;">guid</th>
    </tr>
    </thead>
    <tbody>
    @foreach($report['reportFamilies'] as $family)
        <tr>
            <td>{{ $family->name }}</td>
            <td>{{ \App\Reference\ReportConstants::REPORT_STATUSES[$family->status_id] }}</td>
            <td>{{ $family->guid }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
