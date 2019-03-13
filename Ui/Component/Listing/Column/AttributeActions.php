<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\Escaper;

/**
 * Class Product Label Actions
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class AttributeActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'smile_productlabel/productlabel/edit';
    const URL_PATH_DELETE = 'smile_productlabel/productlabel/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Escaper
     */
    protected $escaper;

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
     * {@inheritdoc}
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
