<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SupportServiceApprovalResource\Pages;
use App\Models\SupportServiceApproval;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SupportServiceApprovalResource extends Resource
{
    protected static ?string $model = SupportServiceApproval::class;

    protected static ?string $navigationLabel = 'الخدمات المساندة';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $pluralModelLabel = 'الخدمات المساندة';

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
                    ->url(fn ($record) => route('filament.admin.resources.support-service-approvals.edit', ['record' => $record->id]))
                    ->icon('heroicon-o-pencil')
                    ->color('info'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('projectRequest');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupportServiceApprovals::route('/'),
            'edit' => Pages\EditSupportServiceApproval::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->hasAnyRole([
            'مساعد الرئيس التنفيذي للخدمات المساندة',
            // أو أضف أدوارًا أخرى لو تبغى تعرض لناس غيره
        ]);
    } 
}
