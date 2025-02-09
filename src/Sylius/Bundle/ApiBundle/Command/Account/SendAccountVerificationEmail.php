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

namespace Sylius\Bundle\ApiBundle\Command\Account;

/**
 * @experimental
 * @psalm-immutable
 */
class SendAccountVerificationEmail
{
    public string $shopUserEmail;

    public string $localeCode;

    public string $channelCode;

    public function __construct(string $shopUserEmail, string $localeCode, string $channelCode)
    {
        $this->shopUserEmail = $shopUserEmail;
        $this->localeCode = $localeCode;
        $this->channelCode = $channelCode;
    }
}
