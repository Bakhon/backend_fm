<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Resources\UserAllMetricsResource;
use App\Services\MetricsService;
use App\Http\Requests\MetricsSearchRequest;

    class Metrics implements FromView, WithTitle
    {

        public function __construct(MetricsSearchRequest $request, MetricsService $metricService)
        {
            $this->request = $request;
            $this->metricsService = $metricService;
        }

            public function view(): View
            {
              //  $query = $this->metricsService->all_user_files($this->request);

              $query =  DB::table('files')
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
                        ])->toArray(); 
              //  dd($query);
            
            return view('exports.metrics', [
            'report' => UserAllMetricsResource::collection($query),
            ]);
    }
    public function title(): string
                            
    {
        return 'По пользователям';
    }
    }


?>