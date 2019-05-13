<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 04/05/19
 * Time: 14:55
 */

namespace App\Listener;


use App\Exceptions\GameAccount\GameAccountNotFoundException;
use App\Exceptions\GameStat\GameStatsFortniteDataNotFoundException;
use App\Exceptions\GameStat\GameStatsFortniteEpicNameUnknownException;
use App\Exceptions\GameStat\GameStatsGameNotSupportedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class AjaxExceptionListener
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelResponse(GetResponseForExceptionEvent $event) {
        $request = $event->getRequest();
        $routeName = $request->get('_route');
        $exception = $event->getException();

        $routeNameExploded = explode('_', $routeName);

        if($routeNameExploded[2] != 'ajax') {
            return;
        }

        $code = $this->getStatusCode($exception);

        $responseData = [
            'error' => [
                'code' => $code,
                'message' => $exception->getMessage()
            ]
        ];

        $event->setResponse(new JsonResponse($responseData, $code));
    }

    private function getStatusCode($exception) {
        if(
            $exception instanceof NotFoundHttpException ||
            $exception instanceof GameAccountNotFoundException ||
            $exception instanceof GameStatsGameNotSupportedException ||
            $exception instanceof GameStatsFortniteDataNotFoundException ||
            $exception instanceof GameStatsFortniteEpicNameUnknownException
        ) {
            return 404;
        } else {
            return 500;
        }
    }
}