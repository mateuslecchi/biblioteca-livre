<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Models\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Acervo';

    protected static ?string $modelLabel = 'Acervo';

    protected static ?string $slug = 'acervo';

    protected static ?string $pluralModelLabel = 'Acervo';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('author')
                            ->label('Autor')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantidade')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                            
                        Forms\Components\TextInput::make('collection_name')
                            ->label('Coleção')
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('tag')
                            ->label('Etiqueta')
                            ->helperText('Gerada automaticamente se não for informada')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('L-XXXXX')
                            ->dehydrated(fn ($state) => filled($state)),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Detalhes')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3),
                            
                        Forms\Components\Textarea::make('notes')
                            ->label('Observações')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('author')
                    ->label('Autor')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantidade')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('collection_name')
                    ->label('Coleção')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->limit(13),
                    
                Tables\Columns\TextColumn::make('tag')
                    ->label('Etiqueta')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/criar'),
            'edit' => Pages\EditCollection::route('/{record}/editar'),
            // 'view' => Pages\ViewCollection::route('/{record}'),
        ];
    }
}
