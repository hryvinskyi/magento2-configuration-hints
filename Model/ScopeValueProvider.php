<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Model;

use Hryvinskyi\ConfigurationHints\Api\ScopeValueProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

readonly class ScopeValueProvider implements ScopeValueProviderInterface
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getScopeValue(string $path, string $scopeType, $scopeId)
    {
        return $this->scopeConfig->getValue($path, $scopeType, $scopeId);
    }
}