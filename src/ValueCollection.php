<?php
/**
 * Interface FelixArntz\Values\ValueCollection
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values;

use FelixArntz\Values\Exception\ValueValidationException;

/**
 * Interface for a collection of values.
 *
 * @since 1.0.0
 */
interface ValueCollection
{

    /**
     * Finds a value object by its identifier and returns it.
     *
     * @since 1.0.0
     *
     * @param string $id Value identifier.
     * @return Value The value object.
     *
     * @throws ValueNotFoundException Thrown if the value was not found.
     */
    public function get(string $id) : Value;

    /**
     * Determines whether a value of a given identifier is available.
     *
     * @since 1.0.0
     *
     * @param string $id Value identifier.
     * @return bool True if the value is available, false otherwise.
     */
    public function has(string $id) : bool;

    /**
     * Validates and sets new values for the collection.
     *
     * @since 1.0.0
     *
     * @param array $data Associative array of $id => $rawValue pairs.
     * @return ValueCollection New value collection.
     *
     * @throws ValueValidationException Thrown when validation fails.
     */
    public function updateValues(array $data) : ValueCollection;
}
