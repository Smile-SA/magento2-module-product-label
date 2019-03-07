<?php

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\Collection;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Class Form DataProvider
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface
     */
    private $modifierPool;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * DataProvider constructor
     *
     * @param string                                          $name
     * @param string                                          $primaryFieldName
     * @param string                                          $requestFieldName
     * @param CollectionFactory                               $collectionFactory
     * @param DataPersistorInterface                          $dataPersistor
     * @param \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool
     * @param array                                           $meta
     * @param array                                           $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->modifierPool  = $modifierPool;
        $this->dataPersistor = $dataPersistor;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        foreach ($this->getCollection()->getItems() as $itemId => $item) {
            $this->data[$itemId] = $item->toArray();
        }

        $data = $this->dataPersistor->get('smile_productlabel_productlabel');
        if (!empty($data)) {
            $productLabel = $this->collection->getNewEmptyItem();
            $productLabel->setData($data);
            $this->data[$productLabel->getId()] = $productLabel->getData();
            $this->dataPersistor->clear('smile_productlabel_productlabel');
        }

        /** @var \Magento\Ui\DataProvider\Modifier\ModifierInterface $modifier */
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }

        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta()
    {
        $this->meta = parent::getMeta();

        /** @var \Magento\Ui\DataProvider\Modifier\ModifierInterface $modifier */
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $this->meta = $modifier->modifyMeta($this->meta);
        }

        return $this->meta;
    }
}