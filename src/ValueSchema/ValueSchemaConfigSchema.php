<?php
/**
 * Class FelixArntz\Values\ValueSchema\ValueSchemaConfigSchema
 *
 * @package FelixArntz\Values
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/values
 */

namespace FelixArntz\Values\ValueSchema;

use FelixArntz\Config\Config;
use FelixArntz\Config\ConfigSchema;
use FelixArntz\Config\Exception\ConfigValidationException;

/**
 * Class for a configuration schema that does nothing.
 *
 * @since 1.0.0
 */
class ValueSchemaConfigSchema implements ConfigSchema
{

    const ID                = 'id';
    const DESCRIPTION       = 'description';
    const DEFAULT           = 'default';
    const VALIDATE_CALLBACK = 'validate_callback';
    const SANITIZE_CALLBACK = 'sanitize_callback';
    const FORMAT_CALLBACK   = 'format_callback';
    const REQUIRED          = 'required';
    const SKIP              = 'skip';

    /**
     * Validates a configuration object against the schema.
     *
     * @since 1.0.0
     *
     * @param Config $config Configuration object to validate.
     *
     * @throws ConfigValidationException Thrown when validation fails.
     */
    public function validate(Config $config)
    {
        if (!$config->has(self::ID)) {
            throw ConfigValidationException::fromMissingKey(self::ID);
        }

        $id = $config->get(self::ID);
        if (!is_string($id)) {
            throw ConfigValidationException::fromInvalidKey(self::ID, 'The value must be a string.');
        }
    }
}
