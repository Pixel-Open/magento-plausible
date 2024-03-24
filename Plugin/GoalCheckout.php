<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Plugin;

use Magento\Checkout\Controller\Index\Index;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalCheckout
{
    protected Goals $goals;

    public function __construct(
        Goals $goals
    ) {
        $this->goals = $goals;
    }

    /**
     * Add goal when customer visits the checkout
     *
     * @return Page
     */
    public function afterExecute(Index $subject, ResultInterface $result): ResultInterface
    {
        if ($result instanceof Page) {
            $this->goals->add(Config::PLAUSIBLE_GOAL_CHECKOUT)->send();
        }

        return $result;
    }
}
