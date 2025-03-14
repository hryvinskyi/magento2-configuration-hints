<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Api;

use Magento\Config\Model\Config\Structure\AbstractElement;

interface ConfigPathProviderInterface
{
    /**
     * Get the config path for a given field
     *
     * @param AbstractElement $field
     * @return string
     */
    public function getPath(AbstractElement $field): string;
}