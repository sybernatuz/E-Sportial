<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 14/02/2019
 * Time: 10:04
 */

namespace App\Tests\setup\mock;


use App\Entity\Subscription;

class SubscriptionMock
{
    /**
     * @var Subscription
     */
    static $subscription1;

    /**
     * @var Subscription
     */
    static $subscription2;

    public static function init() : void
    {
        self::$subscription1 = self::createSubscription1();
        self::$subscription2 = self::createSubscription2();
    }

    private static function createSubscription1() : Subscription
    {
        return (new Subscription())
            ->setSubscriber(UserMock::$user1)
            ->setUser(UserMock::$user2);
    }

    private static function createSubscription2() : Subscription
    {
        return (new Subscription())
            ->setSubscriber(UserMock::$user2)
            ->setUser(UserMock::$user1);
    }
}