<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/02/2019
 * Time: 08:18
 */

namespace App\Controller\Front;


use App\Entity\User;
use App\Form\ProfileFormType;
use App\Services\layout\FooterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 * @package App\Controller\front
 * @Route(name="app_profile_", path="/profile")
 */
class ProfileController extends AbstractController
{
    private $entityManager;
    private $footerService;

    public function __construct(FooterService $footerService, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index", path="/{slug}")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(User $user, Request $request)
    {
        $this->denyAccessUnlessGranted('editProfile', $user);
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlash('success', 'Profile edited successfully');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred');
            }
        }
        return $this->render('pages/front/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ] + $this->footerService->process());
    }
}