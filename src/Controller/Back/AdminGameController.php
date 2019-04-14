<?php

namespace App\Controller\Back;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminGameController
 * @package App\Controller\Back
 * @Route(name="app_admin_game_")
 */
class AdminGameController extends AbstractController
{
    private $em;
    private $gameRepository;

    public function __construct(EntityManagerInterface $em, GameRepository $gameRepository)
    {
        $this->em = $em;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route("/admin/games", name="list")
     */
    public function list()
    {
        return $this->render('pages/back/game/list.html.twig', [
            'games' => $this->gameRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/game/{slug}/edit", name="edit")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Game $game)
    {
        return $this->render('pages/back/game/edit.html.twig', [
            'game' => $game
        ]);
    }

    /**
     * @Route("/admin/game/{slug}/delete", name="delete")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Game $game)
    {
        $this->em->remove($game);
        $this->em->flush();

        $this->addFlash("success", "Game delete successfully");
        return $this->redirectToRoute('app_admin_game_list');
    }
}
