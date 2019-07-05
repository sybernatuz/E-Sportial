<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/07/2019
 * Time: 14:24
 */

namespace App\Controller\Front;

use App\Repository\RecruitmentRepository;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="app_recruitment_")
 * Class RecruitmentController
 * @package App\Controller\Front
 */
class RecruitmentController extends AbstractController
{

    private $recruitmentRepository;
    private $footerService;

    public function __construct(RecruitmentRepository $recruitmentRepository, FooterService $footerService)
    {
        $this->recruitmentRepository = $recruitmentRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="list", path="/recruitments")
     */
    public function list()
    {
        return $this->render("pages/front/recruitment/list.html.twig", [
                'recruitments' => $this->recruitmentRepository->findByLastDate(1000),
            ] + $this->footerService->process());
    }
}