<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

    class AllMetrics implements FromView, WithTitle
    {
            public function view(): View
            {
                $query = DB::table('files as f')
                ->join('case_versions as c', 'c.id', '=', 'f.case_file_id')
                ->join('cases as cs', 'cs.id', '=', 'c.case_id')
                ->join('categories as categ', 'categ.id', '=', 'cs.category_id')
                ->join('section_category as sc', 'sc.category_id', '=', 'categ.id')
                ->join('sections as s', 's.id', '=', 'sc.section_id')
                ->where('f.extension', '=', 'rfa')
                ->orderBy('f.count', 'desc')
                ->get([
                    'f.id', 
                    'f.original_name',
                    'f.count',
                    'cs.name',
                    'categ.full_name',
                    'categ.name',
                    's.name',
                    'c.version']);

            return view('exports.allmetrics', [
            'report' => $query
            ]);
    }
    public function title(): string
                            
    {
        return 'Итого';
    }
    }


?>