<?php

namespace App\Test\Controller;

use App\Entity\AnimalStock;
use App\Repository\AnimalStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnimalStockControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AnimalStockRepository $repository;
    private string $path = '/animal/stock/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(AnimalStock::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AnimalStock index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'animal_stock[nomAnimal]' => 'Testing',
            'animal_stock[sexeAnimal]' => 'Testing',
            'animal_stock[ageAnimal]' => 'Testing',
            'animal_stock[poidsAnimal]' => 'Testing',
            'animal_stock[health]' => 'Testing',
            'animal_stock[dateEntreeStock]' => 'Testing',
            'animal_stock[vente]' => 'Testing',
        ]);

        self::assertResponseRedirects('/animal/stock/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new AnimalStock();
        $fixture->setNomAnimal('My Title');
        $fixture->setSexeAnimal('My Title');
        $fixture->setAgeAnimal('My Title');
        $fixture->setPoidsAnimal('My Title');
        $fixture->setHealth('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AnimalStock');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new AnimalStock();
        $fixture->setNomAnimal('My Title');
        $fixture->setSexeAnimal('My Title');
        $fixture->setAgeAnimal('My Title');
        $fixture->setPoidsAnimal('My Title');
        $fixture->setHealth('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'animal_stock[nomAnimal]' => 'Something New',
            'animal_stock[sexeAnimal]' => 'Something New',
            'animal_stock[ageAnimal]' => 'Something New',
            'animal_stock[poidsAnimal]' => 'Something New',
            'animal_stock[health]' => 'Something New',
            'animal_stock[dateEntreeStock]' => 'Something New',
            'animal_stock[vente]' => 'Something New',
        ]);

        self::assertResponseRedirects('/animal/stock/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomAnimal());
        self::assertSame('Something New', $fixture[0]->getSexeAnimal());
        self::assertSame('Something New', $fixture[0]->getAgeAnimal());
        self::assertSame('Something New', $fixture[0]->getPoidsAnimal());
        self::assertSame('Something New', $fixture[0]->getHealth());
        self::assertSame('Something New', $fixture[0]->getDateEntreeStock());
        self::assertSame('Something New', $fixture[0]->getVente());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new AnimalStock();
        $fixture->setNomAnimal('My Title');
        $fixture->setSexeAnimal('My Title');
        $fixture->setAgeAnimal('My Title');
        $fixture->setPoidsAnimal('My Title');
        $fixture->setHealth('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/animal/stock/');
    }
}
