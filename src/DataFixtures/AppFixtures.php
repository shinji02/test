<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($x=0;$x<=99999;$x++){
            $product = new Product();
            $product->setName("test - ".$x);
            $manager->persist($product);

        }

        $manager->flush();
    }
}
