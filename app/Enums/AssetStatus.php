<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AssetStatus: string implements HasColor, HasIcon, HasLabel
{
    case ATIVO = 'ativo';
    case INATIVO = 'inativo';
    case MANUTENCAO = 'manutencao';
    case EMPRESTADO = 'emprestado';
    case DESCARTADO = 'descartado';

    public function getLabel(): string
    {
        return match ($this) {
            self::ATIVO => 'Ativo',
            self::INATIVO => 'Inativo',
            self::MANUTENCAO => 'Manutencao',
            self::EMPRESTADO => 'Emprestado',
            self::DESCARTADO => 'Descartado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ATIVO => 'success',
            self::INATIVO => 'gray',
            self::MANUTENCAO => 'warning',
            self::EMPRESTADO => 'info',
            self::DESCARTADO => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ATIVO => 'heroicon-s-check',
            self::INATIVO => 'heroicon-o-pause',
            self::MANUTENCAO => 'heroicon-s-wrench',
            self::EMPRESTADO => 'heroicon-s-arrow-path',
            self::DESCARTADO => 'heroicon-s-trash',
        };
    }
}