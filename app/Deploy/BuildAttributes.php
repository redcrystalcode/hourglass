<?php
declare(strict_types = 1);
namespace Hourglass\Deploy;

use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

final class BuildAttributes
{
    const FILE = '.buildattributes';

    /** @var \Hourglass\Deploy\BuildAttributes */
    private static $instance;

    /** @var int */
    private $buildTime;

    /**
     * BuildAttributes constructor.
     */
    private function __construct()
    {
        $this->buildTime = $this->generateBuildTime();
    }

    /**
     * @return \Hourglass\Deploy\BuildAttributes
     */
    public static function getInstance() : self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return int
     */
    public function getBuildTime() : int
    {
        return $this->buildTime;
    }

    private function generateBuildTime() : int
    {
        try {
            return (int)File::get(base_path(self::FILE));
        } catch (FileNotFoundException $e) {
            return 123;
        }
    }
}
