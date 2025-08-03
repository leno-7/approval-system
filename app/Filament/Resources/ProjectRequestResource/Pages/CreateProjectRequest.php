<?php

namespace App\Filament\Resources\ProjectRequestResource\Pages;

use App\Filament\Resources\ProjectRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectRequest extends CreateRecord
{
  protected static string $resource = ProjectRequestResource::class;

   protected function getRedirectUrl(): string
{
    return ProjectRequestResource::getUrl(); // يرجعه لصفحة "طلبات المشاريع"
}


}
