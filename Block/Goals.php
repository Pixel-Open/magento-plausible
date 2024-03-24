<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Block;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use PixelOpen\Plausible\Helper\Config;
use PixelOpen\Plausible\Session\Goals as GoalsSession;

class Goals extends Template
{
    protected Config $config;

    protected GoalsSession $goals;

    protected Json $json;

    /**
     * @param Template\Context $context
     */
    public function __construct(
        Context $context,
        Config $config,
        GoalsSession $goals,
        Json $json,
        array $data = []
    ) {
        $this->config = $config;
        $this->goals = $goals;
        $this->json = $json;

        parent::__construct($context, $data);
    }

    public function isEnabled(): bool
    {
        return $this->config->isGoalsEnabled();
    }

    public function getJsLayout(): string
    {
        $this->jsLayout['components']['plausible']['config']['reload'] = $this->goals->needReload();

        return parent::getJsLayout();
    }

    /**
     * Retrieve goals for the current page
     *
     * @return mixed[]
     */
    public function getGoals(): array
    {
        $goals = $this->goals->get();

        foreach ($goals as $name => $params) {
            $goals[$name] = $this->json->serialize($params);
        }

        $this->goals->reset();

        return $goals;
    }
}
