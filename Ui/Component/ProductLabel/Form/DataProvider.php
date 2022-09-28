<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Ui\Component\ProductLabel\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Smile\ProductLabel\Model\ResourceModel\ProductLabel\CollectionFactory;

/**
 * Class Form DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    protected \Smile\ProductLabel\Model\ImageLabel\FileInfo $fileInfo;

    private \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool;

    private DataPersistorInterface $dataPersistor;

    protected \Magento\Framework\App\RequestInterface $request;

    /**
     * DataProvider constructor.
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @param string                                          $name              Component Name
     * @param string                                          $primaryFieldName  Primary Field Name
     * @param string                                          $requestFieldName  Request Field Name
     * @param CollectionFactory                               $collectionFactory Collection Factory
     * @param DataPersistorInterface                          $dataPersistor     Data Persistor
     * @param \Magento\Framework\App\RequestInterface         $request           HTTP Request
     * @param \Smile\ProductLabel\Model\ImageLabel\FileInfo   $fileInfo          File Info helper
     * @param \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool      Modifier Pool
     * @param array                                           $meta              Component Meta
     * @param array                                           $data              Component Data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\App\RequestInterface $request,
        \Smile\ProductLabel\Model\ImageLabel\FileInfo $fileInfo,
        \Magento\Ui\DataProvider\Modifier\PoolInterface $modifierPool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection    = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->modifierPool  = $modifierPool;
        $this->fileInfo      = $fileInfo;
        $this->request       = $request;

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
            $data                               = $this->convertValues($productLabel, $productLabel->getData());
            $this->data[$productLabel->getId()] = $data;
        }

        /** @var \Magento\Ui\DataProvider\Modifier\ModifierInterface $modifier */
        foreach ($this->modifierPool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }

        return $this->data;
    }

    /**
     * @inheritdoc
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
     * @param \Smile\ProductLabel\Model\ProductLabel $productLabel Product Label
     * @param array                                  $data         Product Label Data
     * @return array
     */
    private function convertValues(\Smile\ProductLabel\Model\ProductLabel $productLabel, array $data): array
    {
        $fileName = $productLabel->getData('image');

        if ($fileName && $this->fileInfo->isExist($fileName)) {
            $stat = $this->fileInfo->getStat($fileName);
            $mime = $this->fileInfo->getMimeType($fileName);

            unset($data['image']);
            $data['image'][0]['name'] = basename($fileName);

            $data['image'][0]['url'] = $productLabel->getImageUrl();
            if ($this->fileInfo->isBeginsWithMediaDirectoryPath($fileName)) {
                $data['image'][0]['url'] = $fileName;
            }

            $data['image'][0]['size'] = isset($stat) ? $stat['size'] : 0;
            $data['image'][0]['type'] = $mime;
        }

        return $data;
    }
}
