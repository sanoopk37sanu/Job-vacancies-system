<?php

namespace App\Http\Controllers;

use App\Events\JobVacancyCreated;
use App\Models\Vacancy;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Vacancy = DB::table('vacancies')
            ->join('jobs', 'vacancies.job_id', '=', 'jobs.id')
            ->select('jobs.job_name', 'vacancies.*')
            ->where('vacancies.status', '=', '1')
            ->get();
        if (is_null($Vacancy->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Vacancy found!',
            ], 200);
        }
        $response = [
            'status' => 'success',
            'message' => 'Vacancy are retrieved successfully.',
            'data' => $Vacancy,
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'description' => 'required',
            'end_date' => 'required',
            'job_id' => 'required',
            'start_date' => 'required',
            'status' => 'required',

        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $Vacancy = Vacancy::create($request->all());
        event(new JobVacancyCreated($Vacancy));
        $response = [
            'status' => 'success',
            'message' => 'Vacancy is added successfully.',
            'data' => $Vacancy,
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vacancy $vacancy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vacancy $vacancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'description' => 'required',
            'end_date' => 'required',
            'job_id' => 'required',
            'start_date' => 'required',
            'status' => 'required',

        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $Vacancy = Vacancy::find($id);

        if (is_null($Vacancy)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Vacancy is not found!',
            ], 200);
        }

        $Vacancy->update($request->all());

        $response = [
            'status' => 'success',
            'message' => 'Vacancy is updated successfully.',
            'data' => $Vacancy,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Vacancy = Vacancy::find($id);

        if (is_null($Vacancy)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Vacancy is not found!',
            ], 200);
        }

        Vacancy::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Vacancy is deleted successfully.'
        ], 200);
    }
}
