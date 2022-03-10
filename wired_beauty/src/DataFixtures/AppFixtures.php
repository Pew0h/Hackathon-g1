<?php

namespace App\DataFixtures;

use App\Entity\Campain;
use App\Entity\CampainRegistration;
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
        // Création de datas user
        $users = [];
        $data_user = [
            'Lucas' => [
                'role'          => ['ROLE_ADMIN'],
                'firstName'     => 'Lucas',
                'lastName'      => 'Burlot',
                'age'           => '18',
                'latitude'      => '45.7578137',
                'longitude'     => '4.8320114',
                'password'      => 'password',
                'height'        => '180',
                'weight'        => '58',
                'email'        => 'lucas.burlot@gmail.com',
            ],
            'Martin' => [
                'role'          => ['ROLE_USER'],
                'firstName'     => 'Martin',
                'lastName'      => 'Paul',
                'age'           => '22',
                'latitude'      => '45.7578137',
                'longitude'     => '4.8320114',
                'password'      => 'password',
                'height'        => '172',
                'weight'        => '69',
                'email'        => 'martin.paul@gmail.com',
            ],
            'Louis' => [
                'role'          => ['ROLE_USER'],
                'firstName'     => 'Louis',
                'lastName'      => 'Default',
                'age'           => '24',
                'latitude'      => '45.7578137',
                'longitude'     => '4.8320114',
                'password'      => 'password',
                'height'        => '195',
                'weight'        => '70',
                'email'        => 'louis.default@gmail.com',
            ],
            'Delphine' => [
                'role'          => ['ROLE_USER'],
                'firstName'     => 'Delphine',
                'lastName'      => 'Lacroix',
                'age'           => '26',
                'latitude'      => '45.7578137',
                'longitude'     => '4.8320114',
                'password'      => 'password',
                'height'        => '161',
                'weight'        => '57',
                'email'        => 'delphine.lacroix@gmail.com',
            ],
        ];


        foreach ($data_user as $data) {
            $user = new User();
            $password = $this->passwordEncoder->hashPassword($user, 'password');
            $user
                ->setRoles($data['role'])
                ->setFirstname($data['firstName'])
                ->setLastname($data['lastName'])
                ->setAge($data['age'])
                ->setLatitude($data['latitude'])
                ->setLongitude($data['longitude'])
                ->setPassword($password)
                ->setHeight($data['height'])
                ->setWeight($data['weight'])
                ->setEmail($data['email']);

            $manager->persist($user);
            $users[] = $user;
        };


        // Création de datas company
        $companies = [];
        $data_company = [

            'nivea' => [
                'name'          => 'Nivea',
                'description'   => 'Nivea is a brand of skin care products, belonging to the German Beiersdorf Group.',
                'image'         => 'Logo_Nivea.png'
            ],

            'nuxe' => [
                'name'          => 'Nuxe',
                'description'   => 'Nuxe is a brand of cosmetic products founded in 1989 by Aliza Jabès.',
                'image'         => 'Logo_Nuxe.png'
            ],

            'erborian' => [
                'name'          => 'Erborian',
                'description'   => 'Erborian is a French-Korean cosmetics company founded in 2007 by Hojung Lee.',
                'image'         => 'Logo_Erborian.png'
            ],

            'caudalie' => [
                'name'          => 'Caudalie',
                'description'   => 'Caudalie is a French cosmetics company specialized in vinotherapy.',
                'image'         => 'Logo_Caudalie.png'
            ]
        ];

        foreach ($data_company as $key => $data) {
            $company = new Company();
            $company
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setImage($data['image']);

            $manager->persist($company);
            $companies[$key] = $company;
        };

        //Creation de datas product
        $products = [];
        $data_product = [

            '1' => [
                'name'          => 'Fluide UV visage anti-taches luminous 630',
                'description'   => "Luminous630 UV Anti-Spot Face Fluid immediately protects sensitive skin from UV rays. It prevents and visibly reduces sun spots with the patented ingredient Luminous630. Skin tone is more even and luminous. The formula is free of UV filters Octinoxate, Oxybenzone and Octocrylene.",
                'image'         => 'Produit_01.png',
                'uv_protection' => '50',
                'company'       => $companies['nivea'],
            ],
            '2' => [
                'name'          => 'Crème gel solaire protect & dry touch',
                'description'   => "NIVEA SUN Protect & Dry Touch Cream Gel SPF 30 provides immediate, highly effective and reliable UVA/UVB protection that is transparent on the skin. The light, non-greasy formula is sweat and water resistant, 100% transparent and leaves no white marks.",
                'image'         => 'Produit_02.png',
                'uv_protection' => '30',
                'company'       => $companies['nivea'],
            ],
            '3' => [
                'name'          => 'Lait délicieux visage et corps',
                'description'   => "This SPF30 sun lotion helps protect your face and body from the sun's rays and premature skin photoaging while enhancing your tan. Its milky and fluid texture glides on your skin with voluptuousness. Its evasive fragrance with notes of Sweet Orange, Tiaré and Vanilla is an irresistible invitation to enjoy the summer.",
                'image'         => 'Produit_03.png',
                'uv_protection' => '30',
                'company'       => $companies['nuxe'],
            ],
            '4' => [
                'name'          => 'Spray Fondant Haute Protection',
                'description'   => "This SPF50 sun spray helps protect your face and body from the sun's rays and premature photoaging of the skin, to prevent the appearance of spots. Water and perspiration resistant, its formula is ideal for your sporting activities. Spray its fluid texture in the blink of an eye and it melts sensitively into your skin without leaving a white film. Its evasive fragrance with notes of Sweet Orange, Tiaré and Vanilla is an irresistible invitation to enjoy the summer.",
                'image'         => 'Produit_04.png',
                'uv_protection' => '50',
                'company'       => $companies['nuxe'],
            ],
            '5' => [
                'name'          => 'Huile prodigieuse florale',
                'description'   => "Huile Prodigieuse® Florale gives you an irresistible satiny glow without a greasy finish thanks to its inimitable dry touch texture. Its floral fragrance with joyful notes is sure to put a smile on your face.",
                'image'         => 'Produit_05.png',
                'uv_protection' => '0',
                'company'       => $companies['nuxe'],
            ],
            '6' => [
                'name'          => 'Bamboo crème frappée',
                'description'   => "Like a waterfall of ice water, this cream provides an immediate boost to the skin. Its granite texture melts instantly on contact with the skin to help tone and moisturize.",
                'image'         => 'Produit_06.png',
                'uv_protection' => '0',
                'company'       => $companies['erborian'],
            ],
            '7' => [
                'name'          => 'Ginseng infusion',
                'description'   => "Enriched with traditional Korean herbs, ginseng infusion, by its tensor effect, contributes to make your skin look firmer and more radiant on a daily basis. Signs of aging appear visibly reduced.",
                'image'         => 'Produit_07.png',
                'uv_protection' => '0',
                'company'       => $companies['erborian'],
            ],
            '8' => [
                'name'          => 'Huile solaire sublimatrice',
                'description'   => "The Sun Oil SPF30 offers the skin maximum UVA/UVB protection while providing a satin finish. Rich in nourishing grape oil, this dry oil nourishes the skin and enhances the tan for a luminous and tanned skin without greasy effect. Its sunny fragrance with notes of frangipani flowers delicately envelops the skin. Without compromise between skin protection and nature protection, its formula is highly biodegradable and non-toxic for the marine eco-system.",
                'image'         => 'Produit_08.png',
                'uv_protection' => '30',
                'company'       => $companies['caudalie'],
            ],
            '9' => [
                'name'          => 'Crème SOS hydratation intense vinosource-hydra',
                'description'   => "As soft as it is natural, this unctuous cream soothes even the most sensitive dry skin, leaving it supple and moisturized. Redness and tightness give way to a sensation of immediate comfort. Ultra-sensory, it acts like a thirst-quenching wave on a daily basis for a revitalized and plumped skin, or as an S.O.S. gesture to repair the damage caused by external aggressions. Its phyto-aromatic fragrance is fresh and subtle, combining green notes of bergamot, mandarin, lemon leaf, cucumber and fresh mint.",
                'image'         => 'Produit_09.png',
                'uv_protection' => '0',
                'company'       => $companies['caudalie'],
            ]
        ];

        foreach ($data_product as $data) {
            $product = new Product();
            $product
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setImage($data['image'])
                ->setUvProtection($data['uv_protection'])
                ->setCompany($data['company']);

            $manager->persist($product);
            $products[] = $product;
        };

        //Création de datas campain

        $campains = [];
        $data_campain = [

            '1' => [
                'name'          => 'Spring campaign',
                'description'   => "Apply the cream on the body after the shower.",
                'start_date'    => '03/01/2022',
                'end_date'      => '05/31/2022',
            ],
            '2' => [
                'name'          => 'Summer campaign',
                'description'   => 'Apply the cream to the face every morning.',
                'start_date'    => '07/01/2022',
                'end_date'      => '08/31/2022',
            ],
            '3' => [
                'name'          => 'Autumn campaign',
                'description'   => 'Apply the cream to the face every morning.',
                'start_date'    => '09/01/2022',
                'end_date'      => '11/30/2022',
            ],
            '4' => [
                'name'          => 'Winter campaign',
                'description'   => 'Apply the cream to the face every morning and evening.',
                'start_date'    => '12/01/2022',
                'end_date'      => '02/28/2023',
            ],

        ];

        foreach ($data_campain as $data) {
            $p = $products[rand(0, count($products) - 1)];
            $c = $p->getCompany();

            $campain = new Campain();
            $campain
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setStartDate(new \DateTime($data['start_date']))
                ->setEndDate(new \DateTime($data['end_date']))
                ->setProduct($p)
                ->setCompany($c);


            $manager->persist($campain);
            $campains[] = $campain;
        };

        $manager->flush();
    }
}
