<?php

namespace App\Filament\Resources\SupportServiceApprovalResource\Pages;

use App\Filament\Resources\SupportServiceApprovalResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components as Components;
use Filament\Pages\Actions\Action;


class EditSupportServiceApproval extends EditRecord
{
    protected static string $resource = SupportServiceApprovalResource::class;

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
                Components\Placeholder::make('project_name')->label('اسم المشروع')->content($project?->project_name ?? '—'),
                Components\Placeholder::make('owner_department')->label('الإدارة المالكة')->content($project?->owner_department ?? '—'),
                Components\Placeholder::make('project_type')->label('نوع المشروع')->content($project?->project_type ?? '—'),
                Components\Placeholder::make('request_date')->label('تاريخ الطلب')->content(optional($project?->request_date)->format('Y-m-d') ?? '—'),
                Components\Placeholder::make('estimated_value')->label('القيمة التقديرية')->content($project?->estimated_value ?? '—'),
                Components\Placeholder::make('estimated_value_text')->label('كتابة القيمة التقديرية')->content($project?->estimated_value_text ?? '—'),
                Components\Grid::make(3)->schema([
                    Components\Placeholder::make('duration_year')->label('سنة')->content($project?->duration_year ?? '—'),
                    Components\Placeholder::make('duration_month')->label('شهر')->content($project?->duration_month ?? '—'),
                    Components\Placeholder::make('duration_day')->label('يوم')->content($project?->duration_day ?? '—'),
                ]),
                Components\Placeholder::make('project_description')->label('وصف المشروع')->content($project?->project_description ?? '—'),
                Components\Placeholder::make('project_scope')->label('نطاق المشروع')->content($project?->project_scope ?? '—'),
                Components\Placeholder::make('project_objectives')->label('الأهداف الاستراتيجية')->content(is_array($project?->project_objectives) ? implode(', ', $project->project_objectives) : '—'),
            ])->columns(2),
            Components\Section::make('الاعتمادات السابقة')->schema([
                $this->approvalView(
                    'اعتماد المسؤول الأول',
                    $project?->approved_by_first_owner,
                    $project?->approved_by_first_owner_at,
                    $project?->first_owner_notes
                ),
            
                $this->approvalView(
                    'اعتماد الموظف المختص المالي',
                    $project->financialAffair?->approved_by_specialist,
                    $project->financialAffair?->approved_by_specialist_at,
                    $project->financialAffair?->specialist_notes
                ),
            
                $this->approvalView(
                    'اعتماد مدير المالية',
                    $project->financialAffair?->approved_by_finance_director,
                    $project->financialAffair?->approved_by_finance_director_at,
                    $project->financialAffair?->finance_director_notes
                ),
            
                $this->approvalView(
                    'اعتماد موظف العقود',
                    $project->contract?->approved_by_procurement_specialist,
                    $project->contract?->approved_by_procurement_specialist_at,
                    $project->contract?->procurement_specialist_notes
                ),
            
                $this->approvalView(
                    'اعتماد مدير العقود',
                    $project->contract?->approved_by_procurement_manager,
                    $project->contract?->approved_by_procurement_manager_at,
                    $project->contract?->procurement_manager_notes
                ),
            
                $this->approvalView(
                    'اعتماد مكتب المشاريع',
                    $project->completion?->approved_by_pmo,
                    $project->completion?->approved_by_pmo_at,
                    $project->completion?->pmo_director_notes
                ),
            
                $this->approvalView(
                    'اعتماد مدير التخطيط والحوكمة',
                    $project->planningGovernanceApproval?->approved_by_planning_director,
                    $project->planningGovernanceApproval?->approved_by_planning_director_at,
                    $project->planningGovernanceApproval?->planning_director_notes
                ),
            
                $this->approvalView(
                    'اعتماد مساعد الرئيس التنفيذي',
                    $project->planningGovernanceApproval?->approved_by_ceo_assistant,
                    $project->planningGovernanceApproval?->approved_by_ceo_assistant_at,
                    $project->planningGovernanceApproval?->ceo_assistant_notes
                ),
            ])->columns(2),
            
            Components\Section::make('اعتماد الخدمات المساندة')->schema([
                Components\Toggle::make('approved_by_support_exec')
    ->label('اعتماد مساعد الرئيس التنفيذي للخدمات المساندة')
    ->dehydrated(),

Components\DatePicker::make('approved_by_support_exec_at')
    ->label('تاريخ الاعتماد')
    ->default(today())
    ->displayFormat('Y-m-d')
    ->dehydrated(),

Components\Textarea::make('support_exec_notes')
    ->label('ملاحظات')
    ->dehydrated(),

            ]),
            
        ]);
    }

    protected function approvalView($label, $approved, $date, $notes): Components\Group
{
    return Components\Group::make([
        Components\Placeholder::make($label)
            ->label($label)
            ->content($approved ? 'معتمد' : 'غير معتمد'),

        Components\Placeholder::make("تاريخ $label")
            ->label('تاريخ الاعتماد')
            ->content($date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : '--'),

        Components\Placeholder::make("ملاحظات $label")
            ->label('ملاحظات')
            ->content($notes ?? '--'),
    ]);
}



    public function getHeaderActions(): array
    {
        return [
  
        Action::make('معاينة')
        ->label('معاينة وطباعة')
        ->url(fn () => route('support-approval.preview', $this->record->id))
        ->openUrlInNewTab()
        ->icon('heroicon-o-eye'),
];
        
    }
    

    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ الاعتماد بنجاح ✅';
    }

    protected function getRedirectUrl(): string
    {
        return SupportServiceApprovalResource::getUrl();
    }

}
