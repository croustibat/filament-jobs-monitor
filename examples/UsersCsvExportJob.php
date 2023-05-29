<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Croustibat\FilamentJobsMonitor\Traits\QueueProgress;

class UsersCsvExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, QueueProgress;

    /**
     * The data to be exported as CSV.
     *
     * @var Collection
     */
    protected $data;

    /**
     * The name of the output file.
     *
     * @var string
     */
    protected $filename;

    /**
     * Create a new job instance.
     *
     * @param  Collection  $data
     * @param  string  $filename
     * @return void
     */
    public function __construct(Collection $data, string $filename)
    {
        $this->data = $data->pluck('email', 'name');
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->setProgress(0);

        sleep(2);

        $this->setProgress(20);

        // Create a stream to write the CSV data to
        $stream = fopen('php://temp', 'w+');

        // Write each item in the collection to the CSV stream
        foreach ($this->data->toArray() as $key => $item) {
            fputcsv($stream, [$key, $item]);
        }

        sleep(2);

        $this->setProgress(80);


        // Rewind the stream pointer to the beginning
        rewind($stream);

        // Read the contents of the stream into a string
        $csv = stream_get_contents($stream);

        // Close the stream
        fclose($stream);

        sleep(2);

        $this->setProgress(90);

        // Save the CSV data to a file in storage
        Storage::put("exports/{$this->filename}", $csv);

        sleep(2);

        $this->setProgress(100);
    }


}
