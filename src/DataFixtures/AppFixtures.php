<?php

namespace App\DataFixtures;

use App\Entity\Tile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Categories
        $json = \file_get_contents(__DIR__.'/data/tiles.json');
        $data = \json_decode($json, false, 512, JSON_THROW_ON_ERROR);

        foreach ($data as $datum) {
            // Copy image to public.
            $dest = __DIR__.'/../../public/tiles/'.basename($datum->image);
            $src = __DIR__.'/data/'.$datum->image;
            copy($src, $dest);


            $tile = new Tile();
            $tile->setTitle($datum->title)
                ->setDescription($datum->description)
                ->setImage('/tiles/'.basename($datum->image))
                ->setRemoteUrl($datum->remoteUrl)
                ->setMail($datum->mail)
                ->setAccepted($datum->accepted)
                ->setTags($datum->tags)
                ->setExtra(json_encode($datum->extra));
            $manager->persist($tile);
        }

//        $categories = [];
//
//        foreach ($data as $datum) {
//            $category = new Category();
//            $category->setName($datum->name)
//                ->setCqlSearch($datum->cql_search);
//
//            $manager->persist($category);
//
//            $categories[$datum->id] = $category;
//        }
//
//        // Search Runs
//        $json = \file_get_contents(__DIR__.'/Data/search_runs.json');
//        $data = \json_decode($json, false, 512, JSON_THROW_ON_ERROR);
//
//        foreach ($data as $datum) {
//            $category = $categories[$datum->category_id];
//            $runAt = new \DateTimeImmutable($datum->run_at);
//            $searchRun = new SearchRun($category, $runAt);
//            $searchRun->setIsSuccess((bool) $datum->is_success)
//                ->setErrorMessage($datum->error_message);
//
//            $manager->persist($searchRun);
//        }

        $manager->flush();
    }
}
