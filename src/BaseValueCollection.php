<?php
/**
 * Class FelixArntz\Values\BaseValueCollection
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values;

use FelixArntz\Values\Exception\ValueNotFoundException;
use FelixArntz\Values\Exception\ValueValidationException;
use FelixArntz\Values\Exception\SkipValueValidationException;

/**
 * Class for a collection of values.
 *
 * @since 1.0.0
 */
class BaseValueCollection implements ValueCollection
{

    /**
     * Value objects in the collection, as $id => $value pairs.
     *
     * @since 1.0.0
     * @var array
     */
    protected $values = [];

    /**
     * Constructor.
     *
     * Sets the value objects in the collection.
     *
     * @since 1.0.0
     *
     * @param array $values List of {@see Value} instances.
     */
    public function __construct(array $values)
    {
        array_walk(
            $values,
            function(Value $value) {
                $id                = $value->getSchema()->getId();
                $this->values[$id] = $value;
            }
        );
    }

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
    public function get(string $id) : Value
    {
        if (isset($this->values[$id])) {
            return $this->values[$id];
        }

        throw new ValueNotFoundException('Value has not been found.');
    }

    /**
     * Determines whether a value of a given identifier is available.
     *
     * @since 1.0.0
     *
     * @param string $id Value identifier.
     * @return bool True if the value is available, false otherwise.
     */
    public function has(string $id) : bool
    {
        return isset($this->values[$id]);
    }

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
    public function updateValues(array $data) : ValueCollection
    {
        // TODO: This is far from final.
        $newCollection = clone $this;

        array_walk(
            $this->values,
            function(Value $value, string $id) {
                $newData  = isset($data[$id]) ? $data[$id] : null;
                $newValue = $value->setRaw($newData);

                try {
                    $newValue->validate();
                } catch (SkipValueValidationException $e) {
                    return;
                }

                $newValue->sanitize();

                $newCollection->values[$id] = $newValue;
            }
        );

        return $newCollection;
    }
}
