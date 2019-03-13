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

namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Filesystem\Directory\ReadInterface;

/**
 * Class FileInfo
 * Provides information about requested file
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <houda.elrhozlane@smile.fr>
 */
class FileInfo
{
    /**
     * Path in /pub/media directory
     */
    const ENTITY_MEDIA_PATH = '/smile_productlabel/imagelabel';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Mime
     */
    private $mime;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var ReadInterface
     */
    private $baseDirectory;

    /**
     * FileInfo constructor.
     *
     * @param Filesystem $filesystem Filesystem Helper
     * @param Mime       $mime       MIME type
     */
    public function __construct(
        Filesystem $filesystem,
        Mime $mime
    ) {
        $this->filesystem = $filesystem;
        $this->mime       = $mime;
    }

    /**
     * Retrieve MIME type of requested file
     *
     * @param string $fileName The filename
     *
     * @return string
     */
    public function getMimeType($fileName)
    {
        $filePath         = $this->getFilePath($fileName);
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath($filePath);

        $result = $this->mime->getMimeType($absoluteFilePath);

        return $result;
    }

    /**
     * Get file statistics data
     *
     * @param string $fileName The filename
     *
     * @return array
     */
    public function getStat($fileName)
    {
        $filePath = $this->getFilePath($fileName);

        $result = $this->getMediaDirectory()->stat($filePath);

        return $result;
    }

    /**
     * Check if the file exists
     *
     * @param string $fileName The filename
     *
     * @return bool
     */
    public function isExist($fileName)
    {
        $filePath = $this->getFilePath($fileName);
        $result   = $this->getMediaDirectory()->isExist($filePath);

        return $result;
    }

    /**
     * Checks for whether $fileName string begins with media directory path
     *
     * @param string $fileName The filename
     *
     * @return bool
     */
    public function isBeginsWithMediaDirectoryPath($fileName)
    {
        $filePath = ltrim($fileName, '/');

        $mediaDirectoryRelativeSubpath          = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath();
        $isFileNameBeginsWithMediaDirectoryPath = strpos($filePath, $mediaDirectoryRelativeSubpath) === 0;

        return $isFileNameBeginsWithMediaDirectoryPath;
    }

    /**
     * Construct and return file subpath based on filename relative to media directory
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @param string $fileName The filename
     *
     * @return string
     */
    private function getFilePath($fileName)
    {
        $filePath = ltrim($fileName, '/');

        $mediaDirectoryRelativeSubpath          = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath();
        $isFileNameBeginsWithMediaDirectoryPath = $this->isBeginsWithMediaDirectoryPath($fileName);

        // If the file is not using a relative path, it resides in the catalog/category media directory.
        $fileIsInCategoryMediaDir = !$isFileNameBeginsWithMediaDirectoryPath;

        if ($fileIsInCategoryMediaDir) {
            $filePath = self::ENTITY_MEDIA_PATH . '/' . $filePath;
        } else {
            $filePath = substr($filePath, strlen($mediaDirectoryRelativeSubpath));
        }

        return $filePath;
    }

    /**
     * Get media directory subpath relative to base directory path
     *
     * @return string
     */
    private function getMediaDirectoryPathRelativeToBaseDirectoryPath()
    {
        $baseDirectoryPath  = $this->getBaseDirectory()->getAbsolutePath();
        $mediaDirectoryPath = $this->getMediaDirectory()->getAbsolutePath();

        $mediaDirectoryRelativeSubpath = substr($mediaDirectoryPath, strlen($baseDirectoryPath));

        return $mediaDirectoryRelativeSubpath;
    }

    /**
     * Get WriteInterface instance
     *
     * @return WriteInterface
     */
    private function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }

        return $this->mediaDirectory;
    }

    /**
     * Get Base Directory read instance
     *
     * @return ReadInterface
     */
    private function getBaseDirectory()
    {
        if (!isset($this->baseDirectory)) {
            $this->baseDirectory = $this->filesystem->getDirectoryRead(DirectoryList::ROOT);
        }

        return $this->baseDirectory;
    }
}
