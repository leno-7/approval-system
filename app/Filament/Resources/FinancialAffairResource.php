<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialAffairResource\Pages;
use App\Models\FinancialAffair;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms;

use Filament\Tables;
use Filament\Tables\Actions\Action;

use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\Auth;





class FinancialAffairResource extends Resource
{
    protected static ?string $model = FinancialAffair::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'الشؤون المالية';
    protected static ?string $pluralModelLabel = 'الشؤون المالية';
    protected static ?int $navigationSort = 4;

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form; // فاضي لأن بنستخدم صفحة الإيديت
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
                    ->label('عرض')
                    ->url(fn ($record) => route('filament.admin.resources.financial-affairs.edit', ['record' => $record->id]))

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
                'مدير المالية',
                'الموظف المختص المالية',
            ]);
        }
        

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialAffairs::route('/'),
            'edit' => Pages\EditFinancialAffair::route('/{record}/edit'),
            
        ];
    }
}
