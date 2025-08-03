<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanningGovernanceApprovalResource\Pages;
use App\Models\PlanningGovernanceApproval;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PlanningGovernanceApprovalResource extends Resource
{
    protected static ?string $model = PlanningGovernanceApproval::class;

    protected static ?string $navigationLabel = 'اعتمادات التخطيط والحوكمة';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $pluralModelLabel = 'اعتمادات التخطيط والحوكمة';

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery())
            ->columns([
                Tables\Columns\TextColumn::make('projectRequest.project_number')->label('رقم المشروع'),
                Tables\Columns\TextColumn::make('projectRequest.project_name')->label('اسم المشروع'),
                Tables\Columns\TextColumn::make('projectRequest.owner_department')->label('الإدارة المالكة'),
            ])
            ->actions([
                Action::make('edit')
                    ->label('عرض / تعديل')
                    ->url(fn ($record) => route('filament.admin.resources.planning-governance-approvals.edit', ['record' => $record->id]))
                    ->color('info')
                    ->icon('heroicon-o-pencil'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('projectRequest');
    }

    public static function getPages(): array
    {
        return [
            'edit' => Pages\EditPlanningGovernanceApproval::route('/{record}/edit'),
            'index' => Pages\ListPlanningGovernanceApprovals::route('/'),
        ];
    }

    public static function canAccess(): bool
{
    return Auth::user()?->hasAnyRole([
        'مدير الإدارة العامة للتخطيط والحوكمة المؤسسية',
      'مساعد الرئيس التنفيذي للتطوير المؤسسي',
    ]);
}
}
