<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Model;

use Hryvinskyi\ConfigurationHints\Api\RequestScopeReaderInterface;
use Magento\Framework\App\RequestInterface;

readonly class RequestScopeReader implements RequestScopeReaderInterface
{
    public function __construct(
        private RequestInterface $request
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteCode(): ?string
    {
        return $this->request->getParam('website');
    }

    /**
     * @inheritDoc
     */
    public function getStoreCode(): ?string
    {
        return $this->request->getParam('store');
    }
}