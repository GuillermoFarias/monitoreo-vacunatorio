<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\User;
use App\Notifications\EntryNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class MonitoringService
{
    /**
     * getNotifiableUsers
     *
     * @return Collection
     */
    public function getNotifiableUsers(): Collection
    {
        $collection = new Collection();
        $emails = explode(',', env('REPORT_EMAILS'));

        Log::info('MonitoringService: getNotifiableUsers: emails: ' . json_encode($emails));

        foreach ($emails as $email) {
            $user = new User;
            $user->email = $email;
            $collection->add($user);
        }

        return $collection;
    }
    /**
     * sendReport
     *
     * @return void
     */
    public function sendReport(): void
    {
        $this->createIfNotExistsNotifiedAtColumn();
        $entries = $this->getEntriesToNotified();
        Notification::send(
            $this->getNotifiableUsers(),
            new EntryNotification($this->getReportPdf($entries), $entries->count())
        );

        $this->updateEntriesNotifiedAt($entries);
    }

    /**
     * getPreviewReport
     *
     * @return void
     */
    public function getPreviewReport()
    {
        $this->createIfNotExistsNotifiedAtColumn();
        return $this->getReportStream();
    }

    /**
     * getReportPdf
     *
     * @return void
     */
    public function getReportPdf(Collection $entries)
    {
        $pdf = PDF::loadView('report_data', [
            'entries' => $entries
        ]);

        return $pdf->output();
    }

    /**
     * getReportStream
     *
     * @return Response
     */
    public function getReportStream(): Response
    {
        $pdf = PDF::loadView('report_data', [
            'entries' => $this->getEntriesToNotified()
        ]);

        return $pdf->stream('stream.pdf');
    }
    /**
     * getEntriesToNotified
     *
     * @return Collection
     */
    public function getEntriesToNotified(): Collection
    {
        return Entry::whereNull('notified_at')->get();
    }

    /**
     * createIfNotExistsNotifiedAtColumn
     *
     * @return void
     */
    public function createIfNotExistsNotifiedAtColumn(): void
    {
        $migratedColumn = 'notified_at';
        $sourceModelInstance = new Entry();
        $schema = Schema::connection($sourceModelInstance->getConnectionName());

        $columnExists = $schema->hasColumn($sourceModelInstance->getTable(), $migratedColumn);

        if (!$columnExists) {
            $schema->table($sourceModelInstance->getTable(), function (Blueprint $table) use ($migratedColumn) {
                $table->timestamp($migratedColumn)->nullable();
            });
        }
    }

    /**
     * updateEntriesNotifiedAt
     *
     * @param  mixed $entries
     * @return void
     */
    public function updateEntriesNotifiedAt(Collection $entries): void
    {
        foreach ($entries as $entry) {
            $entry->notified_at = now();
            $entry->save();
        }
    }
}
