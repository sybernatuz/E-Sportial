<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 28/06/19
 * Time: 19:49
 */

namespace App\Controller\Ajax;


use App\Entity\Dto\Roster\AddUserToRosterDto;
use App\Entity\Organization;
use App\Entity\Roster;
use App\Entity\User;
use App\Form\Front\Roster\AddUserToRosterType;
use App\Form\Front\Roster\CreateRosterType;
use App\Repository\RosterRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route(path="/{id}/events", name="event_tab", options={"expose"=true})
     * @param Organization $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function events(Organization $team) {
       return $this->render('modules/front/team/show/tab/events_list.html.twig', [
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

    /**
     * @Route(path="/{id}/rosters", name="roster_tab", options={"expose"=true})
     * @param Request $request
     * @param Organization $team
     * @param RosterRepository $rosterRepository
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function rosters(Request $request, Organization $team, RosterRepository $rosterRepository, UserRepository $userRepository) {
        $rosters = $rosterRepository->findByTeamOrderedByName($team);

        $roster = new Roster();
        $formCreateRoster = $this->createForm(CreateRosterType::class, $roster);
        $formCreateRoster->handleRequest($request);


        $addUserToRoster = new AddUserToRosterDto();
        $addUserToRoster->setTeam($team);
        $formAddUserToRoster = $this->createForm(AddUserToRosterType::class);
        $formAddUserToRoster->handleRequest($request);

        if($formCreateRoster->isSubmitted() && $formCreateRoster->isValid()) {
            $this->em->persist($roster);
            $this->em->flush();
        }

        if($formAddUserToRoster->isSubmitted() && $formAddUserToRoster->isValid()) {
            $rosterSubmitted = $addUserToRoster->getRoster();
            $user = $userRepository->findTeamMember($team, $addUserToRoster->getUsername());
            $rosterSubmitted->addUser($user);
            $this->em->flush();
        }

        return $this->render('modules/front/team/show/tab/rosters_list.html.twig', [
            "team" => $team,
            "rosters" => $rosters,
            "formCreateRoster" => $formCreateRoster->createView(),
            "formAddUserToRoster" => $formAddUserToRoster->createView()
        ]);
    }

}