<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Asset;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationLabel = 'Movimentações';

    protected static ?string $modelLabel = 'Movimentação';

    protected static ?string $pluralModelLabel = 'Movimentações';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('asset_id')
                            ->label('Bem')
                            ->relationship('asset', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\TextInput::make('tag')
                                    ->label('Etiqueta')
                                    ->required()
                                    ->unique(),
                            ]),
                            
                        Forms\Components\TextInput::make('origin_location')
                            ->label('Local de Origem')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('destination_location')
                            ->label('Local de Destino')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('responsible')
                            ->label('Responsável')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Detalhes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Observações')
                            ->maxLength(65535),
                    ]),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.name')
                    ->label('Bem')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('asset.tag')
                    ->label('Etiqueta')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('origin_location')
                    ->label('Local de Origem')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('destination_location')
                    ->label('Local de Destino')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('responsible')
                    ->label('Responsável')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data da Movimentação')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('asset')
                    ->multiple()
                    ->relationship('asset','name', fn (Builder $query) => $query->whereHas('movements'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Exportar')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename('Movimentações-'.date('Y-m-d-H-i'))
                    ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/criar'),
            'view' => Pages\ViewMovement::route('/{record}'),
            'edit' => Pages\EditMovement::route('/{record}/editar'),
        ];
    }
}
