<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\SubmissionProcessException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionRequest;
use App\Jobs\CreateSubmissionJob;
use App\Services\SubmissionsService;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function __construct(private readonly SubmissionsService $submissionsService)
    {

    }

    /**
     * Process a submit of submission
     *
     * @param SubmissionRequest $request
     * @return JsonResponse
     */
    public function submit(SubmissionRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        CreateSubmissionJob::dispatch($validatedData);

        return $this->successResponse([], 'Submission created successfully', 201);
    }
}
