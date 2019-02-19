<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 15/02/2019
 * Time: 13:50
 */

namespace App\Controller\Back;


use App\Entity\Search\Admin\UserSearchAdmin;
use App\Entity\User;
use App\Form\Search\Admin\UserSearchTypeAdmin;
use App\Form\User\UserEditAdminFormType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminUserController
 * @package App\Controller\Back
 * @IsGranted("ROLE_ADMIN")
 * @Route(name="app_admin_user_", path="/admin")
 */
class AdminUserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(name="list", path="/users")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list()
    {
        return $this->render('pages/back/user/list.html.twig', [
            'users' => $this->userRepository->findAll()
        ]);
    }

    /**
     * @Route(name="edit", path="/user/{slug}/edit")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(User $user, Request $request)
    {
        $editForm = $this->createForm(UserEditAdminFormType::class, $user);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
        }

        return $this->render('pages/back/user/edit.html.twig', [
            'user' => $user,
            'editForm' => $editForm->createView()
        ]);
    }

    /**
     * @Route(name="delete", path="/user/{id}/delete")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();

        $this->addFlash("success", "User delete successfully");
        return $this->redirectToRoute('app_admin_user_list');
    }
}