<?php

namespace App\Filament\Resources;

use App\Enums\AssetStatus;
use App\Filament\Resources\AssetResource\Pages;
use App\Filament\Resources\AssetResource\RelationManagers;
use App\Filament\Resources\AssetResource\RelationManagers\MovementsRelationManager;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationLabel = 'Patrimônio';

    protected static ?string $modelLabel = 'Bem';

    protected static ?string $pluralModelLabel = 'Bens';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('location')
                            ->label('Local')
                            ->required()
                            ->maxLength(255)
                            ->visibleOn(['create','view'])
                            ->helperText('Conforme última movimentação.'),

                        Forms\Components\TextInput::make('location')
                            ->label('Local')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->visibleOn('edit')
                            ->helperText('Deve ser alterado através das movimentações.'),
                            
                        Forms\Components\DatePicker::make('acquisition_date')
                            ->label('Data de Aquisição')
                            ->required()
                            ->maxDate(now()),
                            
                        Forms\Components\TextInput::make('tag')
                            ->label('Etiqueta') 
                            ->helperText('Gerada automaticamente se não for informada')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('P-XXXXX')
                            ->dehydrated(fn ($state) => filled($state)),

                            Forms\Components\ToggleButtons::make('status')
                            ->label('Status')
                            ->options(AssetStatus::class)
                            ->required()
                            ->inline()
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Detalhes')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('location')
                    ->label('Local')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('acquisition_date')
                    ->label('Data de Aquisição')
                    ->date('d/m/Y')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                    
                Tables\Columns\TextColumn::make('tag')
                    ->label('Etiqueta')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(AssetStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Exportar')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename('Bens-'.date('Y-m-d-H-i'))
                    ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MovementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/criar'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/editar'),
        ];
    }
}
