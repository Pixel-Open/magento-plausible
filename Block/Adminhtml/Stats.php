<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use PixelOpen\Plausible\Helper\Config;

class Stats extends Template
{
    /**
     * @var string $_template
     * @phpcs:disable
     */
    protected $_template = 'PixelOpen_Plausible::stats.phtml';

    protected Config $config;

    /**
     * @param Context $context
     * @param Config $config
     * @param array $data
     * @param JsonHelper|null $jsonHelper
     * @param DirectoryHelper|null $directoryHelper
     */
    public function __construct(
        Context $context,
        Config $config,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        $this->config = $config;

        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
    }

    /**
     * Is Plausible admin stats enabled
     *
     * @return bool
     */
    public function canShow(): bool
    {
        return $this->config->isAdminStatsEnabled();
    }

    /**
     * @return string
     */
    public function getSharedLink(): string
    {
        return $this->config->getAdminStatsSharedLink($this->getWebsiteId());
    }

    /**
     * @return string
     */
    public function getInstanceUrl(): string
    {
        return $this->config->getInstanceUrl();
    }

    /**
     * @return int|null
     */
    public function getWebsiteId(): ?int
    {
        $websiteId = $this->getRequest()->getParam('website');

        return $websiteId ? (int)$websiteId : null;
    }

    /**
     * @return string
     */
    public function getConfigLink(): string
    {
        return $this->getUrl(
            'adminhtml/system_config/edit',
            [
                'section' => 'pixel_open_plausible',
                'website' => $this->getWebsiteId(),
            ]
        );
    }
}
