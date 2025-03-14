<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Model;

use Hryvinskyi\ConfigurationHints\Api\ConfigPathProviderInterface;
use Hryvinskyi\ConfigurationHints\Api\RequestScopeReaderInterface;
use Hryvinskyi\ConfigurationHints\Api\ScopeValueProviderInterface;
use Magento\Config\Model\Config\Structure\AbstractElement;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\Store\Model\ScopeInterface;

readonly class HintGenerator
{
    public function __construct(
        private ConfigPathProviderInterface $configPathProvider,
        private ScopeValueProviderInterface $scopeValueProvider,
        private RequestScopeReaderInterface $requestScopeReader,
        private ValueFormatter $valueFormatter,
        private StoreRepositoryInterface $storeRepository,
        private WebsiteRepositoryInterface $websiteRepository
    ) {
    }

    public function getTooltipContent(AbstractElement $field, string $originalTooltip): string
    {
        $lines = [$originalTooltip];
        $websiteCode = $this->requestScopeReader->getWebsiteCode();
        $storeCode = $this->requestScopeReader->getStoreCode();

        // Website scope hints
        foreach($this->websiteRepository->getList() as $website) {
            if ($websiteCode || $storeCode) {
                continue;
            }

            if ($scopeLine = $this->getScopeHint($field, ScopeInterface::SCOPE_WEBSITES, $website)) {
                $lines[] = $scopeLine;
            }
        }

        // Store scope hints
        foreach($this->storeRepository->getList() as $store) {
            if ($storeCode && $store->getCode() === $storeCode) {
                continue;
            }

            if ($websiteCode && $store->getWebsiteId() != $this->getWebsiteId($websiteCode)) {
                continue;
            }

            if ($scopeLine = $this->getScopeHint($field, ScopeInterface::SCOPE_STORES, $store)) {
                $lines[] = $scopeLine;
            }
        }

        return implode('<br>', array_filter($lines));
    }

    private function getScopeHint(AbstractElement $field, string $scopeType, $scope): ?string
    {
        $path = $this->configPathProvider->getPath($field);
        $websiteCode = $this->requestScopeReader->getWebsiteCode();

        if ($websiteCode) {
            $websiteId = $this->getWebsiteId($websiteCode);
            $currentValue = $this->scopeValueProvider->getScopeValue($path, ScopeInterface::SCOPE_WEBSITE, $websiteId);
        } else {
            $currentValue = $this->scopeValueProvider->getScopeValue($path, ScopeConfigInterface::SCOPE_TYPE_DEFAULT, null);
        }

        $scopeValue = $this->scopeValueProvider->getScopeValue($path, $scopeType, $scope->getId());

        if (is_array($currentValue) || is_array($scopeValue)) {
            return null;
        }

        $currentValue = (string) $currentValue;
        $scopeValue = (string) $scopeValue;

        if ($scopeValue != $currentValue) {
            $formattedValue = $this->valueFormatter->getFormattedValue($field, $scopeValue);

            switch($scopeType) {
                case ScopeInterface::SCOPE_STORES:
                    return __(
                        'Store <code>%1</code>: "%2"',
                        $scope->getCode(),
                        $formattedValue
                    )->render();
                case ScopeInterface::SCOPE_WEBSITES:
                    return __(
                        'Website <code>%1</code>: "%2"',
                        $scope->getCode(),
                        $formattedValue
                    )->render();
            }
        }

        return null;
    }

    private function getWebsiteId(string $websiteCode): ?int
    {
        try {
            $website = $this->websiteRepository->get($websiteCode);

            return $website->getId() ? (int) $website->getId() : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}