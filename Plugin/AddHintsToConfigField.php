<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Plugin;

use Hryvinskyi\ConfigurationHints\Api\ConfigPathProviderInterface;
use Hryvinskyi\ConfigurationHints\Model\HintGenerator;
use Magento\Config\Model\Config\Structure\Element\Field;

class AddHintsToConfigField
{
    private bool $isProcessing = false;

    public function __construct(
        private readonly HintGenerator $hintGenerator,
        private readonly ConfigPathProviderInterface $configPathProvider
    ) {
    }

    public function afterGetTooltip(Field $subject, string $result): string
    {
        return $this->hintGenerator->getTooltipContent($subject, $result);
    }

    public function afterGetData(Field $subject, array $result): array
    {
        if ($this->isProcessing === false) {
            $this->isProcessing = true;
            $pathRaw = $this->configPathProvider->getPath($subject);

            $html = '<small class="config-path-copy">
                <span class="config-path-label">' . __('Config Path:') . '</span>
                <code class="copy-path-code" data-config-path="' . $pathRaw . '">' . $pathRaw . '</code>
            </small>';

            $result['additional_comment_hint'] = $html;
            $this->isProcessing = false;
        }

        return $result;
    }
}