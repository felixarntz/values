<?php
/**
 * Class FelixArntz\Values\ValueSchema\AbstractValueSchema
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values\ValueSchema;

use FelixArntz\Value\Exception\ValueValidationException;
use FelixArntz\Values\Exception\SkipValueValidationException;
use FelixArntz\Values\ValueSchema;
use FelixArntz\Values\Value;
use FelixArntz\Config\Config;
use FelixArntz\Config\ConfigAwareTrait;

/**
 * Abstract class for a value schema.
 *
 * @since 1.0.0
 */
abstract class AbstractValueSchema implements ValueSchema
{
    use ConfigAwareTrait;

    /**
     * Constructor.
     *
     * Sets the configuration object.
     *
     * @since 1.0.0
     *
     * @param Config $config Configuration for the value schema.
     */
    public function __construct(Config $config)
    {
        $this->setSchema($config, new ValueSchemaConfigSchema());
    }

    /**
     * Validates a value object against the schema.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to validate.
     *
     * @throws ValueValidationException     Thrown when validation fails.
     * @throws SkipValueValidationException Thrown when validation is not necessary.
     */
    public function validate(Value $value)
    {
        if ($this->hasConfigKey(ValueSchemaConfigSchema::SKIP)
            && $this->getConfigKey(ValueSchemaConfigSchema::SKIP)
        ) {
            throw new SkipValueValidationException('The value does not need to be validated.');
        }

        if ($this->hasConfigKey(ValueSchemaConfigSchema::REQUIRED)
            && $this->getConfigKey(ValueSchemaConfigSchema::REQUIRED)
            && $value->isEmpty()
        ) {
            throw new ValueValidationException('The value must not be empty.');
        }

        $this->validateBase($value);

        if ($this->hasConfigKey(ValueSchemaConfigSchema::VALIDATE_CALLBACK)) {
            call_user_func_array(
                $this->getConfigKey(ValueSchemaConfigSchema::VALIDATE_CALLBACK),
                [
                    $value->getRaw(),
                ]
            );
        }
    }

    /**
     * Sanitizes a value object's raw value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to sanitize.
     * @return mixed Sanitized raw value.
     */
    public function sanitize(Value $value)
    {
        $sanitized = $this->sanitizeBase($value);

        if ($this->hasConfigKey(ValueSchemaConfigSchema::SANITIZE_CALLBACK)) {
            $sanitized = call_user_func_array(
                $this->getConfigKey(ValueSchemaConfigSchema::SANITIZE_CALLBACK),
                [
                    $sanitized,
                ]
            );
        }

        return $sanitized;
    }

    /**
     * Formats a value object's raw value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to format.
     * @param int   $flags Optional. Bitwise flags to adjust formatting. Default 0.
     * @return mixed Formatted raw value.
     */
    public function format(Value $value, int $flags = 0)
    {
        $formatted = $this->formatBase($value, $flags);

        if ($this->hasConfigKey(ValueSchemaConfigSchema::FORMAT_CALLBACK)) {
            $formatted = call_user_func_array(
                $this->getConfigKey(ValueSchemaConfigSchema::FORMAT_CALLBACK),
                [
                    $formatted,
                    $flags,
                ]
            );
        }

        return $formatted;
    }

    /**
     * Parses a raw value.
     *
     * @since 1.0.0
     *
     * @param mixed $value Raw value.
     * @return mixed Parsed raw value.
     */
    public function parse($value)
    {
        return $this->parseBase($value);
    }

    /**
     * Gets the identifier for the value.
     *
     * @since 1.0.0
     *
     * @return string Identifier for the value.
     */
    public function getId() : string
    {
        return $this->getConfigKey(ValueSchemaConfigSchema::ID);
    }

    /**
     * Gets the default raw value.
     *
     * @since 1.0.0
     *
     * @return mixed Default raw value.
     */
    public function getDefault()
    {
        if ($this->hasConfigKey(ValueSchemaConfigSchema::DEFAULT)) {
            return $this->getConfigKey(ValueSchemaConfigSchema::DEFAULT);
        }

        return $this->parse('');
    }

    /**
     * Runs base validation for a value object against the schema.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to validate.
     *
     * @throws ValueValidationException Thrown when validation fails.
     */
    abstract protected function validateBase(Value $value);

    /**
     * Runs base sanitization for a value object's raw value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to sanitize.
     * @return mixed Sanitized raw value.
     */
    abstract protected function sanitizeBase(Value $value);

    /**
     * Runs base formatting for a value object's raw value.
     *
     * @since 1.0.0
     *
     * @param Value $value Value object to format.
     * @param int   $flags Optional. Bitwise flags to adjust formatting. Default 0.
     * @return mixed Formatted raw value.
     */
    abstract protected function formatBase(Value $value, int $flags = 0);

    /**
     * Runs base parsing for a raw value.
     *
     * @since 1.0.0
     *
     * @param mixed $value Raw value.
     * @return mixed Parsed raw value.
     */
    abstract protected function parseBase($value);
}
