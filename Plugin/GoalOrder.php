<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Plugin;

use Magento\Checkout\Controller\Onepage\Success;
use Magento\Checkout\Model\Session;
use Magento\Checkout\Model\Session\SuccessValidator;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Sales\Api\Data\OrderInterface;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalOrder
{
    protected Goals $goals;

    protected Session $checkoutSession;

    protected SuccessValidator $successValidator;

    protected Config $config;

    public function __construct(
        Goals $goals,
        Session $checkoutSession,
        SuccessValidator $successValidator,
        Config $config
    ) {
        $this->goals = $goals;
        $this->checkoutSession = $checkoutSession;
        $this->successValidator = $successValidator;
        $this->config = $config;
    }

    /**
     * Add goal when order succeeds
     */
    public function beforeExecute(Success $subject)
    {
        if (! $this->successValidator->isValid()) {
            return null;
        }

        $order = $subject->getOnepage()
            ->getCheckout()
            ->getLastRealOrder();

        if (! $order) {
            return null;
        }

        $this->goals->add(Config::PLAUSIBLE_GOAL_ORDER, [], $this->getRevenue($order));

        return null;
    }

    /**
     * Reload only when customer is not redirected
     */
    public function afterExecute(Success $subject, ResultInterface $result): ResultInterface
    {
        if ($result instanceof Page) {
            $this->goals->send();
        }

        return $result;
    }

    /**
     * @return mixed[]
     */
    public function getRevenue(OrderInterface $order): array
    {
        if (! $this->config->isRevenueTrackingEnabled()) {
            return [];
        }

        return [
            'revenue' => [
                'currency' => $order->getOrderCurrencyCode(),
                'amount' => (float) $order->getGrandTotal(),
            ],
        ];
    }
}
