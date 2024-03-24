<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use PixelOpen\Plausible\Helper\Config;

class Script extends Template
{
    /**
     * Path to template file in theme.
     *
     * @var string
     * @phpcs:disable
     */
    protected $_template = 'PixelOpen_Plausible::script.phtml';

    protected Config $config;

    /**
     * @param Template\Context $context
     */
    public function __construct(
        Context $context,
        Config $config,
        array $data = []
    ) {
        $this->config = $config;

        parent::__construct($context, $data);
    }

    public function isEnabled(): bool
    {
        return $this->config->isTrackingEnabled();
    }

    public function getHost(): string
    {
        return (string) parse_url($this->getBaseUrl(), PHP_URL_HOST);
    }

    public function getInstanceUrl(): string
    {
        return $this->config->getInstanceUrl();
    }

    public function getScriptUrl(): string
    {
        $script = $this->getInstanceUrl() . '/js/script.js';

        if ($this->config->isRevenueTrackingEnabled()) {
            $script = $this->getInstanceUrl() . '/js/script.revenue.js';
        }

        return $script;
    }
}
