<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Api;

interface RequestScopeReaderInterface
{
    /**
     * Get the current request scope type
     *
     * @return string|null
     */
    public function getWebsiteCode(): ?string;

    /**
     * Get the current request scope type
     *
     * @return string|null
     */
    public function getStoreCode(): ?string;
}