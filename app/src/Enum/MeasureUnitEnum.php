<?php

namespace App\Enum;

enum MeasureUnitEnum: string
{
    case Kilogram = 'kg';
    case Gram = 'g';
    case Liter = 'L';
    case Centiliter = 'cl';

    case Unit = 'u';
}