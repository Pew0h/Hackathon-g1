<?php

namespace App\DataFixtures;

use App\Entity\Campain;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de datas admin
        $admin = new User();
        $password = $this->passwordEncoder->hashPassword($admin, 'password');
        $admin
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname('Elon')
            ->setLastname('Musk')
            ->setAge(50)
            ->setLatitude(48.859)
            ->setLongitude(2.347)
            ->setPassword($password)
            ->setHeight(180)
            ->setWeight(72)
            ->setEmail('test@gmail.com');

        $manager->persist($admin);



        // Création de datas company
        $companies = [];
        $data_company = [

            'nivea' => [
                'name'          => 'Nivea',
                'description'   => 'Nivea est une marque de produits de soin, appartenant au groupe allemand Beiersdorf.',
                'image'         => 'https://upload.wikimedia.org/wikipedia/commons/6/67/Nivea_Logo.png'
            ],

            'nuxe' => [
                'name'          => 'Nuxe',
                'description'   => 'Nuxe est une marque de produits cosmétiques fondée en 1989 par Aliza Jabès.',
                'image'         => 'https://fr.nuxe.com/c-images/fb-image.png'
            ],

            'erborian' => [
                'name'          => 'Erborian',
                'description'   => 'Erborian est une entreprise de cosmétique franco-coréenne créée en 2007 par Hojung Lee.',
                'image'         => 'https://static.backbackback.fr/img/TD300763-logo-erborian-360x360.png'
            ],

            'caudalie' => [
                'name'          => 'Caudalie',
                'description'   => 'Caudalie est une entreprise française de cosmétiques spécialisée dans la vinothérapie.',
                'image'         => 'https://raichu-uploads.s3.amazonaws.com/logo_null_TF0erC.png'
            ]
        ];

        foreach ($data_company as $data) {
            $company = new Company();
            // $company
            //     ->setName($data['name'])
            //     ->setDescription($data['description'])
            //     ->setImage($data['image']);

            // $manager->persist($company);
            // $companies[$data['name']] = $company;
        }

        //     //Creation de datas product 
        //     $data_product = [

        //         [
        //             'name'          => 'Fluide UV visage anti-taches luminous 630',
        //             'description'   => "Le fluide UV Visage Anti Taches Luminous630 protège immédiatement les peaux sensibles contre les rayons UV. Il prévient et réduit visiblement les taches dues au soleil grâce à l'ingrédient breveté Luminous630. Le fluide solaire léger et non gras procure un effet rafraîchissant. Le teint est plus uniforme et plus lumineux. La formule est exempte de filtres UV Octinoxate, Oxybenzone et Octocrylène.",
        //             'image'         => 'https://images-eu.nivea.com/-/media/media-center-items/e/1/1/76c1e41407774d9fa40b04b6be3d3316-web_1010x1180_transparent_png.webp?mw=960&hash=0D6717E796A0308ECBE004C1C9B92508',
        //             'uv_protection' => '50',
        //             'company'       => $data_company['nivea']
        //         ],
        //         [
        //             'name'          => 'Crème gel solaire protect & dry touch',
        //             'description'   => "La Crème Gel NIVEA SUN Protect & Dry Touch SPF 30 offre immédiatement une protection UVA/UVB hautement efficace et fiable, transparente sur la peau. Sa formule légère et non grasse est résistante à la sueur et à l'eau, 100% transparente et ne laisse pas de traces blanches.",
        //             'image'         => 'https://images-eu.nivea.com/-/media/media-center-items/8/7/a/b44bbbd7a5f34b888ed4ee88d50f2a86-web_1010x1180_transparent_png.png',
        //             'uv_protection' => '30',
        //             'company'       => $data_company['nivea']
        //         ],
        //         [
        //             'name'          => 'Lait délicieux visage et corps',
        //             'description'   => "Ce lait solaire SPF30 vous aide à protéger visage et corps des rayons du soleil et du photo-vieillissement cutané prématuré tout en sublimant votre bronzage. Sa texture lactée et fluide glisse sur votre peau avec volupté. Son parfum d‘évasion aux notes d‘Orange Douce, de Tiaré et de Vanille est une irrésistible invitation à profiter de l'été.",
        //             'image'         => 'https://static.thcdn.com/images/large/webp/productimg/1600/1600/11111914-5224860941021337.jpg',
        //             'uv_protection' => '30',
        //             'company'       => $data_company['nuxe']
        //         ],
        //         [
        //             'name'          => 'Spray Fondant Haute Protection',
        //             'description'   => "Ce spray solaire SPF50 vous aide à protéger visage et corps des rayons du soleil et du photo-vieillissement prématuré de la peau, pour prévenir l'apparition des taches. Résistante à l'eau et à la transpiration, sa formule est idéale pour vos activités sportives. Vaporisez en un clin d‘oeil sa texture fluide qui fond avec sensorialité sur votre peau sans laisser de film blanc. Son parfum d‘évasion aux notes d‘Orange Douce, de Tiaré et de Vanille est une irrésistible invitation à profiter de l'été.",
        //             'image'         => 'https://static.thcdn.com/images/large/webp//productimg/1600/1600/12003475-1774860371124249.jpg',
        //             'uv_protection' => '50',
        //             'company'       => $data_company['nuxe']
        //         ],
        //         [
        //             'name'          => 'Huile prodigieuse florale',
        //             'description'   => "L'Huile Prodigieuse® Florale vous fait rayonner d‘un irrésistible éclat satiné sans fini gras grâce à sa texture au toucher sec inimitable. Son parfum floral aux notes joyeuses a le don de vous donner le sourire.",
        //             'image'         => 'https://static.thcdn.com/images/large/webp//productimg/1600/1600/12601900-2084909429509585.jpg',
        //             'uv_protection' => '0',
        //             'company'       => $data_company['nuxe']
        //         ],
        //         [
        //             'name'          => 'Bamboo crème frappée',
        //             'description'   => "Telle une cascade d’eau glacée, cette crème apporte un coup de fouet immédiat à la peau. Sa texture granité fond instantanément au contact de la peau pour aider à la tonifier et à l’hydrater.",
        //             'image'         => 'https://imageeu.erborian.com/dw/image/v2/BCDQ_PRD/on/demandware.static/-/Sites-erb_master/default/dwecd23169/large/6AA10132.png?sw=500&sh=500',
        //             'uv_protection' => '0',
        //             'company'       => $data_company['erborian']
        //         ],
        //         [
        //             'name'          => 'Ginseng infusion',
        //             'description'   => "Enrichi en herbes traditionnelles de Corée, ginseng infusion, par son effet tenseur, contribue à rendre votre peau comme plus ferme et plus éclatante au quotidien. Les signes de l’âge semblent visiblement atténués.",
        //             'image'         => 'https://imageeu.erborian.com/dw/image/v2/BCDQ_PRD/on/demandware.static/-/Sites-erb_master/default/dw8f756764/large/6AA10081.png?sw=500&sh=500',
        //             'uv_protection' => '0',
        //             'company'       => $data_company['erborian']
        //         ],
        //         [
        //             'name'          => 'Huile solaire sublimatrice',
        //             'description'   => "L'Huile Solaire SPF30 offre à la peau une protection maximale UVA/UVB tout en lui offrant un fini satiné. Riche en huile de raisin nourrissante, cette huile sèche nourrit la peau et sublime le hâle pour une peau lumineuse et bronzée sans effet gras. Son parfum ensoleillé aux notes de fleurs de frangipanier enveloppe délicatement la peau. Sans compromis entre la protection de la peau et la protection de la nature, sa formule est hautement biodégradable et non-toxique pour l'éco-système marin.",
        //             'image'         => 'https://caudalie-europe.imgix.net/media/catalog/product/2/4/241-beautifying-suncare-oil.jpg?w=607&h=607&auto=format%2Ccompress&image-type=image',
        //             'uv_protection' => '30',
        //             'company'       => $data_company['Caudalie']
        //         ],
        //         [
        //             'name'          => 'Crème SOS hydratation intense vinosource-hydra',
        //             'description'   => "Aussi douce que naturelle, cette crème onctueuse apaise les peaux sèches les plus sensibles qui retrouvent souplesse et hydratation. Rougeurs et tiraillements laissent place à une sensation de confort immédiat. Ultra-sensorielle, elle agit comme une vague désaltérante au quotidien pour une peau ressourcée et repulpée, ou en geste S.O.S pour réparer les dommages causés par les agressions extérieures. Sa fragrance phyto-aromatique est fraîche et subtile, elle associe des notes vertes de bergamote, mandarine, feuille de citronnier, concombre et menthe fraîche.",
        //             'image'         => 'https://caudalie-europe.imgix.net/media/catalog/product/3/3/336_sos_cream_50ml__01.jpg?w=1000&h=1000&auto=format%2Ccompress&image-type=image',
        //             'uv_protection' => '0',
        //             'company'       => $data_company['Caudalie']
        //         ]
        //     ];

        //     foreach ($data_product as $data) {
        //         $product = new Product();
        //         $product
        //             ->setName($data['name'])
        //             ->setDescription($data['description'])
        //             ->setImage($data['image'])
        //             ->setUvProtection($data['uv_protection'])
        //             ->setCompany($data['company']);

        //         $manager->persist($product);

        //         // Création de datas campain
        //         $data_campain = [

        //             '1' => [
        //                 'name'          => '',
        //                 'description'   => '',
        //                 'start_date'    => '',
        //                 'end_date'      => '',
        //             ]
        //         ];

        //         foreach ($data_campain as $data) {
        //             $campain = new Campain();
        //             $campain
        //                 ->setName($data['name'])
        //                 ->setDescription($data['description'])
        //                 ->setStartDate($data['start_date'])
        //                 ->setEndDate($data['end_date']);

        //             $manager->persist($product);


        //             // Création de datas campain_registration
        //             $data_campain_registration = [

        //                 [
        //                     'name'          => '',
        //                     'description'   => '',
        //                     'start_date'    => '',
        //                     'end_date'      => '',
        //                 ]
        //             ];

        //             foreach ($data_campain as $data) {
        //                 $campain = new Campain();
        //                 $campain
        //                     ->setName($data['name'])
        //                     ->setDescription($data['description'])
        //                     ->setStartDate($data['start_date'])
        //                     ->setEndDate($data['end_date']);

        //                 $manager->persist($product);
        //             }



        //             $manager->flush();
        //         }
        //     }
    }
}
