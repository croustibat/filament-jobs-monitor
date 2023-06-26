<?php

namespace Croustibat\FilamentJobsMonitor\Traits;

use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;

trait QueueProgress
{
    /**
     * Update progress.
     */
    public function setProgress(int $progress): void
    {
        $progress = min(100, max(0, $progress));

        if (! $monitor = $this->getQueueMonitor()) {
            return;
        }

        $monitor->update([
            'progress' => $progress,
        ]);

        $this->progressLastUpdated = time();
    }

    /**
     * Return Queue Monitor Model.
     */
    protected function getQueueMonitor(): ?QueueMonitor
    {
        if (
            ! property_exists($this, 'job')
            || ! $this->job
            || ! $jobId = QueueMonitor::getJobId($this->job)
        ) {
            return null;
        }

        return QueueMonitor::getModel()::whereJobId($jobId)
            ->orderBy('started_at', 'desc')
            ->first();
    }
}
