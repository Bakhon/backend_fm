<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\ReportsExport;
use App\Http\Requests\ReportInitRequest;
use App\Http\Requests\ReportSearchRequest;
use App\Models\Report;
use Illuminate\Http\Response;
use Throwable;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @OA\Tag(
 *     name="Reports",
 *     description="Reports apis"
 * )
 */
class ReportController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/api/reports",
     *     tags={"Reports"},
     *     description="Get reports  list",
     *     @OA\Parameter(in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="status_id", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="date_created_from", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_created_to", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="user_hash", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="order_by", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="direction", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(description="List limit", in="query", name="limit", required=false, example=10, @OA\Schema(type="integer")),
     *     @OA\Parameter(description="Offset", in="query", name="offset", required=false, example=0, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return reports list"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param ReportSearchRequest $request
     * @param ReportService $reportService
     * @return JsonResponse
     */
    public function index(ReportSearchRequest $request, ReportService $reportService): JsonResponse
    {
        $response = $reportService->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post (
     *     path="/api/reports/init",
     *     tags={"Reports"},
     *     description="Create report",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ReportInitRequest")),
     *     @OA\Response(
     *      response="200",
     *      description="Return report resource",
     *      @OA\JsonContent(ref="#/components/schemas/ReportResource")
     *     ),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param ReportInitRequest $request
     * @param ReportService $reportService
     * @return JsonResponse
     * @throws Throwable
     */
    public function init(ReportInitRequest $request, ReportService $reportService): JsonResponse
    {
        $response = $reportService->init($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/reports/export",
     *     tags={"Reports"},
     *     description="Export reports",
     *     @OA\Parameter(in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="order_by", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="direction", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response="200",description="Return reports excel"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION")
     * )
     * @param ReportSearchRequest $request
     * @param ReportService $reportService
     * @return BinaryFileResponse
     */
    public function export(ReportSearchRequest $request, ReportService $reportService): BinaryFileResponse
    {
        $request->without_limit = true;
        return Excel::download(new ReportsExport($request, $reportService), 'reports.xlsx');
    }

    /**
     * @OA\Get (
     *     path="/api/reports/export/{id}",
     *     tags={"Reports"},
     *     description="Export report in xlsx",
     *     @OA\Parameter(description="Report id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return report excel"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION")
     * )
     * @param Report $report
     * @param ReportService $reportService
     * @return BinaryFileResponse
     */
    public function exportReport(Report $report, ReportService $reportService): BinaryFileResponse
    {
        return Excel::download(new ReportExport($report, $reportService), 'report.xlsx');
    }

    /**
     * @OA\Get (
     *     path="/api/reports/export-pdf/{id}",
     *     tags={"Reports"},
     *     description="Export report in pdf",
     *     @OA\Parameter(description="Report id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return report excel"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION")
     * )
     * @param Report $report
     * @param ReportService $reportService
     * @return BinaryFileResponse
     */
    public function exportPdfReport(Report $report, ReportService $reportService): BinaryFileResponse
    {
        return Excel::download(new ReportExport($report, $reportService), 'report.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    /**
     * @OA\Get (
     *     path="/api/reports/{id}",
     *     tags={"Reports"},
     *     description="Get single report",
     *     @OA\Parameter(description="Report id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(
     *      response="200",
     *      description="Return report resource",
     *      @OA\JsonContent(ref="#/components/schemas/ReportResource")
     *     ),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param Report $report
     * @param ReportService $reportService
     * @return JsonResponse
     */
    public function show(Report $report, ReportService $reportService): JsonResponse
    {
        $response = $reportService->show($report);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/reports/authors",
     *     tags={"Reports"},
     *     description="Reports authors",
     *     @OA\Response(response="200", description="Return reports authors"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param ReportService $reportService
     * @return JsonResponse
     * @throws Throwable
     */
    public function authors(ReportService $reportService): JsonResponse
    {
        $response = $reportService->authors();
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Delete (
     *     path="/api/reports/{id}",
     *     tags={"Reports"},
     *     description="Delete report",
     *     @OA\Parameter(description="Report id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Report successfully deleted"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * Delete Report
     * @param Report $report
     * @param ReportService $reportService
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Report $report, ReportService $reportService): JsonResponse
    {
        $reportService->delete($report);
        return $this->successResponse(Response::HTTP_OK);
    }
}
