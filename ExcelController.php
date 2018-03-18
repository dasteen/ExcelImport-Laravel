<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\posts;

//use App\categories;

//use Illuminate\Routing\Controller as BaseController;
//use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;


//use Excel;
//use App\Models\System\Session;

//use App\School;


class ExcelController extends Controller

{
    public function index()
    {

        return view('import_export');

    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function importFile(Request $request)
    {
        $mydata = $request->all();

        $db_table = $mydata['table'];

        if ($request->hasFile('sample_file')) {

            $path = $request->file('sample_file')->getRealPath();


            Excel::filter('chunk')->selectSheetsByIndex(0)->load($path)->chunk(100, function ($results) use ($db_table) {
                $db_table_local = $db_table;
//	        	dd($db_table);
                $results = json_decode(json_encode($results), true);
                $number = count($results);
                while ($number > 0) {
                    foreach ($results as $key => $value) {
                        foreach ($value as $k => $v) {
                            // checking if the columns are in the table
                            if (!Schema::hasColumn($db_table_local, $k)) {
                                Schema::table($db_table_local, function (Blueprint $table) use ($k) {
                                    $table->string($k, 50);
                                });
                            }
                            $arr[$k] = $v;
                        }
                        $arrs[] = $arr;
                    }
                    if (!empty($arrs)) {
                        foreach ($arrs as $arr) {
                            $id = DB::table($db_table_local)->where('id', '=', $arr['id'])->get();
                            if ($id->count()) {
                                DB::table($db_table_local)->where('id', $arr['id'])->update($arr);

                                $successMsg = 'Record Updated successfully.';
                                Session::flash('flash_success', $successMsg);
                                return view('import_export');
                            }
                            $test = DB::table($db_table_local)->insert($arr);
                            dd($test);
                        }
                        $successMsg = 'Insert Recorded successfully.';
                        Session::flash('flash_success', $successMsg);
                        return view('import_export');

                    }
                }
            });
        }
        $errorMsg = 'Request data does not have any files to import.';
        Session::flash('flash_danger', $errorMsg);
        return view('import_export');

    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function exportFile($type)
    {

        $products = Product::get()->toArray();


        return Excel::create('hdtuto_demo', function ($excel) use ($products) {

            $excel->sheet('sheet name', function ($sheet) use ($products) {

                $sheet->fromArray($products);

            });

        })->download($type);

    }

}