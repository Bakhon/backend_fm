<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Services\MetricsService;
use Illuminate\Support\Facades\DB;

class MetricsAllExport implements FromQuery, WithTitle
{

    public function __construct(MetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    public function query()
    {
         return  DB::table('files')
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
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Итого';
    }
}
