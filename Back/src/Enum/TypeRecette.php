<?php

namespace App\Enum;

enum TypeRecette: string
{
    case ENTREE = 'TYPE_ENTREE';
    case PLAT = 'TYPE_PLAT';
    case DESSERT = 'TYPE_DESSERT';
    case APERITIF = 'TYPE_APERITIF';
}
