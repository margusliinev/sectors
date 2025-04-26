<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Sector;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sectors = [
            1   => 'Manufacturing',
            19  => 'Construction materials',
            18  => 'Electronics and Optics',
            6   => 'Food and Beverage',
            342 => 'Bakery & confectionery products',
            43  => 'Beverages',
            42  => 'Fish & fish products',
            40  => 'Meat & meat products',
            39  => 'Milk & dairy products',
            437 => 'Other',
            378 => 'Sweets & snack food',
            13  => 'Furniture',
            389 => 'Bathroom/sauna',
            385 => 'Bedroom',
            390 => 'Children’s room',
            98  => 'Kitchen',
            101 => 'Living room',
            392 => 'Office',
            394 => 'Other (Furniture)',
            341 => 'Outdoor',
            99  => 'Project furniture',
            12  => 'Machinery',
            94  => 'Machinery components',
            91  => 'Machinery equipment/tools',
            224 => 'Manufacture of machinery',
            97  => 'Maritime',
            271 => 'Aluminium and steel workboats',
            269 => 'Boat/Yacht building',
            230 => 'Ship repair and conversion',
            93  => 'Metal structures',
            508 => 'Other',
            227 => 'Repair and maintenance service',
            11  => 'Metalworking',
            67  => 'Construction of metal structures',
            263 => 'Houses and buildings',
            267 => 'Metal products',
            542 => 'Metal works',
            75  => 'CNC-machining',
            62  => 'Forgings, Fasteners',
            69  => 'Gas, Plasma, Laser cutting',
            66  => 'MIG, TIG, Aluminum welding',
            9   => 'Plastic and Rubber',
            54  => 'Packaging',
            556 => 'Plastic goods',
            559 => 'Plastic processing technology',
            55  => 'Blowing',
            57  => 'Moulding',
            53  => 'Plastics welding and processing',
            560 => 'Plastic profiles',
            5   => 'Printing',
            148 => 'Advertising',
            150 => 'Book/Periodicals printing',
            145 => 'Labelling and packaging printing',
            7   => 'Textile and Clothing',
            44  => 'Clothing',
            45  => 'Textile',
            8   => 'Wood',
            337 => 'Other (Wood)',
            51  => 'Wooden building materials',
            47  => 'Wooden houses',
            3   => 'Other',
            37  => 'Creative industries',
            29  => 'Energy technology',
            33  => 'Environment',
            2   => 'Service',
            25  => 'Business services',
            35  => 'Engineering',
            28  => 'Information Technology and Telecommunications',
            581 => 'Data processing, Web portals, E-marketing',
            576 => 'Programming, Consultancy',
            121 => 'Software, Hardware',
            122 => 'Telecommunications',
            22  => 'Tourism',
            141 => 'Translation services',
            21  => 'Transport and Logistics',
            111 => 'Air',
            114 => 'Rail',
            112 => 'Road',
            113 => 'Water',
        ];

        foreach ($sectors as $id => $name) {
            $sector = new Sector();
            $sector->setId($id);
            $sector->setName($name);
            $manager->persist($sector);
        }

        $manager->flush();
    }
}
