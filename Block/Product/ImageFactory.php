<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Romain Ruaud <romain.ruaud@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ProductLabel\Block\Product;

use Magento\Catalog\Block\Product\Image as ImageBlock;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Image\ParamsBuilder;
use Magento\Catalog\Model\View\Asset\ImageFactory as AssetImageFactory;
use Magento\Catalog\Model\View\Asset\PlaceholderFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\ConfigInterface;

/**
 * Custom Image Factory.
 * It's a copy paste of the legacy image factory. Override is only in create() method and is highlighted.
 *
 * @category Smile
 * @package  Smile\ProductLabel
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class ImageFactory extends \Magento\Catalog\Block\Product\ImageFactory
{
    /**
     * @var ConfigInterface
     */
    private $presentationConfig;

    /**
     * @var AssetImageFactory
     */
    private $viewAssetImageFactory;

    /**
     * @var ParamsBuilder
     */
    private $imageParamsBuilder;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var PlaceholderFactory
     */
    private $viewAssetPlaceholderFactory;

    /**
     * @var string
     */
    private $template;

    /**
     * @param ObjectManagerInterface $objectManager               Object Manager
     * @param ConfigInterface        $presentationConfig          Presentation Config
     * @param AssetImageFactory      $viewAssetImageFactory       Images Asset Factory
     * @param PlaceholderFactory     $viewAssetPlaceholderFactory Assets Placeholder Factory
     * @param ParamsBuilder          $imageParamsBuilder          Images Param builer
     * @param string                 $template                    Image block template
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ConfigInterface $presentationConfig,
        AssetImageFactory $viewAssetImageFactory,
        PlaceholderFactory $viewAssetPlaceholderFactory,
        ParamsBuilder $imageParamsBuilder,
        string $template = 'Smile_ProductLabel::product/image_with_pictos.phtml'
    ) {
        $this->objectManager               = $objectManager;
        $this->presentationConfig          = $presentationConfig;
        $this->viewAssetPlaceholderFactory = $viewAssetPlaceholderFactory;
        $this->viewAssetImageFactory       = $viewAssetImageFactory;
        $this->imageParamsBuilder          = $imageParamsBuilder;
        $this->template                    = $template;
    }

    /**
     * Create image block from product
     *
     * @SuppressWarnings(PHPMD.ElseExpression) Method is inherited
     *
     * @param Product    $product    The Product
     * @param string     $imageId    Image Id
     * @param array|null $attributes Attributes
     *
     * @return ImageBlock
     */
    public function create(Product $product, string $imageId, array $attributes = null): ImageBlock
    {
        $viewImageConfig = $this->presentationConfig->getViewConfig()->getMediaAttributes(
            'Magento_Catalog',
            ImageHelper::MEDIA_TYPE_CONFIG_NODE,
            $imageId
        );

        $imageMiscParams  = $this->imageParamsBuilder->build($viewImageConfig);
        $originalFilePath = $product->getData($imageMiscParams['image_type']);

        if ($originalFilePath === null || $originalFilePath === 'no_selection') {
            $imageAsset = $this->viewAssetPlaceholderFactory->create(
                [
                    'type' => $imageMiscParams['image_type'],
                ]
            );
        } else {
            $imageAsset = $this->viewAssetImageFactory->create(
                [
                    'miscParams' => $imageMiscParams,
                    'filePath'   => $originalFilePath,
                ]
            );
        }

        $data = [
            'data' => [
                'template'          => 'Smile_ProductLabel::product/image_with_pictos.phtml',
                'image_url'         => $imageAsset->getUrl(),
                'width'             => $imageMiscParams['image_width'],
                'height'            => $imageMiscParams['image_height'],
                'label'             => $this->getLabel($product, $imageMiscParams['image_type']),
                'ratio'             => $this->getRatio($imageMiscParams['image_width'], $imageMiscParams['image_height']),
                'custom_attributes' => $this->getStringCustomAttributes($attributes),
                'product_id'        => $product->getId(),
            ],
        ];

        // Override starts here.
        /** @var \Smile\ProductLabel\Block\ProductLabel\ProductLabel $labelsRenderer */
        $labelsRenderer = $this->objectManager->create(\Smile\ProductLabel\Block\ProductLabel\ProductLabel::class);
        $labelsRenderer->setProduct($product);

        $data['data']['product_labels']               = $labelsRenderer->getProductLabels() ?? [];
        $data['data']['product_labels_wrapper_class'] = $labelsRenderer->getWrapperClass() ?? [];

        /** @var ImageBlock $block */
        $block = $this->objectManager->create(ImageBlock::class, $data);

        return $block;
    }

    /**
     * Retrieve image custom attributes for HTML element
     *
     * @param array $attributes Attributes
     *
     * @return string
     */
    private function getStringCustomAttributes(array $attributes): string
    {
        $result = [];
        foreach ($attributes as $name => $value) {
            $result[] = $name . '="' . $value . '"';
        }

        return !empty($result) ? implode(' ', $result) : '';
    }

    /**
     * Calculate image ratio
     *
     * @param int $width  Width
     * @param int $height Height
     *
     * @return float
     */
    private function getRatio(int $width, int $height): float
    {
        if ($width && $height) {
            return $height / $width;
        }

        return 1.0;
    }

    /**
     * @param Product $product   The product
     * @param string  $imageType The image type
     *
     * @return string
     */
    private function getLabel(Product $product, string $imageType): string
    {
        $label = $product->getData($imageType . '_' . 'label');
        if (empty($label)) {
            $label = $product->getName();
        }

        return (string) $label;
    }
}
