<?php
/**
 * Interface FelixArntz\Values\ValueSchema
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values;

use FelixArntz\Value\Exception\ValueValidationException;
use FelixArntz\Contracts\Schema;

/**
 * Interface for a value schema.
 *
 * @since 1.0.0
 */
interface ValueSchema extends Schema
{

    /**
     * Validates a value object against the schema.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to validate.
     *
     * @throws ValueValidationException Thrown when validation fails.
     */
    public function validate(Value $value);

    /**
     * Sanitizes a value object's raw value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to sanitize.
     * @return mixed Sanitized raw value.
     */
    public function sanitize(Value $value);

    /**
     * Formats a value object's raw value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to format.
     * @param int   $flags Optional. Bitwise flags to adjust formatting. Default 0.
     * @return mixed Formatted raw value.
     */
    public function format(Value $value, int $flags = 0);

    /**
     * Parses a raw value.
     *
     * @since 1.0.0
     *
     * @param mixed $value Raw value.
     * @return mixed Parsed raw value.
     */
    public function parse($value);

    /**
     * Gets the identifier for the value.
     *
     * @since 1.0.0
     *
     * @return string Identifier for the value.
     */
    public function getId() : string;

    /**
     * Gets the default raw value.
     *
     * @since 1.0.0
     *
     * @return mixed Default raw value.
     */
    public function getDefault();

    /**
     * Returns the JSON schema representation.
     *
     * @since 1.0.0
     *
     * @return array JSON schema representation as associative array.
     */
    public function toJson() : array;
}
