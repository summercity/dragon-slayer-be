<?php

namespace App\Http\Controllers\Api;
use App\RecurringSchedules;
use App\Http\Resources\RecurringSchedules as RecurringSchedulesResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecurringSchedulesController extends Controller
{

    public function index()
    {
        // Get Recurring Schedules
        $RecurringSchedules = RecurringSchedules::paginate(15);

        // Return collection of Recurring Schedules as a resource
        return RecurringSchedulesResource::collection($RecurringSchedules);
    }

    public function show($id) 
    {
        // Get Recurring Schedules
        $RecurringSchedules = RecurringSchedules::findOrFail($id);

        // Return single Recurring Schedule as a resource
        return new RecurringSchedulesResource($RecurringSchedules);
    }

    //
    public function store(Request $request)
    {
        $validatedPayload = $request->validate([
            'flight_number'=>'required|max:10',
            'destination'=>'required|max:50',
            'equipment'=>'required|max:6',
            'terminal' =>'required',
            'ground_time'=>'required',
            'departure'=>'required',
            'repeated'=>'required',
            'repeated_json'=>'required',
            'start_date'=>'required',
            'stop_date'=>'required',
        ]);

        // $validatedPayload['created_by'] = $request->user()->id;

        $RecurringSchedules = RecurringSchedules::create($validatedPayload);


        return new RecurringSchedulesResource($RecurringSchedules);

    }


     /**
	 * Update-Action
	 *
	 * @param Request $request
	 * @param uuid $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, $id)
	{
        $RecurringSchedules = RecurringSchedules::findOrFail($id);
        

        $validatedPayload = $request->validate([
            'flight_number'=>'required|max:10',
            'destination'=>'required|max:50',
            'equipment'=>'required|max:6',
            'terminal' =>'required',
            'ground_time'=>'required',
            'departure'=>'required',
            'repeated'=>'required',
            'repeated_json'=>'required',
            'start_date'=>'required',
            'stop_date'=>'required',
        ]);

		$RecurringSchedules->update($validatedPayload);
 
        return new RecurringSchedulesResource($RecurringSchedules);
 
    }
    
    //
    public function destroy($id)
    {
        // Get Recurring Schedules
        $RecurringSchedules = RecurringSchedules::findOrFail($id);

        if($RecurringSchedules->delete()) {
            return new RecurringSchedulesResource($RecurringSchedules);
        }
    }
}
