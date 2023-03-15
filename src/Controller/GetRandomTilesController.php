<?php

namespace App\Controller;

use App\Repository\TileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetRandomTilesController extends AbstractController
{
    public function __construct(
        private readonly TileRepository $tileRepository,
    ) {
    }

    public function __invoke(Request $request)
    {
        $limit = $request->query->get('limit');

        return $this->tileRepository->getRandomTiles($limit);
    }
}
