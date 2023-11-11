<?php

namespace App\Test\Controller;

use App\Entity\PlanteStock;
use App\Repository\PlanteStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanteStockControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PlanteStockRepository $repository;
    private string $path = '/plante/stock/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PlanteStock::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PlanteStock index');

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
            'plante_stock[nomPlante]' => 'Testing',
            'plante_stock[etatPlante]' => 'Testing',
            'plante_stock[quantitePlante]' => 'Testing',
            'plante_stock[dateEntreeStock]' => 'Testing',
            'plante_stock[vente]' => 'Testing',
        ]);

        self::assertResponseRedirects('/plante/stock/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PlanteStock();
        $fixture->setNomPlante('My Title');
        $fixture->setEtatPlante('My Title');
        $fixture->setQuantitePlante('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PlanteStock');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PlanteStock();
        $fixture->setNomPlante('My Title');
        $fixture->setEtatPlante('My Title');
        $fixture->setQuantitePlante('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'plante_stock[nomPlante]' => 'Something New',
            'plante_stock[etatPlante]' => 'Something New',
            'plante_stock[quantitePlante]' => 'Something New',
            'plante_stock[dateEntreeStock]' => 'Something New',
            'plante_stock[vente]' => 'Something New',
        ]);

        self::assertResponseRedirects('/plante/stock/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomPlante());
        self::assertSame('Something New', $fixture[0]->getEtatPlante());
        self::assertSame('Something New', $fixture[0]->getQuantitePlante());
        self::assertSame('Something New', $fixture[0]->getDateEntreeStock());
        self::assertSame('Something New', $fixture[0]->getVente());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PlanteStock();
        $fixture->setNomPlante('My Title');
        $fixture->setEtatPlante('My Title');
        $fixture->setQuantitePlante('My Title');
        $fixture->setDateEntreeStock('My Title');
        $fixture->setVente('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/plante/stock/');
    }
}
