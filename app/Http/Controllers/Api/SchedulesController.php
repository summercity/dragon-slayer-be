<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Schedules;
use App\Http\Resources\Schedules as SchedulesResource;

class SchedulesController extends Controller
{
    /**
	 * Store-Action
	 *
	 * @param Request $request
	 * @param bigint $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function generate()
	{
        $user_id =  Auth::user()->id;;
        $params = [$user_id];
        $data = DB::select('call sp_generate_schedule(?)', $params);
        return response()->json($data);
	}
	
	     /**
	 * Update-Action
	 *
	 * @param Request $request
	 * @param uuid $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateStatus(Request $request, $id)
	{
        $Schedules = Schedules::findOrFail($id);
        

        $validatedPayload = $request->validate([
            'status'=>'required'
        ]);

		$Schedules->update($validatedPayload);
 
        return new SchedulesResource($Schedules);
 
	}
	
	 /**
	 * Get-Action
	 *
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function generatedDate()
	{
        $data = DB::select('call sp_get_generated_date_for_today()');
        return response()->json($data);
	}

	/**
	 * Get-Action
	 *
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function generatedSchedules()
	{
        $data = DB::select('call sp_get_generated_schedules_for_today()');
        return response()->json($data);
	}
}
