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
 * Assert that a given value is of a specified type.
 * This function is for use in situations where type safety
 * is desired but type hints cannot be used
 * (e.g. implementing vendor interfaces)
 *
 * @param mixed $value
 * @param string $expectedType
 *
 * @throws TypeError
 */
function assert_type($value, string $expectedType) : void
{
    $actualType = gettype($value);

    if ($actualType === $expectedType) {
        return;
    }

    if ($actualType === 'double' && $expectedType === 'float') {
        return;
    }

    if ($actualType === 'object' && is_a($actualType, $expectedType)) {
        return;
    }

    throw new TypeError("Argument must be of the type {$expectedType}, {$actualType} given");
}
