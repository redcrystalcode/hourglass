<?php
declare(strict_types = 1);

/**
 * Gets the current build time.
 *
 * @return int
 */
function build_time() : int {
    return Hourglass\Deploy\BuildAttributes::getInstance()->getBuildTime();
}
