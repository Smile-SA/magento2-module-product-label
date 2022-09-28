<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form\Modifier;

/**
 * Smile Product label edit form data provider modifier :
 * Used to add the proper value for reloadUrl inside UI component configuration.
 */
class System implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    private \Magento\Backend\Model\UrlInterface $urlBuilder;

    /**
     * Search Terms constructor.
     *
     * @param \Magento\Backend\Model\UrlInterface $urlBuilder URL Builder
     */
    public function __construct(\Magento\Backend\Model\UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        $reloadParameters = [
            'popup'         => 1,
            'componentJson' => 1,
        ];

        $data['config']['reloadUrl'] = $this->urlBuilder->getUrl('*/*/reload', $reloadParameters);

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
