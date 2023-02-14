<?php

namespace App\Services;

use App\Exceptions\ApiException;
//use App\Http\Services\MetricsServiceRequest;
use App\Http\Requests\MetricsSearchRequest;
use App\Http\Requests\MetricIdRequest;
use App\Http\Resources\MetricsResource;
use App\Http\Resources\UserMetricsResource;
use App\Http\Resources\UserAllMetricsResource;
use App\Models\File;
use App\Models\UserFiles;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\UserMetrics;
use Carbon\Carbon;


/**
 * Class FamilyCompositionService
 * @package App\Services
 */
class MetricsService extends Service
{
    /**
     * Get list composition with search
     * @param MetricsServiceSearchRequest $request
     * @return array
     */
    public function _list(MetricsSearchRequest $request)
    {
        
        $query = DB::table('files as f')
                ->join('case_versions as c', 'c.id', '=', 'f.case_file_id')
                ->join('cases as cs', 'cs.id', '=', 'c.case_id')
                ->join('categories as categ', 'categ.id', '=', 'cs.category_id')
                ->join('section_category as sc', 'sc.category_id', '=', 'categ.id')
                ->join('sections as s', 's.id', '=', 'sc.section_id')
                ->where('f.extension', '=', 'rfa')
                ->orderBy('f.count', 'desc');
                 
        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('original_name', 'like', '%' . $request->search . '%');
            });
        }

        $queryWithoutLimit = clone $query;

        if (!$request->without_limit) {
          /*  $query->limit($request->limit)
                ->offset($request->offset); */
        }

        return [
            'list' => MetricsResource::collection($query->get([
                    'f.id', 
                    'f.original_name',
                    'f.count',
                    'cs.name',
                    'categ.full_name',
                    'categ.name',
                    's.name',
                    'c.version'])),
            'listCount' => $queryWithoutLimit->count(),
        ];
    }

    public function show($id) 
    {
        $query = DB::table('files as f')
                    ->join('user_files as u', 'u.file_id', '=', 'f.id')
                    ->join('case_versions as c', 'c.id', '=', 'f.case_file_id')
                    ->join('cases as cs', 'cs.id', '=', 'c.case_id')
                    ->join('sections as s', 's.id', '=', 'cs.section_id')
                    ->join('categories as catg', 'catg.id', '=', 'cs.category_id')
                    ->where('u.file_id', '=', $id)
                    ->get(['f.id',
                    'f.original_name',
                    'f.count',
                    'u.file_id',
                    'u.date_download',
                    'u.user_hash',
                    's.name',
                    'catg.full_name']);
                    
        $queryWithoutLimit = clone $query;
        
        return [
            'list' => $query ? UserMetricsResource::collection($query) : '',
            'list_count' => $query ? $queryWithoutLimit->count() : 0,
        ];
    }

    public function addUserFiles($file, $value) : void
    {
        DB::table('user_files')->insert([
            'file_id' => $file->id,
            'user_hash' =>  $value,
            'date_download' => Carbon::now()->toDateTime()
        ]); 
    }
    
        public function show_one_details(MetricIdRequest $request)
    {
        $id = $request->route('metrics');
        
        $responce = DB::table('files')
                    ->join('user_files', 'file_id', '=', 'files.id')
                    ->join('case_versions as c', 'c.id', '=', 'files.case_file_id')
                    ->join('cases as cs', 'cs.id', '=', 'c.case_id')
                    ->join('sections as s', 's.id', '=', 'cs.section_id')
                    ->join('categories as catg', 'catg.id', '=', 'cs.category_id')
                    ->where('user_files.file_id', '=', $id)->get([
                    'files.original_name', 
                    'files.id',
                    'files.count',
                    'user_files.file_id',
                    'user_files.date_download', 
                    's.name', 
                    'catg.full_name',
                    'user_files.user_hash',
                    ]);
        
        $queryWithoutLimit = clone $responce;
        return [
                    'list' => UserMetricsResource::collection($responce),
                    'list_count' => $queryWithoutLimit->count(),
            ];
    }

    public function all_user_files(MetricsSearchRequest $request) 
    {
        $query = DB::table('files')
                    ->join('user_files', 'file_id', '=', 'files.id')
                    ->join('case_versions as c', 'c.id', '=', 'files.case_file_id')
                    ->join('cases as cs', 'cs.id', '=', 'c.case_id')
                    ->join('sections as s', 's.id', '=', 'cs.section_id')
                    ->join('categories as catg', 'catg.id', '=', 'cs.category_id')
                    ->where('files.count', '!=', '0')->get([
                    'files.original_name', 
                    'c.version',
                    'files.id',
                    'files.count',
                    'user_files.file_id',
                    'user_files.date_download', 
                    's.name', 
                    'catg.full_name',
                    'user_files.user_hash',
                    ]);

        $queryWithoutLimit = clone $query;
        return [
                    'list' => UserAllMetricsResource::collection($query),
                    'list_count' => $queryWithoutLimit->count(),
            ];
    }
}
