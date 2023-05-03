<?php

namespace App\Controller;

use App\Repository\TileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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

        // Hack to get around strangeness in API platform.
        try {
            $tags = [];
            $tag = $request->query->get('tags_tag');
            if (!is_null($tag)) {
                $tags[] = $tag;
            }
        } catch (BadRequestException $exception) {
            $tags = $request->query->all('tags_tag');
        }

        // Sanitize tags.
        $tags = array_map('trim', $tags);
        $tags = array_map('strtolower', $tags);

        return $this->tileRepository->getRandomTiles($limit, $tags);
    }
}
