<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectRequestResource\Pages;
use App\Models\ProjectRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Facades\Auth; 
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components as Components;


class ProjectRequestResource extends Resource
{
    protected static ?string $model = ProjectRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'طلب الشراء الرقمي';
    protected static ?string $pluralModelLabel = 'طلب الشراء الرقمي';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $disableFields = fn () => auth()->user()->hasAnyRole([
            'مدير الإدارة المالكة',
            'مسؤول ثاني عن الإدارة المالكة',
            'مسؤول أول عن الإدارة المالكة',
        ]);

        return $form->schema([
            TextInput::make('project_number')
                ->label('رقم المشروع')
                ->disabled()
                ->dehydrated(false)
                ->default(fn ($livewire) => 
                    $livewire->record?->project_number ?? (\App\Models\ProjectRequest::max('project_number') ?? 0) + 1
                ),

            DatePicker::make('request_date')
                ->label('تاريخ الطلب')
                ->default(now())
                ->disabled($disableFields),

            Select::make('owner_department')
                ->label('الإدارة المالكة')
                ->options([
                    'الإدارة الأولى' => 'الإدارة الأولى',
                    'الإدارة الثانية' => 'الإدارة الثانية',
                ])
                ->searchable()
                ->disabled($disableFields),

            TextInput::make('project_name')
                ->label('اسم المشروع')
                ->required()
                ->disabled($disableFields),

            TextInput::make('estimated_value')
                ->label('القيمة التقديرية')
                ->numeric()
                ->required()
                ->live()
                ->disabled($disableFields),

            TextInput::make('estimated_value_text')
                ->label('القيمة التقديرية (كتابة)')
                ->disabled()
                ->dehydrated(true),

            FileUpload::make('specifications_attachment')
                ->label('كراسة الشروط والمواصفات')
                ->multiple()
                ->directory('attachments')
                ->visibility('private')
                ->disabled($disableFields),

            Select::make('project_type')
                ->label('نوع المشروع')
                ->options([
                    'نوع 1' => 'نوع 1',
                    'نوع 2' => 'نوع 2',
                    'نوع 3' => 'نوع 3',
                ])
                ->required()
                ->searchable()
                ->disabled($disableFields),

                Components\Section::make('مدة التنفيذ ')
                ->schema([
                    Components\Grid::make(3)->schema([
                        Components\TextInput::make('duration_day')->label('يوم')->numeric()->required()->disabled($disableFields),
                        Components\TextInput::make('duration_month')->label('شهر')->numeric()->required()->disabled($disableFields),
                        Components\TextInput::make('duration_year')->label('سنة')->numeric()->required()->disabled($disableFields),
                    ])
                    ]),

            Textarea::make('project_description')
                ->label('وصف المشروع')
                ->rows(3)
                ->required()
                ->disabled($disableFields),

            Textarea::make('project_scope')
                ->label('نطاق عمل المشروع')
                ->rows(3)
                ->required()
                ->disabled($disableFields),

            Select::make('project_objectives')
                ->label('الأهداف الاستراتيجية المرتبطة بالمشروع')
                ->multiple()
                ->options([
                    'رفع الكفاءة' => 'رفع الكفاءة',
                    'رقمنة العمليات' => 'رقمنة العمليات',
                    'تقليل التكاليف' => 'تقليل التكاليف',
                ])
                ->searchable()
                ->disabled($disableFields),

           

            Textarea::make('notes')
                ->label('الملاحظات')
                ->rows(3)
                ->disabled($disableFields),

                Repeater::make('suggested_vendors')
                ->label('الموردين / المقاولين المقترحين')
                ->schema([
                    TextInput::make('name')->label('الاسم')->disabled($disableFields),
                    TextInput::make('contact')->label('التواصل')->disabled($disableFields),
                ])
                ->columns(2)
                ->disabled($disableFields),

                 // ✅ اعتماد مدير الإدارة المالكة
        
Section::make('اعتمادات الإدارة المالكة')
    ->schema([
        // ✅ مدير الإدارة المالكة
        Toggle::make('approved_by_owner_director')
            ->label('اعتماد مدير الإدارة المالكة')
            ->visible(fn () => Auth::user()->hasRole('مدير الإدارة المالكة')),

        DatePicker::make('approved_by_owner_director_at')
            ->label('تاريخ اعتماد مدير الإدارة المالكة')
            ->displayFormat('Y-m-d')
            ->default(now())
            ->dehydrated()
            ->visible(fn () => Auth::user()->hasRole('مدير الإدارة المالكة')),

        Textarea::make('owner_director_notes')
            ->label('ملاحظات مدير الإدارة المالكة')
            ->visible(fn () => Auth::user()->hasRole('مدير الإدارة المالكة')),

        // ✅ المسؤول الثاني
        Placeholder::make('عرض اعتماد المدير')
            ->label('اعتماد مدير الإدارة المالكة')
            ->content(fn ($record) =>
                $record->approved_by_owner_director ? 'معتمد' : 'غير معتمد'
            )
            ->visible(fn () => Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة')),

        Placeholder::make('تاريخ اعتماد المدير')
            ->label('تاريخ اعتماد المدير')
            ->content(fn ($record) =>
                $record->approved_by_owner_director_at
                    ? \Carbon\Carbon::parse($record->approved_by_owner_director_at)->format('Y-m-d')
                    : '--'
            )
            ->visible(fn () => Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة')),

        Placeholder::make('ملاحظات المدير')
            ->label('ملاحظات مدير الإدارة المالكة')
            ->content(fn ($record) => $record->owner_director_notes ?? '--')
            ->visible(fn () => Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة')),

        Toggle::make('approved_by_second_owner')
            ->label('اعتماد المسؤول الثاني')
            ->visible(fn () => Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة')),

        DatePicker::make('approved_by_second_owner_at')
         ->label('تاريخ اعتماد المسؤول الثاني')
         ->displayFormat('Y-m-d')
         ->default(fn ($record) => $record->approved_by_second_owner_at ?? now())
         ->dehydrated()
         ->visible(fn () => Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة')),

         
        Textarea::make('second_owner_notes')
            ->label('ملاحظات المسؤول الثاني')
            ->visible(fn () => Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة')),

        // ✅ المسؤول الأول
        Placeholder::make('اعتماد مدير الإدارة المالكة للأول')
            ->label('اعتماد مدير الإدارة المالكة')
            ->content(fn ($record) =>
                $record->approved_by_owner_director ? 'معتمد' : 'غير معتمد'
            )
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Placeholder::make('تاريخ اعتماد المدير للأول')
            ->label('تاريخ اعتماد المدير')
            ->content(fn ($record) =>
                $record->approved_by_owner_director_at
                    ? \Carbon\Carbon::parse($record->approved_by_owner_director_at)->format('Y-m-d')
                    : '--'
            )
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Placeholder::make('ملاحظات المدير للأول')
            ->label('ملاحظات مدير الإدارة المالكة')
            ->content(fn ($record) => $record->owner_director_notes ?? '--')
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Placeholder::make('اعتماد المسؤول الثاني للأول')
            ->label('اعتماد المسؤول الثاني')
            ->content(fn ($record) =>
                $record->approved_by_second_owner ? 'معتمد' : 'غير معتمد'
            )
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Placeholder::make('تاريخ اعتماد المسؤول الثاني للأول')
            ->label('تاريخ اعتماد المسؤول الثاني')
            ->content(fn ($record) =>
                $record->approved_by_second_owner_at
                    ? \Carbon\Carbon::parse($record->approved_by_second_owner_at)->format('Y-m-d')
                    : '--'
            )
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Placeholder::make('ملاحظات المسؤول الثاني للأول')
            ->label('ملاحظات المسؤول الثاني')
            ->content(fn ($record) => $record->second_owner_notes ?? '--')
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Toggle::make('approved_by_first_owner')
            ->label('اعتماد المسؤول الأول')
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        DatePicker::make('approved_by_first_owner_at')
            ->label('تاريخ اعتماد المسؤول الأول')
            ->displayFormat('Y-m-d')
            ->default(now())
            ->dehydrated()
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),

        Textarea::make('first_owner_notes')
            ->label('ملاحظات المسؤول الأول')
            ->visible(fn () => Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')),
    ])
    ->visible(fn () =>
        Auth::user()->hasRole('مدير الإدارة المالكة') ||
        Auth::user()->hasRole('مسؤول ثاني عن الإدارة المالكة') ||
        Auth::user()->hasRole('مسؤول أول عن الإدارة المالكة')
    )


    
         ]); 

}

      

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_number')->label('رقم المشروع')->searchable(),
                Tables\Columns\TextColumn::make('request_date')->label('تاريخ الطلب')->date(),
                Tables\Columns\TextColumn::make('project_name')->label('اسم المشروع')->searchable(),
                Tables\Columns\TextColumn::make('project_type')->label('نوع المشروع'),
                Tables\Columns\TextColumn::make('project_level')->label('مستوى المشروع'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function canAccess(): bool
    {
        return ! auth()->user()?->hasAnyRole([
            'مدير المالية',
            'الموظف المختص المالية',
            'مدير العقود والمشتريات',
            'الموظف المختص للعقود',
            'مدير مكتب المشاريع',
            'الموظف المختص',
            'مساعد الرئيس التنفيذي للخدمات المساندة',
            'مدير الإدارة العامة للتخطيط والحوكمة المؤسسية',
            'مساعد الرئيس التنفيذي للتطوير المؤسسي',
            
        ]);
    }
    

    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectRequests::route('/'),
            'create' => Pages\CreateProjectRequest::route('/create'),
            'edit' => Pages\EditProjectRequest::route('/{record}/edit'),
        ];
    }

    public function completion()
    {
        return $this->hasOne(\App\Models\ProjectRequestCompletion::class);
    }
}
