<?php

namespace App\Filament\Resources\ProjectRequestCompletionResource\Pages;

use App\Filament\Resources\ProjectRequestCompletionResource;
use Filament\Resources\Pages\ListRecords;

class ListProjectRequestCompletions extends ListRecords
{
   protected static string $resource = ProjectRequestCompletionResource::class;


    protected function getActions(): array
    {
        return []; // بدون زر إنشاء جديد
    }
}
