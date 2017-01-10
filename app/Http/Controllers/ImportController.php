<?php

namespace servientrega\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use servientrega\Entities\City;

class ImportController extends Controller
{
    public function import()
    {
        $file = Storage::url('app/public/excel/matriz.xlsx');
        DB::table('cities')->truncate();

        Excel::load($file, function ($reader) {
            City::insert($reader->all()->toArray());
        });
        return ['success' => 'ok'];
    }
}
