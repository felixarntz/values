<?php
/**
 * Interface FelixArntz\Values\Value
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values;

use FelixArntz\Contracts\Validatable;
use FelixArntz\Contracts\Sanitizable;
use FelixArntz\Contracts\Formatable;
use FelixArntz\Contracts\SchemaAware;

/**
 * Interface for a value object.
 *
 * @since 1.0.0
 */
interface Value extends Validatable, Sanitizable, Formatable, SchemaAware
{

    /**
     * Gets the raw value.
     *
     * @since 1.0.0
     *
     * @return mixed Raw value.
     */
    public function getRaw();

    /**
     * Sets the raw value.
     *
     * @since 1.0.0
     *
     * @param mixed $value Raw value.
     * @return Value New value object.
     */
    public function setRaw($value) : Value;

    /**
     * Checks whether the value is empty.
     *
     * @since 1.0.0
     *
     * @return bool True if the value is empty, false otherwise.
     */
    public function isEmpty() : bool;

    /**
     * Checks whether the value equals another given value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to compare.
     * @return bool True if the values are equal, false otherwise.
     */
    public function isEqualTo(Value $value) : bool;

    /**
     * Returns a string representation of the value.
     *
     * @since 1.0.0
     *
     * @return string String representation of the value.
     */
    public function __toString() : string;
}
