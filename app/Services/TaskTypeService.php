<?php


namespace App\Services;


use App\Http\Requests\TaskTypeRequest;
use App\Http\Requests\TaskTypeSearchRequest;
use App\Http\Resources\TaskTypeResource;
use App\Models\TaskType;
use App\Reference\Constants;
use Illuminate\Support\Facades\Response;

class TaskTypeService extends Service
{
    /**
     * @param TaskTypeSearchRequest $request
     * @return array
     */
    public function _list(TaskTypeSearchRequest $request)
    {
        $query = TaskType::where([]);

        $query->where(function ($query) use ($request) {
            $query->orWhere('title', 'like', '%' . $request->search . '%')
                ->orWhere('key', 'like', '%' . $request->search . '%');
        });

        $queryWithoutLimit = clone $query;

        $query->limit($request->limit);

        return [
            'list' => TaskTypeResource::collection($query->get()),
            'listCount' => $queryWithoutLimit->count(),
        ];
    }

    /**
     * @param TaskType $taskType
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function show(TaskType $taskType)
    {
        return $taskType;
    }

    /**
     * @param TaskType $taskType
     * @param TaskTypeRequest $request
     * @return TaskType
     */
    public function save(TaskType $taskType, TaskTypeRequest $request)
    {
        if (!$taskType->fill($request))
            $this->exceptionResponse(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_BAD_REQUEST);
        return $taskType;
    }


    /**
     * @param $id
     * @throws \Exception
     */
    public function delete(TaskType $taskType)
    {
        if (!$taskType->delete())
            $this->exceptionResponse(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
