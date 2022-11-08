<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\Filesystem\Directory\WriteInterface;

/**
 * Class FileInfo
 * Provides information about requested file
 */
class FileInfo
{
    /**
     * Path in /pub/media directory
     */
    public const ENTITY_MEDIA_PATH = '/smile_productlabel/imagelabel';

    private Filesystem $filesystem;

    private Mime $mime;

    private WriteInterface $mediaDirectory;

    private ReadInterface $baseDirectory;

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
     */
    public function getMimeType(string $fileName): string
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
     * @return array
     */
    public function getStat(string $fileName): array
    {
        $filePath = $this->getFilePath($fileName);

        $result = $this->getMediaDirectory()->stat($filePath);

        return $result;
    }

    /**
     * Check if the file exists
     *
     * @param string $fileName The filename
     */
    public function isExist(string $fileName): bool
    {
        $filePath = $this->getFilePath($fileName);
        $result   = $this->getMediaDirectory()->isExist($filePath);

        return $result;
    }

    /**
     * Checks for whether $fileName string begins with media directory path
     *
     * @param string $fileName The filename
     */
    public function isBeginsWithMediaDirectoryPath(string $fileName): bool
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
     * @param string $fileName The filename
     */
    private function getFilePath(string $fileName): string
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
     */
    private function getMediaDirectoryPathRelativeToBaseDirectoryPath(): string
    {
        $baseDirectoryPath  = $this->getBaseDirectory()->getAbsolutePath();
        $mediaDirectoryPath = $this->getMediaDirectory()->getAbsolutePath();

        $mediaDirectoryRelativeSubpath = substr($mediaDirectoryPath, strlen($baseDirectoryPath));

        return $mediaDirectoryRelativeSubpath;
    }

    /**
     * Get WriteInterface instance
     */
    private function getMediaDirectory(): WriteInterface
    {
        $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        return $this->mediaDirectory;
    }

    /**
     * Get Base Directory read instance
     */
    private function getBaseDirectory(): ReadInterface
    {
        if (!isset($this->baseDirectory)) {
            $this->baseDirectory = $this->filesystem->getDirectoryRead(DirectoryList::ROOT);
        }

        return $this->baseDirectory;
    }
}
