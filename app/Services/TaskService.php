<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskSearchRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Reference\Constants;
use App\Reference\TasksConstants;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Support\Facades\Auth;


/**
 * Class TaskService
 * @package App\Services
 */
class TaskService extends Service
{

    /**
     * Show tasks list with search
     *
     * @param TaskSearchRequest $request
     * @return array
     */
    public function _list(TaskSearchRequest $request): array
    {
        $query = Task::where([]);

        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status_id) {
            $query->where(['status_id' => $request->status_id]);
        }

        if ($request->date_created_from) {
            $query->where('created_at', '>=', Carbon::parse($request->date_created_from));
        }

        if ($request->date_created_to) {
            $query->where('created_at', '<=', Carbon::parse($request->date_created_to)->addDay());
        }

        if ($request->date_updated_from) {
            $query->where('updated_at', '>=', Carbon::parse($request->date_updated_from));
        }

        if ($request->date_updated_to) {
            $query->where('updated_at', '<', Carbon::parse($request->date_updated_to)->addDay());
        }

        if ($request->user_hash) {
            $query->where(['creator_hash' => $request->user_hash]);
        }

        $queryCount = $query->count();

        if (!$request->without_limit) {
            $query->limit($request->limit)
                ->offset($request->offset);
        }

        $query->orderBy($request->order_by ?? 'created_at', $request->direction ?? 'desc');

        return [
            'list' => TaskResource::collection($query->get()),
            'listCount' => $queryCount,
        ];
    }

    /**
     * Show single task
     * @param Task $task
     * @return Task
     */
    public function show(Task $task): Task
    {
        return $task;
    }

    /**
     * Create task
     *
     * @param Task $task
     * @param TaskRequest $request
     * @return Task
     * @throws Throwable
     */
    public function create(Task $task, TaskRequest $request): Task
    {
        $task->title = $request->title;
        $task->content = $request->content;
        $task->creator_hash = $this->getUser()->sub;
        $task->status_id = TasksConstants::STATUS_NEW;

        if (!$task->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $task;
    }

    /**
     * Update task
     *
     * @param Task $task
     * @param TaskUpdateRequest $request
     * @return Task
     * @throws Throwable
     */
    public function update(Task $task, TaskUpdateRequest $request): Task
    {
        if ($task->status_id === TasksConstants::STATUS_DONE) {
            throw new ApiException(TasksConstants::ERROR_TASK_ALREADY_DONE, Response::HTTP_BAD_REQUEST);
        }

        if ($task->status_id === TasksConstants::STATUS_REJECTED) {
            throw new ApiException(TasksConstants::ERROR_TASK_ALREADY_REJECTED, Response::HTTP_BAD_REQUEST);
        }

        if ($request->status_id === TasksConstants::STATUS_IN_PROCESS) {

            if ($task->executor_hash && $task->executor_hash !== $this->getUser()->sub) {
                throw new ApiException(Constants::ERROR_USER_HAS_NO_PERMISSION, Response::HTTP_BAD_REQUEST);
            }

            if (!$task->executor_hash) {
                $task->executor_hash = $this->getUser()->sub;
            }
        }

        if ($request->executor_hash) {
            if ($task->executor_hash && $task->executor_hash !== $request->executor_hash) {
                throw new ApiException(TasksConstants::ERROR_EXECUTOR_ALREADY_SET, Response::HTTP_BAD_REQUEST);
            }
        }

        if ($request->status_id) {
            $task->status_id = $request->status_id;
        }

        if ($request->comment) {
            $task->comment = $request->comment;
        }

        if ($request->executor_hash) {
            $task->executor_hash = $request->executor_hash;
        }

        if (!$task->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $task;
    }

    /**
     * Get task users from keyCloak
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function creators(): AnonymousResourceCollection
    {
        $authors = Task::select(['creator_hash'])->groupBy('creator_hash')->get();
        $keyCloakUsers = $this->keyCloakService->getKeyCloakUsers();

        return $this->mergeUsers($keyCloakUsers, $authors, 'creator_hash');
    }

    /**
     * Get task users from keyCloak
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function executors(): AnonymousResourceCollection
    {
        $authors = Task::select(['executor_hash'])->groupBy('executor_hash')->get();
        $keyCloakUsers = $this->keyCloakService->getKeyCloakUsers();

        return $this->mergeUsers($keyCloakUsers, $authors, 'executor_hash');
    }
}
