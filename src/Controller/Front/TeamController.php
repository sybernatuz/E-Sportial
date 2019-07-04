<?php

namespace App\Controller\Front;

use App\Entity\Organization;
use App\Entity\Search\MemberSearch;
use App\Entity\User;
use App\Form\Front\Team\CreateTeamType;
use App\Form\Search\MemberSearchType;
use App\Repository\OrganizationRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\TypeRepository;
use App\Services\FileUploaderService;
use App\Services\layout\FooterService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * Class TeamController
 * @package App\Controller
 * @Route(name="app_team_")
 */
class TeamController extends AbstractController
{
    private const TEAMS_NUMBER = 12;

    private $footerService;
    private $teamRepository;

    public function __construct(FooterService $footerService, OrganizationRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(path="/teams", name="list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(PaginatorInterface $paginator, Request $request)
    {
        $search = new MemberSearch();
        $form = $this->createForm(MemberSearchType::class, $search);

        $form->handleRequest($request);

        $teams = $paginator->paginate(
            $this->teamRepository->findTeamBySearch($search),
            $request->query->getInt('page', 1),
            self::TEAMS_NUMBER
        );

        return $this->render('pages/front/team/list.html.twig', [
                'teams' => $teams,
                'form'  => $form->createView()
            ] + $this->footerService->process());
    }

    /**
     * @Route(path="/team/create", name="create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param FileUploaderService $fileUploader
     * @param Security $security
     * @param TypeRepository $typeRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request, EntityManagerInterface $em, FileUploaderService $fileUploader, Security $security, TypeRepository $typeRepository) {
        $organization = new Organization();
        $userConnected = $security->getUser();
        $form = $this->createForm(CreateTeamType::class, $organization);
        $form->handleRequest($request);

        if($userConnected->getOrganization()) {
            $this->addFlash('error', 'You have already a team');
            return $this->redirectToRoute('app_team_list');
        }

        if($form->isSubmitted() && $form->isValid()) {
            if($organization->getLogoFile()) {
                $fileName = $fileUploader->upload($organization->getLogoFile(), "teams");
                $organization->setLogoPath($fileUploader->getTargetDirectory() . "/teams/" . $fileName);
            }
            if(get_class($userConnected) == User::class) {
                $userConnected->setOrganization($organization);
                $userConnected->setTeamOwner(true);
                $organization->addUser($userConnected);
            }
            $organization->setCreatedAt(new \DateTime());
            $type = $typeRepository->findOneBy(['name' => 'team']);
            $organization->setType($type);
            $organization->setVerify(true);
            $em->persist($organization);
            $em->flush();
            $this->addFlash('success', 'Team created successfully');
            return $this->redirectToRoute('app_team_list');
        }
        return $this->render('pages/front/team/create.html.twig', [
                'form' => $form->createView()
            ] + $this->footerService->process());
    }

    /**
     * @Route(path="/team/{slug}", name="show")
     * @param Organization $team
     * @param SubscriptionRepository $subscriptionRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Organization $team, SubscriptionRepository $subscriptionRepository) {
        $followers = $subscriptionRepository->getListOfSubscriber($team);
        return $this->render('pages/front/team/show.html.twig', [
                'team' => $team,
                'followers' => $followers,
            ] + $this->footerService->process());
    }

    /**
     * @Route(path="/team/{slug}/leave", name="leave")
     * @param Organization $team
     * @param Security $security
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function leave(Organization $team, Security $security, EntityManagerInterface $em) {
        $team->removeUser($security->getUser());
        $em->flush();
        $this->addFlash('success', 'Team leaved successfully');
        return $this->redirectToRoute('app_team_show', ['slug' => $team->getSlug()]);
    }

    /**
     * @Route(path="/team/{slug}/delete", name="delete")
     * @param Organization $team
     * @param Security $security
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Organization $team, Security $security, EntityManagerInterface $em) {
        $security->getUser()->setTeamOwner(false);

        $team->setCountry(null);
        foreach ($team->getUsers() as $user) {
            $user->setOrganization(null);
        }

        foreach ($team->getSubscriptions() as $subscription) {
            $team->removeSubscription($subscription);
            $em->remove($subscription);
        }

        foreach ($team->getAwards() as $award) {
            $team->removeAward($award);
            $em->remove($award);
        }

        foreach ($team->getEvents() as $event) {
            $team->removeEvent($event);
            $em->remove($event);
        }

        foreach ($team->getFiles() as $file) {
            $team->removeFile($file);
        }

        foreach ($team->getJobs() as $job) {
            $team->removeJob($job);
        }

        foreach ($team->getRecruitments() as $recruitment) {
            $em->remove($recruitment);
        }

        foreach ($team->getRosters() as $roster) {
            $team->removeRoster($roster);
            $em->remove($roster);
        }

        foreach ($team->getSponsored() as $sponsored) {
            $team->removeSponsored($sponsored);
        }

        foreach ($team->getSponsorships() as $sponsorship) {
            $team->removeSponsorship($sponsorship);
            $em->remove($sponsorship);
        }

        $em->remove($team);
        $em->flush();
        $this->addFlash('success', 'Team deleted successfully');
        return $this->redirectToRoute('app_team_list');
    }

}
