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
class ProductLabelDataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Magento\Framework\App\RequestInterface
     * @since 101.0.0
     */
    protected $request;

    /**
     * @var \Smile\ProductLabel\Model\ImageLabel\FileInfo
     */
    protected $fileInfo;

    /**
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface
     */
    private $modifierPool;

    /**
     * ProductLabelDataProvider constructor.
     *
     * @param string                                          $name
     * @param string                                          $primaryFieldName
     * @param string                                          $requestFieldName
     * @param CollectionFactory                               $collectionFactory
     * @param DataPersistorInterface                          $dataPersistor
     * @param \Magento\Framework\App\RequestInterface         $request
     * @param \Smile\ProductLabel\Model\ImageLabel\FileInfo   $fileInfo
     * @param \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool
     * @param DataPersistorInterface                          $dataPersistor
     * @param array                                           $meta
     * @param array                                           $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\App\RequestInterface $request,
        \Smile\ProductLabel\Model\ImageLabel\FileInfo $fileInfo,
        \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->fileInfo = $fileInfo;
        $this->request = $request;
        $this->modifierPool  = $modifierPool;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

//    /**
//     * @inheritdoc
//     */
//    public function getData()
//    {
//        if (isset($this->loadedData)) {
//            return $this->loadedData;
//        }
//
//        $requestId = $this->request->getParam($this->requestFieldName);
//        $productLabel = $this->collection->addFieldToFilter($this->requestFieldName, $requestId)->getFirstItem();
//
//        if ($productLabel->getId()) {
//            $data = $this->convertValues($productLabel, $productLabel->getData());
//
//            $this->loadedData[$productLabel->getId()] = $data;
//        }
//        /** @var \Magento\Ui\DataProvider\Modifier\ModifierInterface $modifier */
//        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
//            $this->loadedData = $modifier->modifyData($this->loadedData);
//        }
//
//        return $this->loadedData;
//    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        foreach ($this->getCollection()->getItems() as $itemId => $item) {
            $this->data[$itemId] = $item->toArray();
        }

        $data = $this->dataPersistor->get('smile_productlabel_productlabel');
        if (!empty($data)) {
            $productLabel = $this->collection->getNewEmptyItem();
            $data = $this->convertValues($productLabel, $data);
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
     * Converts category image data to acceptable for rendering format
     *
     * @param \Smile\ProductLabel\Model\ProductLabel $productLabel
     * @param array $data
     * @return array
     */
    private function convertValues($productLabel, $data)
    {
        $fileName = $productLabel->getData('image');

        if ($this->fileInfo->isExist($fileName)) {
            $stat = $this->fileInfo->getStat($fileName);
            $mime = $this->fileInfo->getMimeType($fileName);

            $data['image'][0]['name'] = basename($fileName);

            if ($this->fileInfo->isBeginsWithMediaDirectoryPath($fileName)) {
                $data['image'][0]['url'] = $fileName;
            } else {
                $data['image'][0]['url'] = $productLabel->getImageUrl();
            }

            $data['image'][0]['size'] = isset($stat) ? $stat['size'] : 0;
            $data['image'][0]['type'] = $mime;
        }

        return $data;
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