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
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    private const USERS_NUMBER = 15;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @Route(name="list", path="/users")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request, PaginatorInterface $paginator)
    {
        $search = new UserSearchAdmin();
        $searchForm = $this->createForm(UserSearchTypeAdmin::class, $search);

        $searchForm->handleRequest($request);

        $users = $paginator->paginate(
            $this->userRepository->findBySearchAdmin($search),
            $request->query->getInt('page', 1),
            self::USERS_NUMBER
        );

        return $this->render('pages/back/user/list.html.twig', [
            'users' => $users,
            'searchForm' => $searchForm->createView()
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
        $search = new UserSearchAdmin();
        $editForm = $this->createForm(UserSearchTypeAdmin::class, $search);

        $editForm->handleRequest($request);

        return $this->render('pages/back/user/edit.html.twig', [
            'user' => $user,
            'searchForm' => $editForm->createView()
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