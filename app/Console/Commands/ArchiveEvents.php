<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class ArchiveEvents extends Command
{
    protected $signature = 'event:archive';

    protected $description = 'Arsipkan event yang sudah melewati tanggal';

    public function handle(): int
    {
        $count = Event::query()
            ->whereDate('event_date', '<', now()->toDateString())
            ->where('status', '!=', Event::STATUS_ARSIP)
            ->update(['status' => Event::STATUS_ARSIP]);

        $this->info("{$count} event berhasil diarsipkan.");

        return self::SUCCESS;
    }
}
