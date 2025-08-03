<?php

namespace App\Filament\Resources\ProjectRequestResource\Pages;

use App\Filament\Resources\ProjectRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EditProjectRequest extends EditRecord
{
    protected static string $resource = ProjectRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

  protected function afterSave(): void
{
    $project = $this->record;
    $formData = $this->getForm('form')->getState();

    // مدير الإدارة المالكة
    if (Auth::user()?->hasRole('مدير الإدارة المالكة')) {
        $project->update([
            'approved_by_owner_director' => $formData['approved_by_owner_director'] ?? null,
            'approved_by_owner_director_at' => $formData['approved_by_owner_director_at'] ?? null,
            'owner_director_notes' => $formData['owner_director_notes'] ?? null,
        ]);
    }

    // المسؤول الثاني
    if (Auth::user()?->hasRole('مسؤول ثاني عن الإدارة المالكة')) {
        $project->update([
            'approved_by_second_owner' => $formData['approved_by_second_owner'] ?? null,
            'approved_by_second_owner_at' => $formData['approved_by_second_owner_at'] ?? null,
            'second_owner_notes' => $formData['second_owner_notes'] ?? null,
        ]);
    }

    // المسؤول الأول
    if (Auth::user()?->hasRole('مسؤول أول عن الإدارة المالكة')) {
        $project->update([
            'approved_by_first_owner' => $formData['approved_by_first_owner'] ?? null,
            'approved_by_first_owner_at' => $formData['approved_by_first_owner_at'] ?? null,
            'first_owner_notes' => $formData['first_owner_notes'] ?? null,
        ]);
    }
}

   public function mount($record): void
{
    parent::mount($record);

    $user = Auth::user();

    if (
        $user?->hasRole('مدير الإدارة المالكة') &&
        !$this->record->approved_by_owner_director_at
    ) {
        $this->record->approved_by_owner_director_at = Carbon::now();
    }

    if (
        $user?->hasRole('مسؤول ثاني عن الإدارة المالكة') &&
        !$this->record->approved_by_second_owner_at
    ) {
        $this->record->approved_by_second_owner_at = Carbon::now();
    }

    if (
        $user?->hasRole('مسؤول أول عن الإدارة المالكة') &&
        !$this->record->approved_by_first_owner_at
    ) {
        $this->record->approved_by_first_owner_at = Carbon::now();
    }

    $this->record->save();
}
}
