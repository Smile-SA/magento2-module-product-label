<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Thumbnail for Ui component
 */
class Thumbnail extends Column
{
    protected const NAME = 'thumbnail';

    protected const ALT_FIELD = 'name';

    /**
     * Thumbnail constructor.
     *
     * @param ContextInterface                           $context            Context
     * @param UiComponentFactory                         $uiComponentFactory UI Component Factory
     * @param \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper        Image Helper
     * @param \Magento\Framework\UrlInterface            $urlBuilder         URL Builder
     * @param array                                      $components         Components
     * @param array                                      $data               Column Data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Smile\ProductLabel\Model\ImageLabel\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->urlBuilder  = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource Data source
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$fieldName . '_src']      = $this->imageHelper->getBaseUrl() . '/' . $item['image'];
                $item[$fieldName . '_alt']      = $this->getAlt($item) ?: $this->imageHelper->getLabel();
                $item[$fieldName . '_link']     = $this->urlBuilder->getUrl(
                    'smile_productlabel/productlabel/edit',
                    ['product_label_id' => $item['product_label_id']]
                );
                $item[$fieldName . '_orig_src'] = $this->imageHelper->getBaseUrl() . '/' . $item['image'];
            }
        }

        return $dataSource;
    }

    /**
     * Get alt
     *
     * @param array $row The row
     */
    protected function getAlt(array $row): ?string
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;

        return $row[$altField] ?? null;
    }
}
