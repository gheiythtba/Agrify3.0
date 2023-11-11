<?php

namespace App\Test\Controller;

use App\Entity\StockDivers;
use App\Repository\StockDiversRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StockDiversControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private StockDiversRepository $repository;
    private string $path = '/stock/divers/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(StockDivers::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('StockDiver index');

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
            'stock_diver[nomSD]' => 'Testing',
            'stock_diver[quantiteSD]' => 'Testing',
            'stock_diver[health]' => 'Testing',
            'stock_diver[dateEntreeStock]' => 'Testing',
            'stock_diver[vente]' => 'Testing',
        ]);

        self::assertResponseRedirects('/stock/divers/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new StockDivers();
        $fixture->setNomSD('My Title');
        $fixture->setQuantiteSD('My Title');
        $fixture->setHealth('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('StockDiver');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new StockDivers();
        $fixture->setNomSD('My Title');
        $fixture->setQuantiteSD('My Title');
        $fixture->setHealth('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'stock_diver[nomSD]' => 'Something New',
            'stock_diver[quantiteSD]' => 'Something New',
            'stock_diver[health]' => 'Something New',
            'stock_diver[dateEntreeStock]' => 'Something New',
            'stock_diver[vente]' => 'Something New',
        ]);

        self::assertResponseRedirects('/stock/divers/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomSD());
        self::assertSame('Something New', $fixture[0]->getQuantiteSD());
        self::assertSame('Something New', $fixture[0]->getHealth());
        self::assertSame('Something New', $fixture[0]->getDateEntreeStock());
        self::assertSame('Something New', $fixture[0]->getVente());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new StockDivers();
        $fixture->setNomSD('My Title');
        $fixture->setQuantiteSD('My Title');
        $fixture->setHealth('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/stock/divers/');
    }
}
