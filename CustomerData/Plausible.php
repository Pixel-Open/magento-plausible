<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use PixelOpen\Plausible\Session\Goals;

class Plausible implements SectionSourceInterface
{
    protected Goals $goals;

    public function __construct(
        Goals $goals
    ) {
        $this->goals = $goals;
    }

    /**
     * @return mixed[]
     */
    public function getSectionData(): array
    {
        $goals = $this->goals->get();

        $this->goals->reset();

        return [
            'goals' => $goals,
        ];
    }
}
