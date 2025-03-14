<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Api;

interface ScopeValueProviderInterface
{
    /**
     * Get the scope value for a given path, scope type, and scope ID
     *
     * @param string $path
     * @param string $scopeType
     * @param int|string $scopeId
     * @return mixed
     */
    public function getScopeValue(string $path, string $scopeType, $scopeId);
}