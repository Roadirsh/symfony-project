<?php

namespace App\Service;


use App\Entity\Bot;
use Doctrine\ORM\EntityManagerInterface;

class BotService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Bot::class);
    }

    public function createOrUpdateBot($data)
    {
        $bot = $this->repository->findOneBy(['name' => $data['name']]);
        if ($bot) {
            $bot->setCount($bot->getCount() + 1);
            $status = 200;
        } else {
            $bot = new Bot();
            $bot = $bot->setName($data['name'])
                ->setType($data['type'])
                ->setCategory($data['category'])
                ->setCount(1);
            $status = 201;
            $this->entityManager->persist($bot);
        }
        $this->entityManager->flush();
        return [
            'bot' => $bot,
            'status' => $status
        ];
    }
}