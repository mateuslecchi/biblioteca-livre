<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                            // ->default($assetId)
                            // ->disabled(filled($assetId))
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
                            // ->default(function () use ($assetId) {
                            //     if ($assetId) {
                            //         $asset = Asset::find($assetId);
                            //         return $asset ? $asset->location : '';
                            //     }
                            //     return '';
                            // }),
                            
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
            // ->afterSave(function (Movement $movement) {
            //     // Atualiza a localização do bem após a movimentação
            //     $asset = $movement->asset;
            //     $asset->location = $movement->destination_location;
            //     $asset->save();
            // });
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
