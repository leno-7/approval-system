<?php

namespace App\Filament\Resources\ProjectRequestCompletionResource\Pages;

use App\Filament\Resources\ProjectRequestCompletionResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components as Components;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EditProjectRequestCompletion extends EditRecord
{
    protected static string $resource = ProjectRequestCompletionResource::class;

    protected function resolveRecord(string|int $key): \Illuminate\Database\Eloquent\Model
    {
        return static::getModel()::with('projectRequest')->findOrFail($key);
    }

    public function form(Form $form): Form
    {
        $project = $this->record->projectRequest;

        return $form->schema([
            // معلومات المشروع الأصلية (عرض فقط)
            Components\Section::make('معلومات المشروع')->schema([
                Components\Placeholder::make('project_number')->label('رقم المشروع')->content($project?->project_number ?? '—'),
                Components\Placeholder::make('owner_department')->label('الإدارة المالكة')->content($project?->owner_department ?? '—'),
                Components\Placeholder::make('request_date')->label('تاريخ الطلب')->content(optional($project?->request_date)->format('Y-m-d') ?? '—'),
                Components\Placeholder::make('project_name')->label('اسم المشروع')->content($project?->project_name ?? '—'),
                Components\Placeholder::make('project_type')->label('نوع المشروع')->content($project?->project_type ?? '—'),
                Components\Placeholder::make('project_level')->label('مستوى المشروع')->content($project?->project_level ?? '—'),
                Components\Placeholder::make('estimated_value')->label('القيمة التقديرية')->content($project?->estimated_value ?? '—'),
                Components\Placeholder::make('estimated_value_text')->label('القيمة التقديرية كتابة')->content($project?->estimated_value_text ?? '—'),
                Components\Placeholder::make('project_description')->label('وصف المشروع')->content($project?->project_description ?? '—'),
                Components\Placeholder::make('project_scope')->label('نطاق المشروع')->content($project?->project_scope ?? '—'),
                Components\Placeholder::make('project_objectives')->label('الأهداف الاستراتيجية')->content(is_array($project?->project_objectives) ? implode(', ', $project->project_objectives) : '—'),
                Components\Placeholder::make('suggested_vendors')->label('الموردين / المقاولين المقترحين')->content(function () use ($project) {
                    if (!is_array($project?->suggested_vendors)) return '—';
                    return collect($project->suggested_vendors)->map(fn($vendor) => ($vendor['name'] ?? '') . ' - ' . ($vendor['contact'] ?? ''))->implode(', ');
                }),
            ])->columns(2),

            Components\Section::make('إكمال بيانات المشروع')->schema([
                Components\Select::make('project_status')
                    ->label('حالة أمر الشراء')
                    ->options([
                        'يتطلب دراسة فنية' => 'يتطلب دراسة فنية',
                        'غير فني (أمر هندسي)' => 'غير فني (أمر هندسي)',
                    ])
                    ->required()
                    ->reactive()
                    ->default('غير فني (أمر هندسي)'), // أو احذفها لو ما تبغى قيمة افتراضية
            
                    Components\Select::make('request_type')
                    ->label('يتطلب شؤون هندسية')
                    ->options(['نعم' => 'نعم', 'لا' => 'لا'])
                    ->dehydrated()
                    ->nullable(),
                
            
                Components\Textarea::make('related_projects')
                    ->label('الارتباط بمشاريع أخرى')
                    ->dehydrated(), // مهم للحفظ
            ])
            ->columns(2), // اختياري للتنسيق
            

            // معلومات الإكمال (مدخلات المستخدم)
            Components\Section::make('اعتمادات المشروع')
            ->visible(fn () => Auth::user()->hasAnyRole(['مدير مكتب المشاريع', 'الموظف المختص']))
            ->schema([
        
                // ✅ الموظف المختص: يدخل الاعتماد
                Components\Group::make([
                    Components\Toggle::make('approved_by_specialist')
                        ->label('اعتماد الموظف المختص'),
        
                    Components\DatePicker::make('approved_by_specialist_at')
                        ->label('تاريخ اعتماد الموظف المختص')
                        ->default(today())
                        ->displayFormat('Y-m-d')
                        ->dehydrated(),
        
                    Components\Textarea::make('specialist_notes')
                        ->label('ملاحظات الموظف المختص'),
                ])->visible(fn () => Auth::user()->hasRole('الموظف المختص')),
        
                // ✅ مدير مكتب المشاريع: يعرض اعتماد المختص ويدخل اعتماده
                Components\Group::make([
                    Components\Placeholder::make('اعتماد الموظف المختص')
                        ->label('اعتماد الموظف المختص')
                        ->content(fn ($record) => $record->approved_by_specialist ? 'معتمد' : 'غير معتمد'),
        
                    Components\Placeholder::make('تاريخ اعتماد الموظف المختص')
                        ->label('تاريخ اعتماد الموظف المختص')
                        ->content(fn ($record) => $record->approved_by_specialist_at
                            ? Carbon::parse($record->approved_by_specialist_at)->format('Y-m-d')
                            : '--'),
        
                    Components\Placeholder::make('ملاحظات الموظف المختص')
                        ->label('ملاحظات الموظف المختص')
                        ->content(fn ($record) => $record->specialist_notes ?? '--'),
        
                    Components\Toggle::make('approved_by_pmo')
                        ->label('اعتماد مدير مكتب المشاريع'),
        
                    Components\DatePicker::make('approved_by_pmo_at')
                        ->label('تاريخ اعتماد مدير المكتب')
                        ->default(today())
                        ->displayFormat('Y-m-d')
                        ->dehydrated(),
        
                    Components\Textarea::make('pmo_director_notes')
                        ->label('ملاحظات مدير المكتب'),
                ])->visible(fn () => Auth::user()->hasRole('مدير مكتب المشاريع')),
            ])
        ]);
    }
    


    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ بيانات الاعتمادات بنجاح ✅';
    }

    protected function getRedirectUrl(): string
    {
        return ProjectRequestCompletionResource::getUrl();
    }
}
