<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Resources\MovementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMovement extends ViewRecord
{
    protected static string $resource = MovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('viewAsset')
                ->label('Ver Bem')
                ->color('info')
                ->icon('heroicon-o-computer-desktop')
                ->url(fn ($record) => route('filament.admin.resources.assets.view', ['record' => $record->asset_id]))
                ->openUrlInNewTab(),
        ];
    }
}
