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
use App\Entity\Recruitment;
use App\Entity\Roster;
use App\Entity\User;
use App\Form\Front\Roster\AddUserToRosterType;
use App\Form\Front\Roster\CreateRosterType;
use App\Repository\RosterRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     */
    public function members(Organization $team)
    {
        return $this->render('modules/front/team/show/tab/members_list.html.twig', [
            "team" => $team
        ]);
    }

    /**
     * @Route(path="/{id}/events", name="event_tab", options={"expose"=true})
     * @param Organization $team
     * @return Response
     */
    public function events(Organization $team)
    {
        return $this->render('modules/front/team/show/tab/events_list.html.twig', [
            "team" => $team
        ]);
    }

    /**
     * @Route(path="/member/{id}/show", name="member_show", options={"expose"=true})
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
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
     * @return Response
     */
    public function remove(Organization $team, User $user)
    {
        $team->removeUser($user);
        $this->em->flush();
        return $this->render('modules/front/team/show/tab/members_list.html.twig', [
            "team" => $team,
            "user"
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/roster/{id}/member/{userId}/remove", name="remove_roster_member", options={"expose"=true})
     * @ParamConverter("roster", options={"id" = "id"})
     * @ParamConverter("user", options={"id" = "userId"})
     * @param Roster $roster
     * @param User $user
     * @return Response
     */
    public function removeUserFromRoster(Roster $roster, User $user)
    {
        $roster->removeUser($user);
        $this->em->flush();

        return $this->render('modules/front/team/show/tab/roster.html.twig', [
            "team" => $roster->getOrganization(),
            "roster" => $roster
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/roster/{id}/remove", name="remove_roster", options={"expose"=true})
     * @param Roster $roster
     * @return Response
     */
    public function removeRoster(Roster $roster)
    {
        $this->em->remove($roster);
        $this->em->flush();

        return $this->render('modules/front/team/show/tab/rosters.html.twig', [
            "rosters" => $roster->getOrganization()->getRosters()
        ]);
    }


    /**
     * @Route(path="/{id}/rosters", name="roster_tab", options={"expose"=true})
     * @param Request $request
     * @param Organization $team
     * @param RosterRepository $rosterRepository
     * @param UserRepository $userRepository
     * @return Response
     * @throws \Exception
     */
    public function rosters(Request $request, Organization $team, RosterRepository $rosterRepository, UserRepository $userRepository)
    {
        $roster = new Roster();
        $roster->setCreatedAt(new \DateTime());
        $roster->setOrganization($team);
        $formCreateRoster = $this->createForm(CreateRosterType::class, $roster);
        $formCreateRoster->handleRequest($request);

        $addUserToRoster = new AddUserToRosterDto();
        $addUserToRoster->setTeam($team);
        $formAddUserToRoster = $this->createForm(AddUserToRosterType::class, $addUserToRoster);
        $formAddUserToRoster->handleRequest($request);

        if ($formCreateRoster->isSubmitted() && $formCreateRoster->isValid()) {
            $this->em->persist($roster);
            $this->em->flush();
        }

        if ($formAddUserToRoster->isSubmitted() && $formAddUserToRoster->isValid()) {
            $rosterSubmitted = $addUserToRoster->getRoster();
            $user = $userRepository->findTeamMember($team, $addUserToRoster->getUsername());
            $rosterSubmitted->addUser($user);
            $recruitment = new Recruitment();
            $recruitment->setStartDate(new DateTime());
            $recruitment->setUser($user);
            $recruitment->setOrganization($team);
            $this->em->persist($recruitment);
            $this->em->flush();
        }

        $rosters = $rosterRepository->findByTeamOrderedByName($team);
        return $this->render('modules/front/team/show/tab/rosters_list.html.twig', [
            "team" => $team,
            "rosters" => $rosters,
            "formCreateRoster" => $formCreateRoster->createView(),
            "formAddUserToRoster" => $formAddUserToRoster->createView()
        ]);
    }

}