<?php

declare(strict_types=1);

namespace Smile\ProductLabel\Model\ImageLabel;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
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
     * @throws FileSystemException
     */
    public function getMimeType(string $fileName): string
    {
        $filePath         = $this->getFilePath($fileName);
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath($filePath);

        return $this->mime->getMimeType($absoluteFilePath);
    }

    /**
     * Get file statistics data
     */
    public function getStat(string $fileName): array
    {
        $filePath = $this->getFilePath($fileName);

        return $this->getMediaDirectory()->stat($filePath);
    }

    /**
     * Check if the file exists
     */
    public function isExist(string $fileName): bool
    {
        $filePath = $this->getFilePath($fileName);

        return $this->getMediaDirectory()->isExist($filePath);
    }

    /**
     * Checks for whether $fileName string begins with media directory path
     */
    public function isBeginsWithMediaDirectoryPath(string $fileName): bool
    {
        $filePath = ltrim($fileName, '/');
        $mediaDirectoryRelativeSubpath = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath();

        return strpos($filePath, $mediaDirectoryRelativeSubpath) === 0;
    }

    /**
     * Construct and return file subpath based on filename relative to media directory
     */
    private function getFilePath(string $fileName): string
    {
        $filePath = ltrim($fileName, '/');

        $mediaDirectoryRelativeSubpath          = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath();
        $isFileNameBeginsWithMediaDirectoryPath = $this->isBeginsWithMediaDirectoryPath($fileName);

        // If the file is not using a relative path, it resides in the catalog/category media directory.
        $fileIsInCategoryMediaDir = !$isFileNameBeginsWithMediaDirectoryPath;

        return $fileIsInCategoryMediaDir
            ? self::ENTITY_MEDIA_PATH . '/' . $filePath
            : substr($filePath, strlen($mediaDirectoryRelativeSubpath));
    }

    /**
     * Get media directory subpath relative to base directory path
     */
    private function getMediaDirectoryPathRelativeToBaseDirectoryPath(): string
    {
        $baseDirectoryPath  = $this->getBaseDirectory()->getAbsolutePath();
        $mediaDirectoryPath = $this->getMediaDirectory()->getAbsolutePath();

        return substr($mediaDirectoryPath, strlen($baseDirectoryPath));
    }

    /**
     * Get WriteInterface instance
     *
     * @throws FileSystemException
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
