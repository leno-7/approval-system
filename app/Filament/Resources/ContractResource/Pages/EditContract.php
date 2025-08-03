<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components as Components;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Illuminate\Validation\Rule;
use Filament\Notifications\Notification;

class EditContract extends EditRecord
{
    protected static string $resource = ContractResource::class;

    protected function resolveRecord(string|int $key): \Illuminate\Database\Eloquent\Model
    {
        return static::getModel()::with('projectRequest')->findOrFail($key);
    }

    public function form(Form $form): Form
    {
        $project = $this->record->projectRequest;

        return $form->schema([
            // 📌 معلومات المشروع
            Components\Section::make('معلومات المشروع')->schema([
                Components\Placeholder::make('project_number')->label('رقم المشروع')->content($project?->project_number ?? '—'),
                Components\Placeholder::make('project_name')->label('اسم المشروع')->content($project?->project_name ?? '—'),
                Components\Placeholder::make('owner_department')->label('الإدارة المالكة')->content($project?->owner_department ?? '—'),
                Components\Placeholder::make('project_type')->label('نوع المشروع')->content($project?->project_type ?? '—'),
                Components\Placeholder::make('project_description')->label('وصف المشروع')->content($project?->project_description ?? '—'),
                Components\Placeholder::make('suggested_vendors')->label('الموردين / المقاولين المقترحين')->content(fn () => is_array($project?->suggested_vendors) ? collect($project->suggested_vendors)->pluck('name')->implode(', ') : '—'),
                Components\Placeholder::make('specifications_attachment')->label('كراسة الشروط والمواصفات')->content(fn () => is_array($project?->specifications_attachment) ? implode(', ', $project->specifications_attachment) : '—'),
            ])->columns(2),

            // 📝 بيانات الطرح
            Components\Section::make('بيانات الطرح')->schema([
                Components\TextInput::make('offering_duration')->label('مدة الطرح')->required(),

                Components\Select::make('offering_method')
                    ->label('أسلوب الطرح')
                    ->options([
                        'منافسة عامة' => 'منافسة عامة',
                        'منافسة محدودة' => 'منافسة محدودة',
                        'شراء مباشر' => 'شراء مباشر',
                    ]),
                    

                Components\Toggle::make('is_preplanned')->label('يوجد تخطيط مسبق؟'),


                Components\FileUpload::make('submission_attachments')
                ->label('ملفات العرض')
                ->multiple()
                ->preserveFilenames()
                ->maxSize(10240) // 10 MB
                ->directory('contracts/attachments')
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                ->previewable(false) // يمنع تحميل الملف تلقائيًا في الصفحة
                ->reactive()
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    $estimatedValue = $this->record->projectRequest?->estimated_value ?? 0;
                
                    $max = $estimatedValue >= 5000000 ? 2 : 1;
                
                    if (is_array($state) && count($state) > $max) {
                        $set('submission_attachments', array_slice($state, 0, $max));
                
                        \Filament\Notifications\Notification::make()
                            ->title("يُسمح بـ $max ملف فقط لهذا المشروع")
                            ->danger()
                            ->send();
                    }
                }),
              
       


                ])->columns(2),

            // ✅ اعتمادات العقود
            Components\Section::make('اعتمادات العقود والمشتريات')
                ->visible(fn () => Auth::user()->hasAnyRole(['الموظف المختص للعقود', 'مدير العقود والمشتريات']))
                ->schema([
                    Components\Group::make([
                        Components\Toggle::make('approved_by_procurement_specialist')
                            ->label('اعتماد الموظف المختص للعقود'),

                        Components\DatePicker::make('approved_by_procurement_specialist_at')
                            ->label('تاريخ اعتماد الموظف المختص')
                            ->default(today())
                            ->displayFormat('Y-m-d')
                            ->dehydrated(),

                        Components\Textarea::make('procurement_specialist_notes')
                            ->label('ملاحظات الموظف المختص'),
                    ])->visible(fn () => Auth::user()->hasRole('الموظف المختص للعقود')),

                    Components\Group::make([
                        Components\Placeholder::make('اعتماد الموظف المختص')
                            ->label('اعتماد الموظف المختص للعقود')
                            ->content(fn ($record) => $record->approved_by_procurement_specialist ? 'معتمد' : 'غير معتمد'),

                        Components\Placeholder::make('تاريخ اعتماد الموظف المختص')
                            ->label('تاريخ الاعتماد')
                            ->content(fn ($record) => $record->approved_by_procurement_specialist_at
                                ? Carbon::parse($record->approved_by_procurement_specialist_at)->format('Y-m-d')
                                : '--'),

                        Components\Placeholder::make('ملاحظات الموظف المختص')
                            ->label('ملاحظات الموظف المختص')
                            ->content(fn ($record) => $record->procurement_specialist_notes ?? '--'),

                        Components\Toggle::make('approved_by_procurement_manager')
                            ->label('اعتماد مدير العقود والمشتريات'),

                        Components\DatePicker::make('approved_by_procurement_manager_at')
                            ->label('تاريخ اعتماد المدير')
                            ->default(today())
                            ->displayFormat('Y-m-d')
                            ->dehydrated(),

                        Components\Textarea::make('procurement_manager_notes')
                            ->label('ملاحظات المدير'),
                    ])->visible(fn () => Auth::user()->hasRole('مدير العقود والمشتريات')),
                ]),
        ]);
    }


    


    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ بيانات العقد بنجاح ✅';
    }

    
   /* protected function afterSave(): void
{
    $record = $this->record;

    // تحقق أن الطرفين اعتمدوا
    if (
        $record->approved_by_procurement_specialist &&
        $record->approved_by_procurement_manager
    ) {
        // هل فيه سجل سابق بالفعل في التخطيط؟ لا تنشئه مرتين
        $exists = \App\Models\PlanningGovernanceApproval::where('project_request_id', $record->project_request_id)->exists();

        if (! $exists) {
            \App\Models\PlanningGovernanceApproval::create([
                'project_request_id' => $record->project_request_id,
            ]);
        }
    }
} */


    protected function getRedirectUrl(): string
    {
        return ContractResource::getUrl();
    }
}
