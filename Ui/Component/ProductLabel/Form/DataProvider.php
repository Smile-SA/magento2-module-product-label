<?php

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
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
     * @var \Smile\ProductLabel\Model\ImageLabel\FileInfo
     */
    protected $fileInfo;

    /**
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface
     */
    private $modifierPool;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    protected $request;

    /**
     * DataProvider constructor.
     *
     * @param string                                          $name
     * @param string                                          $primaryFieldName
     * @param string                                          $requestFieldName
     * @param CollectionFactory                               $collectionFactory
     * @param DataPersistorInterface                          $dataPersistor
     * @param \Magento\Framework\App\RequestInterface         $request
     * @param \Smile\ProductLabel\Model\ImageLabel\FileInfo   $fileInfo
     * @param \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool
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
        $this->modifierPool  = $modifierPool;
        $this->fileInfo = $fileInfo;
        $this->request = $request;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $requestId = $this->request->getParam($this->requestFieldName);
        /** @var \Smile\ProductLabel\Model\ProductLabel $productLabel */
        $productLabel = $this->collection->addFieldToFilter($this->requestFieldName, $requestId)->getFirstItem();

        if ($productLabel->getId()) {
            $data = $this->convertValues($productLabel, $productLabel->getData());
            $this->data[$productLabel->getId()] = $data;
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

        if ($fileName && $this->fileInfo->isExist($fileName)) {
            $stat = $this->fileInfo->getStat($fileName);
            $mime = $this->fileInfo->getMimeType($fileName);

            unset($data['image']);
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