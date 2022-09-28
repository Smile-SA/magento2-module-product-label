<?php

declare(strict_types=1);

/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Block\Adminhtml\ProductLabel\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Smile\ProductLabel\Api\ProductLabelRepositoryInterface;

/**
 * Adminhtml block: Abstract Button
 *
 * @category  Smile
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
abstract class AbstractButton implements ButtonProviderInterface
{
    protected Context $context;

    protected ProductLabelRepositoryInterface $repository;

    /**
     * AbstractButton constructor.
     *
     * @param Context                         $context    UI Component context
     * @param ProductLabelRepositoryInterface $repository Product Label Repository
     */
    public function __construct(
        Context $context,
        ProductLabelRepositoryInterface $repository
    ) {
        $this->context    = $context;
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    abstract public function getButtonData();

    /**
     * Return object ID.
     */
    public function getObjectId(): ?int
    {
        try {
            $modelId = (int) $this->context->getRequest()->getParam('product_label_id');

            /** @var \Smile\ProductLabel\Api\Data\ProductLabelInterface $model */
            $model = $this->repository->getById($modelId);

            return $model->getProductLabelId();
        } catch (NoSuchEntityException $e) {
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
