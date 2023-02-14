<table>
    <thead>
    <tr>
        <th style="width: 5px;">№</th>
        <th style="width: 20px;">Название</th>
        <th style="width: 30px;">Автор заявки</th>
        <th style="width: 30px;">Дата и время создания</th>
        <th style="width: 30px;">Исполнитель</th>
        <th style="width: 30px;">Дата исполнения</th>
        <th style="width: 20px;">Статус</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['list'] as $task)
        @php ($author = (new \App\Services\KeyCloakService())->getKeyCloakUser($task->creator_hash))
        @php ($executor = (new \App\Services\KeyCloakService())->getKeyCloakUser($task->executor_hash))
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $author->firstName ?? null }} {{ $author->lastName ?? null }}</td>
            <td>{{ $task->created_at->format(\App\Reference\Constants::DATE_TIME_FORMAT) }}</td>
            <td>{{ $executor->firstName ?? null }} {{ $executor->lastName ?? null }}</td>
            <td>
                {{
                    $task->status_id === \App\Reference\TasksConstants::STATUS_DONE ?
                    $task->updated_at->format(\App\Reference\Constants::DATE_TIME_FORMAT) :
                    null
                }}
            </td>
            <td>{{ \App\Reference\TasksConstants::TASK_STATUSES[$task->status_id] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
