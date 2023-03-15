<?php

namespace App\DataFixtures;

use App\Entity\ApiUser;
use App\Entity\Screen;
use App\Entity\Tags;
use App\Entity\Tile;
use App\Repository\TagsRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
       private readonly TagsRepository $tagsRepository
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws \JsonException
     */
    public function load(ObjectManager $manager): void
    {
        // Tiles
        $json = \file_get_contents(__DIR__.'/data/tiles.json');
        $data = \json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        foreach ($data as $datum) {
            // Copy image to public.
            $dest = __DIR__.'/../../public/tiles/'.basename($datum->image);
            $src = __DIR__.'/data/'.$datum->image;
            copy($src, $dest);

            $tile = new Tile();
            $tile->setDescription($datum->description)
                ->setImage('/tiles/'.basename($datum->image))
                ->setMail($datum->mail)
                ->setAccepted($datum->accepted)
                ->setExtra(json_encode($datum->extra));

            foreach ($datum->tags as $tag) {
                $entity = $this->tagsRepository->findOneBy(['tag' => $tag]);
                if (is_null($entity)) {
                    $entity = new Tags();
                    $entity->setTag($tag);
                    $manager->persist($entity);

                    // Need to flush data to ensure the find above now will find the new tag in next loop.
                    $manager->flush();
                }
                $tile->addTag($entity);
            }

            $manager->persist($tile);
        }

        // Screens
        $json = \file_get_contents(__DIR__.'/data/screen.json');
        $data = \json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        foreach ($data as $datum) {
            $screen = new Screen();
            $screen->setTitle($datum->title)
                ->setGridColumns($datum->gridColumns)
                ->setGridRows($datum->gridRows)
                ->setVariant(json_encode($datum->variant));
            $manager->persist($screen);
        }

        // API user
        $json = \file_get_contents(__DIR__.'/data/api_user.json');
        $data = \json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        foreach ($data as $datum) {
            $api = new ApiUser();
            $api->setToken($datum->token)
                ->setRemoteApiKey($datum->remoteApiKey);
            $manager->persist($api);
        }

        $manager->flush();
    }
}
