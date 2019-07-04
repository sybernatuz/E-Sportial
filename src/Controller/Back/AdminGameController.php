<?php

namespace App\Controller\Back;

use App\Entity\Game;
use App\Form\Back\Game\GameFormAdminType;
use App\Repository\GameRepository;
use App\Services\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    private $fileUploader;

    public function __construct(EntityManagerInterface $em, GameRepository $gameRepository, FileUploaderService $fileUploader)
    {
        $this->em = $em;
        $this->gameRepository = $gameRepository;
        $this->fileUploader = $fileUploader;
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
     * @Route("/admin/game/new", name="new", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $game = new Game();
        $gameForm = $this->createForm(GameFormAdminType::class, $game);
        $gameForm->handleRequest($request);

        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            if($game->getPosterFile()) {
                $fileName = $this->fileUploader->upload($game->getPosterFile(), "games");
                $game->setPosterPath($this->fileUploader->getTargetDirectory() . "/games/" . $fileName);
            }
            $this->em->persist($game);
            $this->em->flush();

            $this->addFlash("success", "Game created successfully");
            return $this->redirectToRoute('app_admin_game_list');
        }

        return $this->render('pages/back/game/new.html.twig', [
            'gameForm' => $gameForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/game/{slug}/edit", name="edit")
     * @param Game $game
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Game $game, Request $request)
    {
        $gameForm = $this->createForm(GameFormAdminType::class, $game);
        $oldFile = $game->getPosterFile();
        $gameForm->handleRequest($request);

        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            if($game->getPosterFile()) {
                $fileName = $this->fileUploader->upload($game->getPosterFile(), "games", true, $oldFile);
                $game->setPosterPath($this->fileUploader->getTargetDirectory() . "/games/" . $fileName);
            }
            $this->em->flush();

            $this->addFlash("success", "Game updated successfully");
            return $this->redirectToRoute('app_admin_game_list');
        }

        return $this->render('pages/back/game/edit.html.twig', [
            'gameForm' => $gameForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/game/{id}/delete", name="delete")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Game $game)
    {
        $game->setEnable(false);
        $this->em->flush();

        $this->addFlash("success", "Game delete successfully");
        return $this->redirectToRoute('app_admin_game_list');
    }
}
