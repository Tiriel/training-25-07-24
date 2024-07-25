<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DecadesMenu
{
    public array $decades = ['80', '90', '2000'];

    //public function __construct(MovieRepository $repository)
    //{
    //    $this->decades = $repository->findDecades();
    //}
}
