<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 28/06/19
 * Time: 19:49
 */

namespace App\Controller\Ajax;


use App\Entity\Organization;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class TeamAjaxController
 * @package App\Controller\Ajax
 * @Route(name="app_team_ajax_", path="/ajax/team")
 */
class TeamAjaxController extends AbstractController
{
    private $serializer;
    private $em;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @Route(path="/{id}/members", name="member_tab", options={"expose"=true})
     * @param Organization $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function members(Organization $team) {
       return $this->render('modules/front/team/show/tab/members_list.html.twig', [
           "team" => $team
       ]);
    }

    /**
     * @Route(path="/member/{id}/show", name="member_show", options={"expose"=true})
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(User $user) {
        return $this->render('modules/front/team/show/tab/member_details.html.twig', [
            "user" => $user,
            "team" => $user->getOrganization()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/members/{userId}/remove", name="remove_member", options={"expose"=true})
     * @ParamConverter("organization", options={"id" = "id"})
     * @ParamConverter("user", options={"id" = "userId"})
     * @param Organization $team
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove(Organization $team, User $user) {

        $team->removeUser($user);
        $this->em->flush();
        return $this->render('modules/front/team/show/tab/members_list.html.twig', [
            "team" => $team,
            "user"
        ]);
    }

}