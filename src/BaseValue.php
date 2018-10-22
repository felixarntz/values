<?php
/**
 * Class FelixArntz\Values\BaseValue
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values;

use FelixArntz\Values\Exception\ValueValidationException;
use FelixArntz\Contracts\SchemaAwareTrait;

/**
 * Class for a value object.
 *
 * @since 1.0.0
 */
class BaseValue implements Value
{
    use SchemaAwareTrait;

    /**
     * Raw value.
     *
     * @since 1.0.0
     * @var mixed
     */
    protected $value;

    /**
     * Constructor.
     *
     * Sets the value and schema.
     *
     * @since 1.0.0
     *
     * @param mixed       $value  Raw value.
     * @param ValueSchema $schema Value schema.
     */
    public function __construct($value, ValueSchema $schema)
    {
        $this->setSchema($schema);

        if ($value === null) {
            $this->value = $this->getSchema()->getDefault();
        }

        $this->value = $this->getSchema()->parse($value);
    }

    /**
     * Gets the raw value.
     *
     * @since 1.0.0
     *
     * @return mixed Raw value.
     */
    public function getRaw()
    {
        return $this->value;
    }

    /**
     * Sets the raw value.
     *
     * @since 1.0.0
     *
     * @param mixed $value Raw value.
     * @return Value New value object.
     */
    public function setRaw($value) : Value
    {
        return new static($value, $this->getSchema());
    }

    /**
     * Validates the value.
     *
     * @since 1.0.0
     *
     * @throws ValueValidationException Thrown if validation fails.
     */
    public function validate()
    {
        $this->getSchema()->validate($this);
    }

    /**
     * Sanitizes the value.
     *
     * @since 1.0.0
     *
     * @return mixed Sanitized raw value.
     */
    public function sanitize()
    {
        $this->value = $this->getSchema()->sanitize($this);

        return $this->value;
    }

    /**
     * Formats the value.
     *
     * @since 1.0.0
     *
     * @param int $flags Optional. Bitwise flags to adjust formatting. Default 0.
     * @return mixed Formatted raw value.
     */
    public function format(int $flags = 0)
    {
        return $this->getSchema()->format($this, $flags);
    }

    /**
     * Checks whether the value is empty.
     *
     * @since 1.0.0
     *
     * @return bool True if the value is empty, false otherwise.
     */
    public function isEmpty() : bool
    {
        return empty($this->value);
    }

    /**
     * Checks whether the value equals another given value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to compare.
     * @return bool True if the values are equal, false otherwise.
     */
    public function isEqualTo(Value $value) : bool
    {
        if ($this === $value) {
            return true;
        }

        return $this->value === $value->getRaw();
    }

    /**
     * Returns a string representation of the value.
     *
     * @since 1.0.0
     *
     * @return string String representation of the value.
     */
    public function __toString() : string
    {
        if (is_array($this->value)) {
            return implode(',', $this->value);
        }

        return (string) $this->value;
    }
}
