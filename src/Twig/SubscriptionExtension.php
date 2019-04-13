<?php
namespace App\Twig;

use App\Entity\User;
use App\Repository\SubscriptionRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SubscriptionExtension extends AbstractExtension
{
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('hasSubscribed', [$this, 'hasSubscribed']),
        ];
    }

    public function hasSubscribed(User $user, User $member)
    {
        if($this->subscriptionRepository->findBySubscriberAndMember($user, $member)) {
            return true;
        }
        return false;
    }
}