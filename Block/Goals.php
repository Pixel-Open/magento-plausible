<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Block;

use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals as GoalsSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Goals extends Template
{
    /**
     * Path to template file in theme.
     *
     * @var string $_template
     * @phpcs:disable
     */
    protected $_template = 'PixelOpen_Plausible::goals.phtml';

    protected Config $config;

    protected GoalsSession $goals;

    /**
     * @param Template\Context $context
     * @param Config $config
     * @param GoalsSession $goals
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $config,
        GoalsSession $goals,
        array $data = []
    ) {
        $this->config = $config;
        $this->goals = $goals;

        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isGoalsEnabled();
    }

    /**
     * @return string
     */
    public function getJsLayout(): string
    {
        $this->jsLayout['components']['plausible']['config']['reload'] = $this->goals->needReload();

        return parent::getJsLayout();
    }
}
