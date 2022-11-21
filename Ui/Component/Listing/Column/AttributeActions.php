<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Product Label Actions
 */
class AttributeActions extends Column
{
    /**
     * Url path
     */
    protected const URL_PATH_EDIT = 'smile_productlabel/productlabel/edit';
    protected const URL_PATH_DELETE = 'smile_productlabel/productlabel/delete';

    protected UrlInterface $urlBuilder;

    protected Escaper $escaper;

    /**
     * AttributeActions constructor.
     *
     * @param ContextInterface   $context            Context
     * @param UiComponentFactory $uiComponentFactory UI Component Factory
     * @param UrlInterface       $urlBuilder         URL Builder
     * @param Escaper            $escaper            Escaper
     * @param array              $components         Components
     * @param array              $data               Column Data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->escaper    = $escaper;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['product_label_id'])) {
                    $name                         = $this->escaper->escapeHtml($item['name']);
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                ['product_label_id' => $item['product_label_id']]
                            ),
                            'label' => __('Edit'),
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                ['product_label_id' => $item['product_label_id']]
                            ),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete %1', $name),
                                'message' => __('Are you sure you want to delete the "%1" product label?', $name),
                            ],
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
