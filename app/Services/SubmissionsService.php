<?php

namespace App\Services;

use App\Exceptions\SubmissionProcessException;
use App\Models\Submission;
use Throwable;

class SubmissionsService
{

    /**
     * Create process of submission
     *
     * @param array $attributes
     * @return Submission
     * @throws SubmissionProcessException
     */
    public function createSubmission(array $attributes): Submission
    {
        try {
            return Submission::create($attributes);
        } catch (Throwable $exception) {
            throw new SubmissionProcessException('Submission processing with error: ' . $exception->getMessage());
        }
    }

}
