<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectRequestCompletionResource\Pages;
use App\Models\ProjectRequest;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\Auth;




class ProjectRequestCompletionResource extends Resource
{
    protected static ?string $model = \App\Models\ProjectRequestCompletion::class;
    

    protected static ?string $navigationLabel = 'إدارة المشاريع';
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $pluralModelLabel = 'إدارة المشاريع';
    protected static ?int $navigationSort = 2;

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
                    ->url(fn ($record) => route('filament.admin.resources.project-request-completions.edit', ['record' => $record->id]))
                    ->color('info')
                    ->icon('heroicon-o-pencil'),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('projectRequest');
    }
    public static function canAccess(): bool
{
    return Auth::user()?->hasAnyRole([
        'مدير مكتب المشاريع',
        'الموظف المختص',
    ]);
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectRequestCompletions::route('/'),
            'edit' => Pages\EditProjectRequestCompletion::route('/{record}/edit'),
            'create' => Pages\CreateProjectRequestCompletion::route('/create'),
        ];
    }
}
