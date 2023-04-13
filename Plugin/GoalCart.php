<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Plugin;

use Magento\Checkout\Controller\Cart\Index;
use Magento\Checkout\Model\Session;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals;

class GoalCart
{
    protected Goals $goals;

    protected Session $checkoutSession;

    /**
     * @param Goals $goals
     * @param Session $checkoutSession
     */
    public function __construct(
        Goals $goals,
        Session $checkoutSession
    ) {
        $this->goals = $goals;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Add goal when customer visits the cart
     *
     * @param Index $subject
     * @param ResultInterface $result
     * @return ResultInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function afterExecute(Index $subject, ResultInterface $result): ResultInterface
    {
        if ($this->checkoutSession->getQuote()->hasItems()) {
            $this->goals->add(Config::PLAUSIBLE_GOAL_CART)->reload();
        }

        return $result;
    }
}
