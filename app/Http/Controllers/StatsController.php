<?php
/**
 * @author dory 12/11/18
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use App\Stats;

class StatsController extends controller
{
    /**
     * The stat modal.
     *
     */
    protected $stat;


    /**
     * Create a new stats model.
     *
     * @return void
     */
    public function __construct()
    {
        $this->stat = new Stats;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return string
     */
    public function index(Request $request)
    {
        $param = [];
        $param['size'] = 4;
        $param['endDate'] = (Carbon::now()->timestamp)*1000;
        $param['stats']= 'reddit';
        $param['depth'] = 2;
        $param['UUID']= '41411219-0147-11e9-bcec-801844e116c5';
//        if($request->has('UUID'))
//            $param['UUID'] = $request->input('UUID');
//        else
//            $param['UUID'] = 0;
//        if($request->has('depth'))
//            $param['depth'] = $request->input('depth');
//        else
//            $param['depth'] = 0;
//        if($request->has('stats'))
//            $param['stats'] = $request->input('stats');
//        else
//            $param['stats'] = 'empty';

    //     $url= config( 'stat.stat.url'). '/stats/timeline/niuz/'.
    //             $param['UUID']. '?depth='. $param['depth']. '&size='. $param['size'].
    //             '&endDate='. $param['endDate']. '&stats='. $param['stats'];
    //    switch ($param['depth']){
    //        case 1:
    //           return $this->stat->getDepthOne($url);
    //        case 2:
    //           return $this->stat->getDepthTwo($url);
    //        default:
    //             return $this->stat->getDepthZero($url);
    //    }

    return response()->json([
        'data' =>  [
         'facebook' =>  [
                [ "timestamp" => "2018-12-20T11:52:57Z" ,"total" => 500 ],
                [ "timestamp" => "2018-11-20T11:52:57Z" ,"total" => 320 ],
                [ "timestamp" => "2018-10-20T11:52:57Z" ,"total" => 100 ],
            ],
          'reddit' => [
                [ "timestamp" => "2018-12-20T11:52:57Z" ,"total" => 600 ],
                [ "timestamp" => "2018-11-20T11:52:57Z" ,"total" => 620 ],
                [ "timestamp" => "2018-10-20T11:52:57Z" ,"total" => 600 ],
            ]
        ]  
    ]);
    }


    // return response()->json([
    //     'data' => [
    //         'total' => [
    //             [ "timestamp" => "2018-12-20T11:52:57Z" ,"total" => 500 ],
    //             [ "timestamp" => "2018-11-20T11:52:57Z" ,"total" => 320 ],
    //             [ "timestamp" => "2018-10-20T11:52:57Z" ,"total" => 100 ],
    //         ]  
    //     ] 
    // ]);
    //     }
    public function test(){
        return view('welcome');
    }
}
