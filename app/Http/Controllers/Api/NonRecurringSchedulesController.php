<?php

namespace App\Http\Controllers\Api;
use App\NonRecurringSchedules;
use App\Http\Resources\NonRecurringSchedules as NonRecurringSchedulesResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NonRecurringSchedulesController extends Controller
{
    public function index()
    {
        // Get Recurring Schedules
        $NonRecurringSchedules = NonRecurringSchedules::orderBy('updated_at', 'desc')->paginate(10);

        // Return collection of Non-Recurring Schedules as a resource
        return NonRecurringSchedulesResource::collection($NonRecurringSchedules);
    }

    public function show($id) 
    {
        // Get Non Recurring Schedules
        $NonRecurringSchedules = NonRecurringSchedules::findOrFail($id);

        // Return single Recurring Schedule as a resource
        return new NonRecurringSchedulesResource($NonRecurringSchedules);
    }

    public function store(Request $request)
    {
        $validatedPayload = $request->validate([
            'flight_number'=>'required|max:10',
            'equipment'=>'required|max:6',
            'terminal' =>'required',
            'ground_time'=>'required',
            'departure'=>'required',
            'customer_name'=>'required',
            'company_name'=>'required',
            'start_date'=>'required',
            'stop_date'=>'required',
        ]);

        $validatedPayload['updated_by'] = $request->user()->id;

        $NonRecurringSchedules = NonRecurringSchedules::create($validatedPayload);


        return new NonRecurringSchedulesResource($NonRecurringSchedules);

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
        $NonRecurringSchedules = NonRecurringSchedules::findOrFail($id);
        

        $validatedPayload = $request->validate([
            'flight_number'=>'required|max:10',
            'equipment'=>'required|max:6',
            'terminal' =>'required',
            'ground_time'=>'required',
            'departure'=>'required',
            'customer_name'=>'required',
            'company_name'=>'required',
            'start_date'=>'required',
            'stop_date'=>'required',
        ]);

		$NonRecurringSchedules->update($validatedPayload);
 
        return new NonRecurringSchedulesResource($NonRecurringSchedules);
 
    }

        //
        public function destroy($id)
        {
            // Get Recurring Schedules
            $NonRecurringSchedules = NonRecurringSchedules::findOrFail($id);
    
            if($NonRecurringSchedules->delete()) {
                return new NonRecurringSchedulesResource($NonRecurringSchedules);
            }
        }
}
