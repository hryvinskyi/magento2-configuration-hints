<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Model;

use Magento\Config\Model\Config\Structure\AbstractElement;
use Magento\Framework\Escaper;

class ValueFormatter
{
    public function __construct(
        private readonly Escaper $escaper
    ) {
    }

    public function getFormattedValue(AbstractElement $field, string $value): string
    {
        $value = trim($value);

        if ($field->hasOptions()) {
            if ($field->getType() === 'multiselect' && str_contains($value, ',')) {
                return implode(
                    ', ',
                    array_map(
                        function ($key) use ($field) {
                            return $this->getFormattedValue($field, $key);
                        },
                        explode(',', $value)
                    )
                );
            }

            foreach ($field->getOptions() as $option) {
                if (is_array($option) && $option['value'] == $value) {
                    return (string)$option['label'];
                }
            }
        }

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $value = $this->escaper->escapeHtml($value);

        // Strip long strings to a maximum of 100 characters
        if (strlen($value) > 100) {
            $value = substr($value, 0, 100) . '...';
        }

        return $value;
    }
}