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
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Script extends Template
{
    /**
     * Path to template file in theme.
     *
     * @var string $_template
     * @phpcs:disable
     */
    protected $_template = 'PixelOpen_Plausible::script.phtml';

    protected Config $config;

    /**
     * @param Template\Context $context
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $config,
        array $data = []
    ) {
        $this->config = $config;

        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isTrackingEnabled();
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return (string)parse_url($this->getBaseUrl(), PHP_URL_HOST);
    }

    /**
     * @return string
     */
    public function getInstanceUrl(): string
    {
        return $this->config->getInstanceUrl();
    }

    /**
     * @return string
     */
    public function getScriptUrl(): string
    {
        $script = $this->getInstanceUrl() . '/js/script.js';

        if ($this->config->isRevenueTrackingEnabled()) {
            $script = $this->getInstanceUrl() . '/js/script.revenue.js';
        }

        return $script;
    }
}
