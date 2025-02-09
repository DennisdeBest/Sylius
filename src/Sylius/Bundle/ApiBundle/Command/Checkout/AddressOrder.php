<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ApiBundle\Command\Checkout;

use Sylius\Bundle\ApiBundle\Command\OrderTokenValueAwareInterface;
use Sylius\Component\Addressing\Model\AddressInterface;

/** @experimental */
class AddressOrder implements OrderTokenValueAwareInterface
{
    public ?string $orderTokenValue = null;

    /**
     * @psalm-immutable
     */
    public ?string $email;

    /**
     * @psalm-immutable
     */
    public AddressInterface $billingAddress;

    /**
     * @psalm-immutable
     */
    public ?AddressInterface $shippingAddress;

    public function __construct(?string $email, AddressInterface $billingAddress, ?AddressInterface $shippingAddress = null)
    {
        $this->email = $email;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
    }

    public function getOrderTokenValue(): ?string
    {
        return $this->orderTokenValue;
    }

    public function setOrderTokenValue(?string $orderTokenValue): void
    {
        $this->orderTokenValue = $orderTokenValue;
    }
}
