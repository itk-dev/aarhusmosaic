<?php

namespace App\Controller;

use App\Repository\TileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetRandomTilesController extends AbstractController
{
    private const MAX_ALLOWED_RESULTS = 100;

    public function __construct(
        private readonly TileRepository $tileRepository,
    ) {
    }

    public function __invoke(Request $request)
    {
        $limit = (int) $request->query->get('limit');
        $limit = min(self::MAX_ALLOWED_RESULTS, $limit);

        return $this->tileRepository->getRandomTiles($limit);
    }
}