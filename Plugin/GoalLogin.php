<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Plugin;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalLogin
{
    protected Goals $goals;

    /**
     * @param Goals $goals
     */
    public function __construct(
        Goals $goals
    ) {
        $this->goals = $goals;
    }

    /**
     * Add goal after customer was connected
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterAuthenticate(AccountManagementInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $this->goals->add(Config::PLAUSIBLE_GOAL_LOGIN);

        return $result;
    }
}
