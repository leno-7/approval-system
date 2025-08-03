<?php

namespace App\Filament\Resources\ProjectRequestCompletionResource\Pages;

use App\Filament\Resources\ProjectRequestCompletionResource;
use App\Models\ProjectRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

class CreateProjectRequestCompletion extends CreateRecord
{
    protected static string $resource = ProjectRequestCompletionResource::class;

    public function form(Form $form): Form
    {
        $projectId = request()->get('project_request_id');
        $project = ProjectRequest::find($projectId);

        return $form->schema([
            Components\Hidden::make('project_request_id')
                ->default($projectId)
                ->required(),

            // معلومات المشروع الأصلية (عرض فقط)
            Components\Placeholder::make('project_number')
                ->label('رقم المشروع')
                ->content($project?->project_number ?? '—'),

            Components\Placeholder::make('owner_department')
                ->label('الإدارة المالكة')
                ->content($project?->owner_department ?? '—'),

            Components\Placeholder::make('request_date')
                ->label('تاريخ الطلب')
                ->content(optional($project?->request_date)->format('Y-m-d') ?? '—'),

            Components\Placeholder::make('project_name')
                ->label('اسم المشروع')
                ->content($project?->project_name ?? '—'),

            Components\Placeholder::make('project_type')
                ->label('نوع المشروع')
                ->content($project?->project_type ?? '—'),

            Components\Placeholder::make('project_level')
                ->label('مستوى المشروع')
                ->content($project?->project_level ?? '—'),

            Components\Placeholder::make('estimated_value')
                ->label('القيمة التقديرية')
                ->content($project?->estimated_value ?? '—'),

            Components\Placeholder::make('estimated_value_text')
                ->label('القيمة التقديرية كتابة')
                ->content($project?->estimated_value_text ?? '—'),

            Components\Placeholder::make('project_description')
                ->label('وصف المشروع')
                ->content($project?->project_description ?? '—'),

            Components\Placeholder::make('project_scope')
                ->label('نطاق المشروع')
                ->content($project?->project_scope ?? '—'),

            Components\Placeholder::make('project_objectives')
                ->label('الأهداف الاستراتيجية')
                ->content(is_array($project?->project_objectives)
                    ? implode(', ', $project->project_objectives)
                    : '—'),

            Components\Placeholder::make('suggested_vendors')
                ->label('الموردين / المقاولين المقترحين')
                ->content(function () use ($project) {
                    if (!is_array($project?->suggested_vendors)) return '—';
                    return collect($project->suggested_vendors)
                        ->map(fn($vendor) => ($vendor['name'] ?? '') . ' - ' . ($vendor['contact'] ?? ''))
                        ->implode(', ');
                }),

            // معلومات الإكمال
            Components\Section::make('إكمال بيانات المشروع')->schema([
                Components\Select::make('project_status')
                    ->label('حالة أمر الشراء')
                    ->options([
                        'يتطلب دراسة فنية' => 'يتطلب دراسة فنية',
                        'غير فني (أمر هندسي)' => 'غير فني (أمر هندسي)',
                    ])
                    ->required(),

                Components\Select::make('request_type')
                    ->label('يتطلب شؤون هندسية')
                    ->options(['نعم' => 'نعم', 'لا' => 'لا'])
                    ->visible(fn ($get) => $get('project_status') === 'يتطلب دراسة فنية'),

                Components\Textarea::make('related_projects')
                    ->label('الارتباط بمشاريع أخرى'),
            ]),

           /*
             // ✳️ اعتمادات المشروع (تظهر فقط حسب الدور)
            Components\Section::make('اعتمادات المشروع')
                ->visible(fn () =>
                    Auth::user()->hasRole('مدير مكتب المشاريع') ||
                    Auth::user()->hasRole('موظف مختص')
                )
                ->schema([
                    Components\Toggle::make('approved_by_pmo')
                        ->label('اعتماد مدير مكتب المشاريع')
                        ->visible(fn () => Auth::user()->hasRole('مدير مكتب المشاريع')),

                    Components\Textarea::make('pmo_notes')
                        ->label('ملاحظات PMO')
                        ->visible(fn () => Auth::user()->hasRole('مدير مكتب المشاريع')),

                    Components\Toggle::make('approved_by_specialist')
                        ->label('اعتماد الموظف المختص')
                        ->visible(fn () => Auth::user()->hasRole('موظف مختص')),

                    Components\Textarea::make('specialist_notes')
                        ->label('ملاحظات الموظف المختص')
                        ->visible(fn () => Auth::user()->hasRole('موظف مختص')),
                ]), */
        ]);
    }
}
