<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Psr\Log\LoggerInterface;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface;

/**
 * Adminhtml block: Abstract Button
 */
abstract class AbstractButton implements ButtonProviderInterface
{
    protected Context $context;
    protected ProductLabelRepositoryInterface $repository;
    protected LoggerInterface $logger;

    /**
     * AbstractButton constructor.
     */
    public function __construct(
        Context $context,
        ProductLabelRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        $this->context = $context;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * Get button data
     */
    abstract public function getButtonData(): array;

    /**
     * Return object ID.
     */
    public function getObjectId(): ?int
    {
        try {
            $modelId = (int) $this->context->getRequest()->getParam('product_label_id');
            $model = $this->repository->getById($modelId);

            return $model->getProductLabelId();
        } catch (NoSuchEntityException $e) {
            $this->logger->critical($e->getMessage());
        }

        return null;
    }

    /**
     * Generate url by route and parameters.
     *
     * @param string $route  URL route
     * @param array  $params URL params
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
