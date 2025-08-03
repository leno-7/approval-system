<?php

namespace App\Filament\Resources\FinancialAffairResource\Pages;

use App\Filament\Resources\FinancialAffairResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components as Components;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EditFinancialAffair extends EditRecord
{
    protected static string $resource = FinancialAffairResource::class;

    protected function resolveRecord(string|int $key): \Illuminate\Database\Eloquent\Model
    {
        return static::getModel()::with([
            'projectRequest',
            'projectRequest.financialAffair',
            'projectRequest.contract',
            'projectRequest.completion',
            'projectRequest.planningGovernanceApproval',
        ])->findOrFail($key);
    }
    
    public function form(Form $form): Form
    {
        $project = $this->record->projectRequest;

        return $form->schema([
            // معلومات من طلب المشروع
            Components\Section::make('معلومات المشروع')->schema([
                Components\Placeholder::make('project_number')->label('رقم المشروع')->content($project?->project_number ?? '—'),
                Components\Placeholder::make('owner_department')->label('الإدارة المالكة')->content($project?->owner_department ?? '—'),
                Components\Placeholder::make('request_date')->label('تاريخ الطلب')->content(optional($project?->request_date)->format('Y-m-d') ?? '—'),
                Components\Placeholder::make('project_name')->label('اسم المشروع')->content($project?->project_name ?? '—'),
                Components\Placeholder::make('project_type')->label('نوع المشروع')->content($project?->project_type ?? '—'),
                Components\Placeholder::make('estimated_value')->label('القيمة التقديرية')->content($project?->estimated_value ?? '—'),
                Components\Placeholder::make('duration_year')->label('سنة')->content($project?->duration_year ?? '—'),
                Components\Placeholder::make('duration_month')->label('شهر')->content($project?->duration_month ?? '—'),
                Components\Placeholder::make('duration_day')->label('يوم')->content($project?->duration_day ?? '—'),
            ])->columns(2),

            // بيانات الارتباط المالي
            Components\Section::make('بيانات الارتباط المالي')->schema([
                Components\Select::make('has_financial_approval')
                    ->label('يوجد اعتماد مالي؟')
                    ->options(['نعم' => 'نعم', 'لا' => 'لا'])
                    ->required()
                    ->dehydrated(),
            
                Components\TextInput::make('item_name')
                    ->label('اسم البند')
                    ->required()
                    ->dehydrated(),
            
                Components\TextInput::make('item_number')
                    ->label('رقم البند')
                    ->numeric()
                    ->required()
                    ->dehydrated(),
            
                Components\DatePicker::make('attachment_date')
                    ->label('تاريخ الارتباط')
                    ->default(now())
                    ->required()
                    ->dehydrated(),
                    
                    Components\TextInput::make('attachment_number')
                    ->label('رقم الارتباط')
                    ->numeric()
                    ->required()
                    ->dehydrated(),
            
                Components\TextInput::make('attachment_amount')
                    ->label('مبلغ الارتباط')
                    ->numeric()
                    ->required()
                    ->dehydrated(),
            

            
            ])->columns(2),

           // الاعتمادات
Components\Section::make('اعتمادات المشروع')
->visible(fn () => Auth::user()->hasAnyRole([
    'الموظف المختص المالية',
    'مدير المالية',
]))
->schema([

    // ✅ الموظف المختص للمالية
    Components\Group::make([
        Components\Toggle::make('approved_by_specialist')
            ->label('اعتماد الموظف المختص المالية'),

        Components\DatePicker::make('approved_by_specialist_at')
            ->label('تاريخ اعتماد الموظف المختص المالية')
            ->default(today())

            ->displayFormat('Y-m-d')
            ->dehydrated(),

        Components\Textarea::make('specialist_notes')
            ->label('ملاحظات الموظف المختص المالية'),
    ])->visible(fn () => Auth::user()->hasRole('الموظف المختص المالية')),

    // ✅ مدير المالية
    Components\Group::make([
        Components\Placeholder::make('اعتماد الموظف المختص')
            ->label('اعتماد الموظف المختص المالية')
            ->content(fn ($record) => $record->approved_by_specialist ? 'معتمد' : 'غير معتمد'),

        Components\Placeholder::make('تاريخ اعتماد الموظف المختص')
            ->label('تاريخ الاعتماد')
            ->content(fn ($record) =>
                $record->approved_by_specialist_at
                    ? Carbon::parse($record->approved_by_specialist_at)->format('Y-m-d')
                    : '--'
            ),

        Components\Placeholder::make('ملاحظات الموظف المختص')
            ->label('ملاحظات الموظف المختص المالية')
            ->content(fn ($record) => $record->specialist_notes ?? '--'),

        Components\Toggle::make('approved_by_finance_director')
            ->label('اعتماد مدير المالية'),

        Components\DatePicker::make('approved_by_finance_director_at')
            ->label('تاريخ اعتماد مدير المالية')
            ->default(today())

            ->displayFormat('Y-m-d')
            ->dehydrated(),

        Components\Textarea::make('finance_director_notes')
            ->label('ملاحظات مدير المالية'),
    ])->visible(fn () => Auth::user()->hasRole('مدير المالية')),
])

        ]);
    }
  


    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ بيانات الاعتمادات بنجاح ✅';
    }

    protected function getRedirectUrl(): string
    {
        return FinancialAffairResource::getUrl();
    }
}
