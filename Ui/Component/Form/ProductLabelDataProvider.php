<?php

namespace Smile\ProductLabel\Ui\Component\Form;

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
     * @var \Magento\Framework\App\RequestInterface
     * @since 101.0.0
     */
    protected $request;
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Smile\ProductLabel\Model\ImageLabel\FileInfo
     */
    protected $fileInfo;

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
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->fileInfo = $fileInfo;
        $this->request = $request;

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
//        $items = $this->collection->getItems();
//        /** @var \Training\Seller\Model\Seller $model */
//        foreach ($items as $model) {
//            $this->loadedData[$model->getId()] = $model->getData();
//        }
//
//        $data = $this->dataPersistor->get('smile_productlabel_productlabel');
//        if (!empty($data)) {
//            $model = $this->collection->getNewEmptyItem();
//            $data = $this->convertValues($model, $data);
//            $model->setData($data);
//            $this->loadedData[$model->getId()] = $model->getData();
//            $this->dataPersistor->clear('smile_productlabel_productlabel');
//        }
//
//        return $this->loadedData;
//    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Smile\ProductLabel\Model\ProductLabel $model */
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }

        $data = $this->dataPersistor->get('smile_productlabel_productlabel');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $data = $this->convertValues($model, $data);
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('smile_productlabel_productlabel');
        }

        return $this->loadedData;
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

}