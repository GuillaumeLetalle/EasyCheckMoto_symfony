<?php

namespace App\DataFixtures;

use App\Entity\Technicien;
use App\Entity\Client;
use App\Entity\Moto;
use App\Entity\CT;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $passwordHasher;

    private $marquesMoto = [
        'Yamaha',
        'Honda',
        'Suzuki',
        'Kawasaki',
        'Ducati',
        'BMW',
        'Harley-Davidson',
        'Triumph',
        'KTM',
        'Aprilia',
        'MV Agusta',
        'Moto Guzzi',
        'Husqvarna',
        'Indian Motorcycle',
        'Royal Enfield',
        'Piaggio',
        'Vespa',
        'Bajaj',
        'Benelli',
        'Zero Motorcycles',
    ];

    private $modelesMoto = [
        'YZF-R1',
        'CBR600RR',
        'GSX-R750',
        'Ninja 650',
        'Panigale V4',
        'S1000RR',
        'Sportster Iron 883',
        'Street Triple',
        'Duke 690',
        'Tuono V4 1100',
        'F4 1000',
        'V7 Stone',
        'FE 501',
        'Chief Vintage',
        'Interceptor 650',
        'Primavera 150',
        'GTS 300',
        'Pulsar 220',
        'Leoncino 500',
        'SR/F',
        'MT-09',
        'Ninja H2',
        'GSX-S750',
        'Scrambler 1200',
        'YZF-R3',
        'CB500F',
        'Monster 821',
        'Africa Twin',
        'Z900',
        'Rocket 3',
    ];

    private $cylindreesMoto = [
        '125cc',
        '250cc',
        '400cc',
        '600cc',
        '750cc',
        '900cc',
        '1000cc',
        '1200cc',
    ];

    private $plaquesImmatriculation = [
        'AB-123-CD',
        'EF-456-GH',
        'IJ-789-KL',
        'MN-012-OP',
        'QR-345-ST',
        'UV-678-WX',
        'YZ-901-AB',
        'CD-234-EF',
        'GH-567-IJ',
        'KL-890-MN',
        'OP-123-QR',
        'ST-456-UV',
        'WX-789-YZ',
        'AB-012-CD',
        'EF-345-GH',
        'IJ-678-KL',
        'MN-901-OP',
        'QR-234-ST',
        'UV-567-WX',
        'YZ-890-AB',
        'CD-123-EF',
        'GH-456-IJ',
        'KL-789-MN',
        'OP-012-QR',
        'ST-345-UV',
        'WX-678-YZ',
        'AB-901-CD',
        'EF-234-GH',
        'IJ-567-KL',
        'MN-890-OP',
    ];

    private $numerosTelephone = [
        '01 23 45 67 89',
        '02 34 56 78 90',
        '03 45 67 89 01',
        '04 56 78 90 12',
        '05 67 89 01 23',
        '06 78 90 12 34',
        '01 40 50 60 70',
        '02 41 51 61 71',
        '03 42 52 62 72',
        '04 43 53 63 73',
    ];


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncate($manager);
        $this->adminFixtures($manager);
        $this->technicienFixtures($manager);
        $this->clientFixtures($manager);
        $this->motoFixtures($manager);
        $this->ctFixtures($manager);
    }

    protected function adminFixtures($manager): void
    {
        $admin = new Technicien;
        $admin->setUsername('g.letalle');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'TrucdeOuf'
        );
        $admin->setPassword($hashedPassword);
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_TECHNICIEN']);
        $admin->setname('Letalle');
        $admin->setFirstname('Guillaume');
        $manager->persist($admin);

        $manager->flush();
    }

    protected function technicienFixtures($manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $team = new Technicien;
            $team->setUsername('tech' . $i);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $team,
                'TrucdeOuf'
            );
            $team->setPassword($hashedPassword);
            $team->setRoles(['ROLE_TECHNICIEN']);
            $team->setname($this->faker->lastName);
            $team->setFirstname($this->faker->firstName);
            $manager->persist($team);
        }
        $manager->flush();
    }

    protected function clientFixtures($manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $user = new Client;
            $user->setEmail('user' . $i . '@gmail.fr');
            $user->setUsername('user' . $i);
            $user->setFirstname($this->faker->firstName);
            $user->setname($this->faker->lastName);
            $user->setRoles(['ROLE_CLIENT']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'TrucdeOuf'
            );
            $user->setPassword($hashedPassword);
            $numero = $this->faker->randomElement($this->numerosTelephone);
            $user->setPhone($numero);
            $manager->persist($user);
        }
        $manager->flush();
    }

    protected function motoFixtures($manager): void
    {
        for ($i = 1; $i <= 25; $i++) {
            $moto = new Moto;
            $marque = $this->faker->randomElement($this->marquesMoto);
            $moto->setMarque($marque);
            $modele = $this->faker->randomElement($this->modelesMoto);
            $moto->setModele($modele);
            $annees = range(1980, 2023);
            $annee = $this->faker->randomElement($annees);
            $moto->setAnnee($this->faker->numberBetween($annee, $annee));
            $moto->setClient($this->getRandomReference('App\Entity\Client', $manager));
            $cylindree = $this->faker->randomElement($this->cylindreesMoto);
            $moto->setCylindree($cylindree . 'cm³');
            $plaque = $this->faker->randomElement($this->plaquesImmatriculation);
            $moto->setImmatriculation($plaque);
            $manager->persist($moto);
        }
        $manager->flush();
    }

    protected function ctFixtures($manager)
    {

        for ($i = 1; $i <= 15; $i++) {
            $controle = new CT;
            $dateDebut = $this->faker->dateTimeBetween('-3 month', 'now');
            $decalageHeures = $this->faker->numberBetween(1, 1);
            $dateFin = clone $dateDebut;
            $dateFin->modify("+$decalageHeures hours");
            $controle->setdebut($dateDebut);
            $controle->setfin($dateFin);
            $controle->setVehiculeControle($this->getRandomReference('App\Entity\Moto', $manager));
            $controle->setTechnicienControle($this->getRandomReference('App\Entity\Technicien', $manager));
            $controle->setClient($this->getRandomReference('App\Entity\Client', $manager));
            $controle->setFreinage(mt_rand(0, 1));
            $controle->setDirection(mt_rand(0, 1));
            $controle->setVisibilite(mt_rand(0, 1));
            $controle->setEclairageSignalisation(mt_rand(0, 1));
            $controle->setPneumatique(mt_rand(0, 1));
            $controle->setCarrosserie(mt_rand(0, 1));
            $controle->setMecanique(mt_rand(0, 1));
            $controle->setEquipement(mt_rand(0, 1));
            $controle->setPollution(mt_rand(0, 1));
            $controle->setNiveauSonore(mt_rand(0, 1));
            $controle->setMotoIsOk('null');
            $manager->persist($controle);
        }
        $manager->flush();
    }

    protected function getReferencedObject(string $className, int $id, object $manager)
    {
        return $manager->find($className, $id);
    }

    protected function getRandomReference(string $className, object $manager)
    {
        $list = $manager->getRepository($className)->findAll();
        return $list[array_rand($list)];
    }

    protected function truncate($manager): void
    {
        // @var Connection db
        $db = $manager->getConnection();

        //start new transaction
        $db->beginTransaction();

        $sql = '
        SET FOREIGN_KEY_CHECKS = 0;
        TRUNCATE admin;
        TRUNCATE technicien;
        TRUNCATE client;
        TRUNCATE moto;
        TRUNCATE ct;
        SET FOREIGN_KEY_CHECKS=1;';

        $db->prepare($sql);
        $db->executeQuery($sql);

        $db->commit();
        $db->beginTransaction();
    }
}
