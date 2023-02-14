<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskSearchRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="Tasks"
 * )
 */
class TaskController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     description="Get list tasks",
     *     @OA\Parameter(in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="status_id", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="date_created_from", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_created_to", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_updated_from", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_updated_to", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="user_hash", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="order_by", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="direction", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(description="List limit", in="query", name="limit", required=false, example=10, @OA\Schema(type="integer")),
     *     @OA\Parameter(description="Offset", in="query", name="offset", required=false, example=0, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response="200",description="Return sections list", @OA\JsonContent(ref="#/components/schemas/TaskResource")),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param TaskSearchRequest $request
     * @param TaskService $service
     * @return JsonResponse
     */
    public function index(TaskSearchRequest $request, TaskService $service): JsonResponse
    {
        $response = $service->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     description="Get single task",
     *     @OA\Parameter(description="Task id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Return task data", @OA\JsonContent(ref="#/components/schemas/TaskRequest")),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *      }
     * )
     *
     * @param Task $task
     * @param TaskService $service
     * @return JsonResponse
     */
    public function show(Task $task, TaskService $service): JsonResponse
    {
        $response = $service->show($task);
        return $this->successResponseWithData(new TaskResource($response));
    }

    /**
     * @OA\Post (
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/TaskRequest")),
     *     @OA\Response(response="200", description="Return task data", @OA\JsonContent(ref="#/components/schemas/TaskRequest")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param TaskRequest $request
     * @param TaskService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(TaskRequest $request, TaskService $service): JsonResponse
    {
        $response = $service->create(new Task, $request);
        return $this->successResponseWithData(new TaskResource($response));
    }

    /**
     * @OA\Put (
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     description="Update task",
     *     @OA\Parameter(description="Task id", in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/TaskUpdateRequest")),
     *     @OA\Response(response="200",description="Return Task model"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param Task $task
     * @param TaskService $service
     * @param TaskUpdateRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(Task $task, TaskService $service, TaskUpdateRequest $request): JsonResponse
    {
        $response = $service->update($task, $request);
        return $this->successResponseWithData(new TaskResource($response));
    }

    /**
     * @OA\Get (
     *     path="/api/tasks/export",
     *     tags={"Tasks"},
     *     description="Export tasks",
     *     @OA\Parameter(in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="status_id", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="date_created_from", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_created_to", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_updated_from", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_updated_to", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="user_hash", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="order_by", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="direction", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Return tasks excel"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION")
     * )
     * @param TaskSearchRequest $request
     * @param TaskService $taskService
     * @return BinaryFileResponse
     */
    public function export(TaskSearchRequest $request, TaskService $taskService): BinaryFileResponse
    {
        $request->without_limit = true;
        return Excel::download(new TasksExport($request, $taskService), 'tasks.xlsx');
    }

    /**
     * @OA\Get (
     *     path="/api/tasks/creators",
     *     tags={"Tasks"},
     *     description="Tasks creators",
     *     @OA\Response(response="200", description="Return tasks creators"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param TaskService $taskService
     * @return JsonResponse
     * @throws Throwable
     */
    public function creators(TaskService $taskService): JsonResponse
    {
        $response = $taskService->creators();
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/tasks/executors",
     *     tags={"Tasks"},
     *     description="Tasks executors",
     *     @OA\Response(response="200", description="Return tasks executors"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param TaskService $taskService
     * @return JsonResponse
     * @throws Throwable
     */
    public function executors(TaskService $taskService): JsonResponse
    {
        $response = $taskService->executors();
        return $this->successResponseWithData($response);
    }
}
