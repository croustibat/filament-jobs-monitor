<?php

namespace Croustibat\FilamentJobsMonitor\Models;

use Croustibat\FilamentJobsMonitor\FilamentJobsMonitorPlugin;
use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Hash;

class QueueMonitor extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'job_id',
        'name',
        'queue',
        'connection',
        'started_at',
        'finished_at',
        'failed',
        'attempt',
        'progress',
        'exception_message',
    ];

    protected $casts = [
        'failed' => 'bool',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    /*
     *--------------------------------------------------------------------------
     * Mutators
     *--------------------------------------------------------------------------
     */
    public function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->isFinished()) {
                    return $this->failed ? 'failed' : 'succeeded';
                }

                return 'running';
            },
        );
    }

    /*
     *--------------------------------------------------------------------------
     * Methods
     *--------------------------------------------------------------------------
     */

    public static function getJobId(JobContract $job): string|int
    {
        if ($jobId = $job->getJobId()) {
            return $jobId;
        }

        return Hash::make($job->getRawBody());
    }

    /**
     * check if the job is finished.
     */
    public function isFinished(): bool
    {
        if ($this->hasFailed()) {
            return true;
        }

        return null !== $this->finished_at;
    }

    /**
     * Check if the job has failed.
     */
    public function hasFailed(): bool
    {
        return $this->failed;
    }

    /**
     * check if the job has succeeded.
     */
    public function hasSucceeded(): bool
    {
        if (! $this->isFinished()) {
            return false;
        }

        return ! $this->hasFailed();
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        if (FilamentJobsMonitorPlugin::get()->getPruning()) {
            return static::where('created_at', '<=', now()->subDays(FilamentJobsMonitorPlugin::get()->getPruningRetention()));
        }

        return false;
    }
}
