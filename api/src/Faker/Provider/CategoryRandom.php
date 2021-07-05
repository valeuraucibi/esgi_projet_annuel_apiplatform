<?php

namespace App\Faker\Provider;

use Faker\Provider\Base as BaseProvider;

final class CategoryRandom extends BaseProvider
{
    public function nameRandom()
    {
        return self::randomElement([
            "Manteaux",
            "Chemises",
            "Costumes",
            "Ensembles",
            "Jeans",
            "Joggers",
            "Loungewear",
            "Maillots de bain",
            "Pantalons chinos",
            "Polos",
            "Shorts",
            "Survêtements",
            "Vestes",

        ]);
    }
}