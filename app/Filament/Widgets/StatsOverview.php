<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Collection;
use App\Models\Movement;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Acervo', Collection::count())
                ->description('Quantidade de títulos no acervo.')
                ->descriptionIcon('heroicon-o-book-open', IconPosition::Before),
            Stat::make('Patrimônio', Asset::count())
                ->description('Quantidade de bens registrados.')
                ->descriptionIcon('heroicon-o-computer-desktop', IconPosition::Before),
            Stat::make('Movimentações', Movement::count())
                ->description('Movimentações de bens.')
                ->descriptionIcon('heroicon-o-arrows-right-left', IconPosition::Before),
        ];
    }
}
