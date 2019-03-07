<?php
namespace Smile\ProductLabel\Controller\Adminhtml\ImageLabel;
/**
 * Class Image
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */
class Image extends AbstractUpload
{
    /**
     * @return string
     */
    public function getFileId()
    {
        return 'image';
    }


}