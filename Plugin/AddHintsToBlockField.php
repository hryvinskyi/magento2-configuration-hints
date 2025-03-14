<?php
/**
 * Copyright (c) 2025. Volodymyr Hryvinskyi. All rights reserved.
 * Author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 * GitHub: https://github.com/hryvinskyi
 */

declare(strict_types=1);

namespace Hryvinskyi\ConfigurationHints\Plugin;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class AddHintsToBlockField
{
    /**
     * @param Field $subject
     * @param AbstractElement $element
     *
     * @return array
     */
    public function beforeRender(
        Field $subject,
        AbstractElement $element
    ): array {
        $result = $element->getData('after_element_html');

        $element->setData(
            'after_element_html',
            $result . ($element->getData('field_config')['additional_comment_hint'] ?? '')
        );

        return [$element];
    }
}