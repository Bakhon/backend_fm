<?php

namespace App\Exports;

use App\Http\Requests\TaskSearchRequest;
use App\Services\TaskService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TasksExport implements FromView
{
    protected $request;
    protected $taskService;

    public function __construct(TaskSearchRequest $request, TaskService $taskService)
    {
        $this->request = $request;
        $this->taskService = $taskService;
    }

    public function view(): View
    {
        $data = $this->taskService->_list($this->request);
        return view('exports.tasks', [
            'data' => $data
        ]);
    }
}
