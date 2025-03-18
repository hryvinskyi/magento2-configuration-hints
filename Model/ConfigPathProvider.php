<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Model;

use Hryvinskyi\ConfigurationHints\Api\ConfigPathProviderInterface;

class ConfigPathProvider implements ConfigPathProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getPath(\Magento\Config\Model\Config\Structure\AbstractElement $field): string
    {
        return $field->getConfigPath() ?: $field->getPath();
    }
}