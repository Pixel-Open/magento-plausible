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
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalOrder
{
    protected Goals $goals;

    protected Session $checkoutSession;

    protected SuccessValidator $successValidator;

    /**
     * @param Goals $goals
     * @param Session $checkoutSession
     * @param SuccessValidator $successValidator
     */
    public function __construct(
        Goals $goals,
        Session $checkoutSession,
        SuccessValidator $successValidator
    ) {
        $this->goals = $goals;
        $this->checkoutSession = $checkoutSession;
        $this->successValidator = $successValidator;
    }

    /**
     * Add goal when order succeeds
     *
     * @param Success $subject
     * @return array
     */
    public function beforeExecute(Success $subject): array
    {
        if (!$this->successValidator->isValid()) {
            return [];
        }

        $order = $subject->getOnepage()->getCheckout()->getLastRealOrder();

        $this->goals->add(Config::PLAUSIBLE_GOAL_ORDER, ['total' => (float)$order->getGrandTotal()]);

        return [];
    }

    /**
     * Reload only when customer is not redirected
     *
     * @param Success $subject
     * @param ResultInterface $result
     * @return ResultInterface
     */
    public function afterExecute(Success $subject, ResultInterface $result): ResultInterface
    {
        if ($result instanceof Page) {
            $this->goals->send();
        }

        return $result;
    }
}
