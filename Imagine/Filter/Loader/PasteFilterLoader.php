<?php

namespace Liip\ImagineBundle\Imagine\Filter\Loader;

use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Symfony\Component\Filesystem\Filesystem;

class PasteFilterLoader implements LoaderInterface
{
    /**
     * @var ImagineInterface
     */
    protected $imagine;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $rootPath;

    public function __construct(ImagineInterface $imagine, Filesystem $filesystem, $rootPath)
    {
        $this->imagine = $imagine;
        $this->filesystem = $filesystem;
        $this->rootPath = $rootPath;
    }

    /**
     * @see Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface::load()
     */
    public function load(ImageInterface $image, array $options = array())
    {
        list($x, $y) = $options['start'];

        $path = $options['image'];
        if (!$this->filesystem->isAbsolutePath($options['image'])) {
            $path = $this->rootPath.'/'.$path;
        }

        $destImage = $this->imagine->open($path);

        return $image->paste($destImage, new Point($x, $y));
    }
}
