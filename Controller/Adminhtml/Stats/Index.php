<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Controller\Adminhtml\Stats;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Api\Data\WebsiteInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'PixelOpen_Plausible::plausible_stats';

    protected PageFactory $resultPageFactory;

    protected WebsiteRepositoryInterface $websiteRepository;

    protected StoreManagerInterface $storeManager;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        WebsiteRepositoryInterface $websiteRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->websiteRepository = $websiteRepository;
        $this->storeManager = $storeManager;

        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $result = $this->resultPageFactory->create();

        try {
            $result->getConfig()
                ->getTitle()
                ->prepend(__('Plausible Analytics: %1', $this->getWebsite()->getName()));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(
                __('The website with id %1 does not exist', $this->getWebsiteId())
            );
            $result = $this->resultRedirectFactory->create();
            $result->setPath('adminhtml/dashboard');
        }

        return $result;
    }

    /**
     * Retrieve current website view
     */
    public function getWebsite(): WebsiteInterface
    {
        return $this->websiteRepository->getById($this->getWebsiteId());
    }

    /**
     * Retrieve the website identifier
     */
    public function getWebsiteId(): int
    {
        return (int) $this->getRequest()
            ->getParam('website', $this->storeManager->getDefaultStoreView() ->getWebsiteId());
    }
}
