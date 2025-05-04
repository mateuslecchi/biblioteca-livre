<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $recordTitleAttribute = 'id';
    
    protected static ?string $title = 'Movimentações';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('origin_location')
                    ->label('Local de Origem')
                    ->required()
                    ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->location)
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('destination_location')
                    ->label('Local de Destino')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('responsible')
                    ->label('Responsável')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Textarea::make('notes')
                    ->label('Observações')
                    ->maxLength(65535),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('origin_location')
                    ->label('Local de Origem')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('destination_location')
                    ->label('Local de Destino')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('responsible')
                    ->label('Responsável')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data da Movimentação')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nova Movimentação')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['asset_id'] = $this->ownerRecord->id;
                        return $data;
                    }),
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
}
