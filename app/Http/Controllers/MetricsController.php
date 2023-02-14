<?php

namespace App\Http\Controllers;

//use App\Http\Requests\MetricsRequest;
use App\Exports\MetricsExport;
use App\Exports\MetricsDetailsExport;
use App\Exports\MetricsMultipleSheetExport;
use App\Exports\MetricsUserMetricsExport;
use App\Http\Requests\MetricIdRequest;
use App\Http\Requests\MetricsSearchRequest;
use App\Http\Resources\MetricsResource;
use App\Models\File;
use App\Models\UserFiles;
use App\Services\MetricsService;
use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Metrics",
 *     description="File endpoints"
 * )
 */
class MetricsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MetricsSearchRequest $request, MetricsService $service) : JsonResponse
    {
        $response = $service->_list($request);
        return $this->successResponseWithData($response);
    }

    public function export(MetricsSearchRequest $request, MetricsService $metricsService): BinaryFileResponse
    {
        $request->without_limit = true;
        return  (new MetricsMultipleSheetExport($request, $metricsService))->download('metrics.xlsx');
        //return Excel::download(new MetricsExport($request, $metricsService), 'metrics.xlsx');
    }

    public function exportMetrics(MetricIdRequest $request, MetricsService $metricsService): BinaryFileResponse
    {
        $request->without_limit = true;
        return Excel::download(new MetricsDetailsExport($request, $metricsService), 'metrics_details.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MetricsService $metricsService, Request $request) : JsonResponse
    {
        $response = $metricsService->show($request->route('metric'));
        return $this->successResponseWithData($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
