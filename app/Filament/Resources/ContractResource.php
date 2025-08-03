<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Models\Contract;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'العقود والمشتريات';
    protected static ?string $modelLabel = 'عقد';
    protected static ?string $pluralModelLabel = 'العقود';

    public static function form(Forms\Form $form): Forms\Form
    {
        // ما راح نستخدمه لأننا نكتب النموذج في EditContract
        return $form;
    }

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
                ->url(fn ($record) => route('filament.admin.resources.contracts.edit', ['record' => $record->id]))
                ->color('info')
                ->icon('heroicon-o-pencil'),
        ])
        ->bulkActions([]);

    }
    public static function canAccess(): bool
{
    return auth()->check() && auth()->user()->hasAnyRole([
        'مدير العقود والمشتريات',
        'الموظف المختص للعقود',
    ]);
}


    public static function getPages(): array
    {
        return [
           'index' => Pages\ListContracts::route('/'),
           'edit' => Pages\EditContract::route('/{record}/edit'),

        ];
    }
}
