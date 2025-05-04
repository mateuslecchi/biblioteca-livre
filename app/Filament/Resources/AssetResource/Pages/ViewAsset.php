<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            // Actions\Action::make('createMovement')
            //     ->label('Registrar Movimentação')
            //     ->color('success')
            //     ->icon('heroicon-o-arrow-path')
            //     ->url(fn ($record) => route('filament.admin.resources.movements.create', ['asset_id' => $record->id]))
            //     ->openUrlInNewTab(),
        ];
    }
}
