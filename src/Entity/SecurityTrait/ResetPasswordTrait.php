<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 30/01/19
 * Time: 22:40
 */

namespace App\Entity\SecurityTrait;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Trait for "reset password" feature.
 */
trait ResetPasswordTrait
{
    /**
     * @ORM\Column(type="string", options={"default": null}, nullable=true)
     * @var string Reset token.
     */
    protected $resetToken = null;

    /**
     * @ORM\Column(type="integer", options={"default": null}, nullable=true)
     * @var int Unix Epoch timestamp when the reset token expires.
     */
    protected $resetTokenExpiresAt = null;

    /**
     * Generates new reset token which expires in specified period of time.
     *
     * @param \DateInterval $interval
     * @return string Generated token.
     * @throws \Exception
     */
    public function generateResetToken(\DateInterval $interval): string
    {
        $now = new \DateTime();
        $this->resetToken = Uuid::uuid4()->getHex();
        $this->resetTokenExpiresAt = $now->add($interval)->getTimestamp();
        return $this->resetToken;
    }

    /**
     * Clears current reset token.
     *
     * @return self
     */
    public function clearResetToken(): self
    {
        $this->resetToken          = null;
        $this->resetTokenExpiresAt = null;
        return $this;
    }

    /**
     * Checks whether specified reset token is valid.
     *
     * @param string $token
     * @return bool
     */
    public function isResetTokenValid(string $token): bool
    {
        return
            $this->resetToken === $token        &&
            $this->resetTokenExpiresAt !== null &&
            $this->resetTokenExpiresAt > time();
    }
}