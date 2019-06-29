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
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/members", name="member_tab", options={"expose"=true})
     * @param Organization $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function members(Organization $team) {
       $members = $team->getUsers();
       return $this->render('modules/front/team/show/tab/members_list.html.twig', [
           "members" => $members
       ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/members/{userId}/remove", name="remove_member", options={"expose"=true})
     * @param Organization $team
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove(Organization $team, User $user) {
        $team->removeUser($user);
        $this->em->flush();
        $members = $team->getUsers();
        return $this->render('modules/front/team/show/tab/members_list.html.twig', [
            "members" => $members
        ]);
    }

}