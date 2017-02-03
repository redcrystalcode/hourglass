<?php
declare(strict_types = 1);

/**
 * Gets the current build time.
 *
 * @return int
 */
function build_time() : int
{
    return Hourglass\Deploy\BuildAttributes::getInstance()->getBuildTime();
}

/**
 * Create a Carbon instance intelligently.
 *
 * @param mixed $source
 * @param \DateTimeZone|string|null $tz
 *
 * @return \Carbon\Carbon
 */
function carbon($source, $tz = null) : Carbon\Carbon
{
    if ($source instanceof DateTimeInterface) {
        return new Carbon\Carbon(
            $source->format('Y-m-d H:i:s.u'),
            $source->getTimeZone()
        );
    }

    return new Carbon\Carbon($source, $tz);
}

/**
 * @param string $subdomain
 *
 * @return string
 */
function subdomain(string $subdomain) : string
{
    $info = parse_url(config('app.url'));
    return $subdomain . '.' . $info['host'];
}
