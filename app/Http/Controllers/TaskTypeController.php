<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskTypeRequest;
use App\Http\Requests\TaskTypeSearchRequest;
use App\Models\TaskType;
use App\Services\TaskTypeService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @OA\Tag(
 *     name="Tasks Types",
 *     description="Task's types",
 * )
 */
class TaskTypeController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/task-types",
     *     tags={"Tasks Types"},
     *     description="Get list of task's types with search",
     *     @OA\Parameter(description="Search string",in="query",name="search",required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(description="list limit",in="query",name="limit",required=false, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return sections list",@OA\JsonContent(ref="#/components/schemas/TaskTypeRequest")),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param TaskTypeSearchRequest $request
     * @param TaskTypeService $service
     * @return JsonResponse
     */
    public function index(TaskTypeSearchRequest $request, TaskTypeService $service): JsonResponse
    {
        $response = $service->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/task-types/{id}",
     *     tags={"Tasks Types"},
     *      description="Get single task type",
     *      @OA\Parameter(description="Task id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *      @OA\Response(response="200",description="Return task type data",@OA\JsonContent(ref="#/components/schemas/TaskTypeRequest")),
     *      @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param TaskType $taskType
     * @param TaskTypeService $service
     * @return JsonResponse
     */
    public function show(TaskType $taskType, TaskTypeService $service): JsonResponse
    {
        $response = $service->show($taskType);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post (
     *      path="/api/task-types",
     *      tags={"Tasks Types"},
     *      description="",
     *      @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/TaskTypeRequest")),
     *      @OA\Response(response="200",description="Task type data",@OA\JsonContent(ref="#/components/schemas/TaskTypeRequest")),
     *      @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *      security={
     *       {"bearerAuth": {}}
     *      }
     * )
     * @param TaskTypeRequest $request
     * @param TaskTypeService $service
     * @return JsonResponse
     */
    public function store(TaskTypeRequest $request, TaskTypeService $service): JsonResponse
    {
        $taskType = new TaskType();
        $response = $service->save($taskType, $request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Put(
     *     path="/api/task-types/{id}",
     *     tags={"Tasks Types"},
     *     description="Update task type",
     *     @OA\Parameter(description="Task id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/TaskTypeRequest")),
     *     @OA\Response(response="200",description="Return updated task type",@OA\JsonContent(ref="#/components/schemas/TaskTypeRequest")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *      }
     * )
     * @param TaskType $taskType
     * @param TaskTypeService $service
     * @param TaskTypeRequest $request
     * @return JsonResponse
     */
    public function update(TaskType $taskType, TaskTypeService $service, TaskTypeRequest $request): JsonResponse
    {
        $response = $service->save($taskType, $request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Delete  (
     *      path="/api/task-types/{id}",
     *      tags={"Tasks Types"},
     *      description="Delete task type",
     *      @OA\Parameter(description="Task id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *      @OA\Response(response="200",description="Task successfully deleted"),
     *      @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *      security={
     *       {"bearerAuth": {}}
     *      }
     * )
     * @param TaskType $taskType
     * @param TaskTypeService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(TaskType $taskType, TaskTypeService $service): JsonResponse
    {
        $service->delete($taskType);
        return $this->successResponse(Response::HTTP_OK);
    }
}
