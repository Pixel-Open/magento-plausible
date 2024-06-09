<?php
/**
 * Copyright (C) 2024 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Plugin;

use Magento\Catalog\Controller\Category\View;
use Magento\Framework\Controller\ResultInterface;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalCategory
{
    protected Goals $goals;

    public function __construct(
        Goals $goals
    ) {
        $this->goals = $goals;
    }

    /**
     * Add goal when customer visits a category
     */
    public function afterExecute(View $subject, ResultInterface $result): ResultInterface
    {
        $this->goals->add(Config::PLAUSIBLE_GOAL_CATEGORY);

        return $result;
    }
}
