<?php

namespace Croustibat\FilamentJobsMonitor;

use Carbon\Carbon;
use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;
use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class QueueMonitorProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Queue::before(static function (JobProcessing $event) {
            self::jobStarted($event->job);
        });

        Queue::after(static function (JobProcessed $event) {
            self::jobFinished($event->job);
        });

        Queue::failing(static function (JobFailed $event) {
            self::jobFinished($event->job, true, $event->exception);
        });

        Queue::exceptionOccurred(static function (JobExceptionOccurred $event) {
            self::jobFinished($event->job, true, $event->exception);
        });
    }

    /**
     * Get Job ID.
     */
    public static function getJobId(JobContract $job): string|int
    {
        return QueueMonitor::getJobId($job);
    }

    /**
     * Start Queue Monitoring for Job.
     */
    protected static function jobStarted(JobContract $job): void
    {
        $now = Carbon::now();
        $jobId = self::getJobId($job);

        $monitor = QueueMonitor::query()->create([
            'job_id' => $jobId,
            'name' => $job->resolveName(),
            'queue' => $job->getQueue(),
            'started_at' => $now,
            'attempt' => $job->attempts(),
            'progress' => 0,
        ]);

        QueueMonitor::query()
            ->where('id', '!=', $monitor->id)
            ->where('job_id', $jobId)
            ->where('failed', false)
            ->whereNull('finished_at')
            ->each(function (QueueMonitor $monitor) {
                $monitor->finished_at = Carbon::now();
                $monitor->failed = true;
                $monitor->save();
            });
    }

    /**
     * Finish Queue Monitoring for Job.
     */
    protected static function jobFinished(JobContract $job, bool $failed = false, ?\Throwable $exception = null): void
    {
        $monitor = QueueMonitor::query()
            ->where('job_id', self::getJobId($job))
            ->where('attempt', $job->attempts())
            ->orderByDesc('started_at')
            ->first();

        if (! $monitor) {
            return;
        }

        $attributes = [
            'progress' => 100,
            'finished_at' => date('Y-m-d H:i:s"'),
            'failed' => $failed,
        ];

        if ($exception) {
            $attributes += [
                'exception_message' => mb_strcut($exception->getMessage(), 0, 65535),
            ];
        }

        $monitor->update($attributes);
    }
}
