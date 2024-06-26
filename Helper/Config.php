<?php
/**
 * Copyright (C) 2024 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    public const PLAUSIBLE_TRACKING_ENABLED = 'pixel_open_plausible/tracking/enabled';

    public const PLAUSIBLE_TRACKING_INSTANCE_URL = 'pixel_open_plausible/tracking/instance_url';

    public const PLAUSIBLE_GOALS_ENABLED = 'pixel_open_plausible/goals/enabled';

    public const PLAUSIBLE_GOALS_TYPE = 'pixel_open_plausible/goals/';

    public const PLAUSIBLE_REVENUE_TRACKING_ENABLED = 'pixel_open_plausible/revenue_tracking/enabled';

    public const PLAUSIBLE_ADMIN_STATS_ENABLED = 'pixel_open_plausible/admin/enabled';

    public const PLAUSIBLE_ADMIN_STATS_SHARED_LINK = 'pixel_open_plausible/admin/shared_link';

    public const PLAUSIBLE_SAAS_INSTANCE_URL = 'https://plausible.io';

    public const PLAUSIBLE_GOAL_CONTACT = 'contact';

    public const PLAUSIBLE_GOAL_REGISTER = 'register';

    public const PLAUSIBLE_GOAL_LOGIN = 'login';

    public const PLAUSIBLE_GOAL_CART = 'cart';

    public const PLAUSIBLE_GOAL_CHECKOUT = 'checkout';

    public const PLAUSIBLE_GOAL_ORDER = 'order';

    public const PLAUSIBLE_GOAL_PRODUCT = 'product';

    public const PLAUSIBLE_GOAL_CATEGORY = 'category';

    /**
     * Retrieve Instance URL
     */
    public function getInstanceUrl(): string
    {
        $url = $this->scopeConfig->getValue(self::PLAUSIBLE_TRACKING_INSTANCE_URL, ScopeInterface::SCOPE_STORE);

        if (!$url) {
            $url = self::PLAUSIBLE_SAAS_INSTANCE_URL;
        }

        return rtrim($url, '/');
    }

    /**
     * Is tracking enabled
     */
    public function isTrackingEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::PLAUSIBLE_TRACKING_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Is tracking enabled
     */
    public function isGoalsEnabled(): bool
    {
        $isGoalsEnabled = $this->scopeConfig->isSetFlag(self::PLAUSIBLE_GOALS_ENABLED, ScopeInterface::SCOPE_STORE);

        return $this->isTrackingEnabled() && $isGoalsEnabled;
    }

    /**
     * Is Revenue Tracking enabled
     */
    public function isRevenueTrackingEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::PLAUSIBLE_REVENUE_TRACKING_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Retrieve goal name
     */
    public function getGoalName(string $goal): string
    {
        return (string) $this->scopeConfig->getValue(self::PLAUSIBLE_GOALS_TYPE . $goal, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Is Admin Stats enabled
     */
    public function isAdminStatsEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::PLAUSIBLE_ADMIN_STATS_ENABLED);
    }

    /**
     * Retrieve admin stats shared link
     */
    public function getAdminStatsSharedLink(?int $websiteId = null): string
    {
        $link = (string) $this->scopeConfig->getValue(
            self::PLAUSIBLE_ADMIN_STATS_SHARED_LINK,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );

        if (!str_starts_with($link, $this->getInstanceUrl() . '/share')) {
            return '';
        }

        return $link;
    }
}
