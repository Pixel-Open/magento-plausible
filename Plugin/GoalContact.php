<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Plugin;

use Magento\Contact\Model\MailInterface;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalContact
{
    protected Goals $goals;

    public function __construct(
        Goals $goals
    ) {
        $this->goals = $goals;
    }

    /**
     * Add goal after message was sent
     */
    public function afterSend(MailInterface $subject): void
    {
        $this->goals->add(Config::PLAUSIBLE_GOAL_CONTACT);
    }
}
