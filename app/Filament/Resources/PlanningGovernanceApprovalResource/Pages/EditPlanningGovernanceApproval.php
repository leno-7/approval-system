<?php

namespace App\Filament\Resources\PlanningGovernanceApprovalResource\Pages;

use App\Filament\Resources\PlanningGovernanceApprovalResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components as Components;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EditPlanningGovernanceApproval extends EditRecord
{
    protected static string $resource = PlanningGovernanceApprovalResource::class;

    protected function resolveRecord(string|int $key): \Illuminate\Database\Eloquent\Model
    {
        return static::getModel()::with('projectRequest')->findOrFail($key);
    }

    public function form(Form $form): Form
    {
        $project = $this->record->projectRequest;

        return $form->schema([
            Components\Section::make('معلومات المشروع')->schema([
                Components\Placeholder::make('project_number')->label('رقم المشروع')->content($project?->project_number ?? '—'),
                Components\Placeholder::make('owner_department')->label('الإدارة المالكة')->content($project?->owner_department ?? '—'),
                Components\Placeholder::make('request_date')->label('تاريخ الطلب')->content(optional($project?->request_date)->format('Y-m-d') ?? '—'),
                Components\Placeholder::make('project_name')->label('اسم المشروع')->content($project?->project_name ?? '—'),
                Components\Placeholder::make('project_description')->label('وصف المشروع')->content($project?->project_description ?? '—'),
                Components\Placeholder::make('project_duration')->label('مدة التنفيذ')->content(
                    "{$project?->duration_year} سنة، {$project?->duration_month} شهر، {$project?->duration_day} يوم"
                ),
                Components\Placeholder::make('project_objectives')->label('الأهداف الاستراتيجية')->content(
                    is_array($project?->project_objectives)
                        ? implode(', ', $project->project_objectives)
                        : '—'
                ),
            ])->columns(2),

            Components\Section::make('الاعتمادات')->schema([
                Components\Group::make([
                    Components\Toggle::make('approved_by_planning_director')
                        ->label('اعتماد مدير الإدارة العامة للتخطيط والحوكمة'),
                    Components\DatePicker::make('approved_by_planning_director_at')
                        ->label('تاريخ الاعتماد')
                        ->default(today())
                        ->displayFormat('Y-m-d')
                        ->dehydrated(),
                    Components\Textarea::make('planning_director_notes')
                        ->label('ملاحظات المدير'),
                ])->visible(fn () => Auth::user()?->hasRole('مدير الإدارة العامة للتخطيط والحوكمة المؤسسية')),

                Components\Group::make([
                    Components\Placeholder::make('اعتماد مدير التخطيط')
                        ->label('اعتماد مدير التخطيط')
                        ->content(fn ($record) => $record->approved_by_planning_director ? 'معتمد' : 'غير معتمد'),
                    Components\Placeholder::make('تاريخ الاعتماد')
                        ->label('تاريخ اعتماد مدير التخطيط')
                        ->content(fn ($record) =>
                            $record->approved_by_planning_director_at
                                ? Carbon::parse($record->approved_by_planning_director_at)->format('Y-m-d')
                                : '--'
                        ),
                    Components\Placeholder::make('ملاحظات مدير التخطيط')
                        ->label('ملاحظات المدير')
                        ->content(fn ($record) => $record->planning_director_notes ?? '--'),
                    Components\Toggle::make('approved_by_ceo_assistant')
                        ->label('اعتماد مساعد الرئيس التنفيذي'),
                    Components\DatePicker::make('approved_by_ceo_assistant_at')
                        ->label('تاريخ اعتماد المساعد')
                        ->default(today())
                        ->displayFormat('Y-m-d')
                        ->dehydrated(),
                        
                    Components\Textarea::make('ceo_assistant_notes')
                        ->label('ملاحظات المساعد'),
                ])->visible(fn () => Auth::user()?->hasRole('مساعد الرئيس التنفيذي للتطوير المؤسسي')),
            ]),
        ]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ الاعتمادات بنجاح ✅';
    }

    protected function getRedirectUrl(): string
    {
        return PlanningGovernanceApprovalResource::getUrl();
    }

    protected function approvalView($label, $approved, $approvedAt, $notes): Components\Group
{
    return Components\Group::make([
        Components\Placeholder::make($label . '_status')
            ->label($label)
            ->content(fn () => $approved ? 'معتمد' : 'غير معتمد'),

        Components\Placeholder::make($label . '_date')
            ->label('تاريخ الاعتماد')
            ->content(fn () => $approvedAt ? \Carbon\Carbon::parse($approvedAt)->format('Y-m-d') : '--'),

        Components\Placeholder::make($label . '_notes')
            ->label('ملاحظات')
            ->content(fn () => $notes ?? '--'),
    ]);
}

}
