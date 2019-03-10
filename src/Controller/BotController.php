<?php

namespace App\Controller;


use App\Entity\Bot;
use App\Repository\BotRepository;
use App\Service\BotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BotController extends AbstractController
{
    /**
     * @Route("/bots/{id}", name="bot_show_by_id", methods={"GET"}, requirements={"id"="\d+"})
     * @param Bot $bot
     * @return Response
     */
    public function showById(Bot $bot)
    {
        return $this->json($bot);
    }

    /**
     * @Route("/bots/{slug}", name="bot_show_by_slug", methods={"GET"})
     * @param $bot
     * @return Response
     */
    public function showBySlug(Bot $bot)
    {
        return $this->json($bot);
    }

    /**
     * @Route("/bots", name="bot_index", methods={"GET"})
     * @param BotRepository $repository
     * @return Response
     */
    public function index(BotRepository $repository)
    {
        $bots = $repository->findBy([], ['count' => 'DESC']);
        return $this->json($bots);
    }

    /**
     * @Route("/bots", name="bot_add", methods={"POST"})
     * @param Request $request
     * @param BotService $botService
     * @return Response
     */
    public function add(Request $request, BotService $botService)
    {
        $data = $request->request->all();
        if($data && array_key_exists('name', $data) && array_key_exists('type', $data) && array_key_exists('category', $data)) {
            $result = $botService->createOrUpdateBot($data);
            return $this->json($result['bot'], $result['status']);
        } else {
            throw new BadRequestHttpException('Data is invalid');
        }
    }
}