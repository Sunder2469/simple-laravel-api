<?php

namespace App\Jobs;

use App\Events\SubmissionSaved;
use App\Exceptions\SubmissionProcessException;
use App\Services\SubmissionsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly array $attributes)
    {
        //
    }

    /**
     * Execute the job.
     * @throws SubmissionProcessException
     */
    public function handle(): void
    {
        $service = new SubmissionsService();
        $submission = $service->createSubmission($this->attributes);
        event(new SubmissionSaved($submission));
    }
}
