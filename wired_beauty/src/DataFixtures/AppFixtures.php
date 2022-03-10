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
            $users[$data['lastName']] = $user;
        };


        // Création de datas company
        $companies = [];
        $data_company = [

            'nivea' => [
                'name'          => 'Nivea',
                'description'   => 'Nivea is a brand of skin care products, belonging to the German Beiersdorf Group.',
                'image'         => 'https://upload.wikimedia.org/wikipedia/commons/6/67/Nivea_Logo.png'
            ],

            'nuxe' => [
                'name'          => 'Nuxe',
                'description'   => 'Nuxe is a brand of cosmetic products founded in 1989 by Aliza Jabès.',
                'image'         => 'https://fr.nuxe.com/c-images/fb-image.png'
            ],

            'erborian' => [
                'name'          => 'Erborian',
                'description'   => 'Erborian is a French-Korean cosmetics company founded in 2007 by Hojung Lee.',
                'image'         => 'https://static.backbackback.fr/img/TD300763-logo-erborian-360x360.png'
            ],

            'caudalie' => [
                'name'          => 'Caudalie',
                'description'   => 'Caudalie is a French cosmetics company specialized in vinotherapy.',
                'image'         => 'file:///Users/delphine/Downloads/logo_null_TF0erC%20(1).png'
            ]
        ];

        foreach ($data_company as $data) {
            $user = new Company();
            $user
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setImage($data['image']);

            $manager->persist($user);
            $companies[$data['name']] = $user;
        };

        //Creation de datas product
        $products = [];
        $data_product = [

            '1' => [
                'name'          => 'Fluide UV visage anti-taches luminous 630',
                'description'   => "Luminous630 UV Anti-Spot Face Fluid immediately protects sensitive skin from UV rays. It prevents and visibly reduces sun spots with the patented ingredient Luminous630. Skin tone is more even and luminous. The formula is free of UV filters Octinoxate, Oxybenzone and Octocrylene.",
                'image'         => 'https://images-eu.nivea.com/-/media/media-center-items/e/1/1/76c1e41407774d9fa40b04b6be3d3316-web_1010x1180_transparent_png.webp?mw=960&hash=0D6717E796A0308ECBE004C1C9B92508',
                'uv_protection' => '50',
                'user'          => $data_company['nivea']
            ],
            '2' => [
                'name'          => 'Crème gel solaire protect & dry touch',
                'description'   => "NIVEA SUN Protect & Dry Touch Cream Gel SPF 30 provides immediate, highly effective and reliable UVA/UVB protection that is transparent on the skin. The light, non-greasy formula is sweat and water resistant, 100% transparent and leaves no white marks.",
                'image'         => 'https://images-eu.nivea.com/-/media/media-center-items/8/7/a/b44bbbd7a5f34b888ed4ee88d50f2a86-web_1010x1180_transparent_png.png',
                'uv_protection' => '30',
                'user'          => $data_company['nivea']
            ],
            '3' => [
                'name'          => 'Lait délicieux visage et corps',
                'description'   => "This SPF30 sun lotion helps protect your face and body from the sun's rays and premature skin photoaging while enhancing your tan. Its milky and fluid texture glides on your skin with voluptuousness. Its evasive fragrance with notes of Sweet Orange, Tiaré and Vanilla is an irresistible invitation to enjoy the summer.",
                'image'         => 'https://static.thcdn.com/images/large/webp/productimg/1600/1600/11111914-5224860941021337.jpg',
                'uv_protection' => '30',
                'user'          => $data_company['nuxe']
            ],
            '4' => [
                'name'          => 'Spray Fondant Haute Protection',
                'description'   => "This SPF50 sun spray helps protect your face and body from the sun's rays and premature photoaging of the skin, to prevent the appearance of spots. Water and perspiration resistant, its formula is ideal for your sporting activities. Spray its fluid texture in the blink of an eye and it melts sensitively into your skin without leaving a white film. Its evasive fragrance with notes of Sweet Orange, Tiaré and Vanilla is an irresistible invitation to enjoy the summer.",
                'image'         => 'https://static.thcdn.com/images/large/webp//productimg/1600/1600/12003475-1774860371124249.jpg',
                'uv_protection' => '50',
                'user'          => $data_company['nuxe']
            ],
            '5' => [
                'name'          => 'Huile prodigieuse florale',
                'description'   => "Huile Prodigieuse® Florale gives you an irresistible satiny glow without a greasy finish thanks to its inimitable dry touch texture. Its floral fragrance with joyful notes is sure to put a smile on your face.",
                'image'         => 'https://static.thcdn.com/images/large/webp//productimg/1600/1600/12601900-2084909429509585.jpg',
                'uv_protection' => '0',
                'user'          => $data_company['nuxe']
            ],
            '6' => [
                'name'          => 'Bamboo crème frappée',
                'description'   => "Like a waterfall of ice water, this cream provides an immediate boost to the skin. Its granite texture melts instantly on contact with the skin to help tone and moisturize.",
                'image'         => 'https://imageeu.erborian.com/dw/image/v2/BCDQ_PRD/on/demandware.static/-/Sites-erb_master/default/dwecd23169/large/6AA10132.png?sw=500&sh=500',
                'uv_protection' => '0',
                'user'          => $data_company['erborian']
            ],
            '7' => [
                'name'          => 'Ginseng infusion',
                'description'   => "Enriched with traditional Korean herbs, ginseng infusion, by its tensor effect, contributes to make your skin look firmer and more radiant on a daily basis. Signs of aging appear visibly reduced.",
                'image'         => 'https://imageeu.erborian.com/dw/image/v2/BCDQ_PRD/on/demandware.static/-/Sites-erb_master/default/dw8f756764/large/6AA10081.png?sw=500&sh=500',
                'uv_protection' => '0',
                'user'          => $data_company['erborian']
            ],
            '8' => [
                'name'          => 'Huile solaire sublimatrice',
                'description'   => "The Sun Oil SPF30 offers the skin maximum UVA/UVB protection while providing a satin finish. Rich in nourishing grape oil, this dry oil nourishes the skin and enhances the tan for a luminous and tanned skin without greasy effect. Its sunny fragrance with notes of frangipani flowers delicately envelops the skin. Without compromise between skin protection and nature protection, its formula is highly biodegradable and non-toxic for the marine eco-system.",
                'image'         => 'https://caudalie-europe.imgix.net/media/catalog/product/2/4/241-beautifying-suncare-oil.jpg?w=607&h=607&auto=format%2Ccompress&image-type=image',
                'uv_protection' => '30',
                'user'          => $data_company['caudalie']
            ],
            '9' => [
                'name'          => 'Crème SOS hydratation intense vinosource-hydra',
                'description'   => "As soft as it is natural, this unctuous cream soothes even the most sensitive dry skin, leaving it supple and moisturized. Redness and tightness give way to a sensation of immediate comfort. Ultra-sensory, it acts like a thirst-quenching wave on a daily basis for a revitalized and plumped skin, or as an S.O.S. gesture to repair the damage caused by external aggressions. Its phyto-aromatic fragrance is fresh and subtle, combining green notes of bergamot, mandarin, lemon leaf, cucumber and fresh mint.",
                'image'         => 'https://caudalie-europe.imgix.net/media/catalog/product/3/3/336_sos_cream_50ml__01.jpg?w=1000&h=1000&auto=format%2Ccompress&image-type=image',
                'uv_protection' => '0',
                'user'          => $data_company['caudalie']
            ]
        ];

        foreach ($data_product as $data) {
            $product = new Product();
            $product
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setImage($data['image'])
                ->setUvProtection($data['uv_protection'])
                ->setCompany($user);

            $manager->persist($product);
            $products[$data['name']] = $product;
        };



        //Création de datas campain

        $campains = [];
        $data_campain = [

            '1' => [
                'name'          => 'Spring campaign',
                'description'   => "Apply the prodigious oil on the body after the shower.",
                'start_date'    => '03/01/2022',
                'end_date'      => '05/31/2022',
                'product'       => $data_product['5'],
                'user'          => $data_company['nuxe']
            ],
            '2' => [
                'name'          => 'Summer campaign',
                'description'   => 'Apply the cream to the face every morning.',
                'start_date'    => '07/01/2022',
                'end_date'      => '08/31/2022',
                'product'       => $data_product['1'],
                'user'          => $data_company['nivea']
            ],
            '3' => [
                'name'          => 'Autumn campaign',
                'description'   => 'Apply the cream to the face every morning.',
                'start_date'    => '09/01/2022',
                'end_date'      => '11/30/2022',
                'product'       => $data_product['7'],
                'user'          => $data_company['erborian']
            ],
            '4' => [
                'name'          => 'Winter campaign',
                'description'   => 'Apply the cream to the face every morning and evening.',
                'start_date'    => '12/01/2022',
                'end_date'      => '02/28/2023',
                'product'       => $data_product['9'],
                'user'          => $data_company['caudalie']
            ],

        ];

        foreach ($data_campain as $data) {
            $campain = new Campain();
            $campain
                ->setName($data['name'])
                ->setDescription($data['description'])
                ->setStartDate(new \DateTime($data['start_date']))
                ->setEndDate(new \DateTime($data['end_date']))
                ->setProduct($product)
                ->setCompany($user);


            $manager->persist($campain);
            $campains[$data['name']] = $campain;
        };

        // Création de datas campain_registration
        $data_campain_registration = [

            [
                'tester'        => '',
                'campain'       => $data_campain['1'],
                'status'        => '0',
            ]
        ];

        foreach ($data_campain_registration as $data) {
            $campain_registration = new CampainRegistration();
            $campain_registration
                ->setTester($user)
                ->setCampain($campain)
                ->setStatus($data['status']);

            $manager->persist($campain_registration);
        }



        $manager->flush();
    }
}
