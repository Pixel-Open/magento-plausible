<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\Session;

use Magento\Customer\Model\Session;
use PixelOpen\Plausible\Helper\Config;

class Goals
{
    protected Session $session;

    protected Config $config;

    /**
     * @param Session $session
     * @param Config $config
     */
    public function __construct(
        Session $session,
        Config $config
    ) {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * Add or update a goal
     *
     * @param string   $goal
     * @param string[] $params
     * @return Goals
     */
    public function add(string $goal, array $params = []): Goals
    {
        $goals = $this->get();

        $name = $this->config->getGoalName($goal);
        if (!empty($name)) {
            $goals[$name] = ['props' => $params];
        }

        return $this->set($goals);
    }

    /**
     * @param mixed[] $goals
     * @return Goals
     */
    public function set(array $goals): Goals
    {
        foreach ($goals as $name => $params) {
            if (is_array($params)) {
                continue;
            }
            unset($goals[$name]);
        }

        $this->session->setPlausibleGoals($goals);

        return $this;
    }

    /**
     * @param bool $clear
     * @return mixed[]
     */
    public function get(bool $clear = false): array
    {
        $goals = $this->session->getPlausibleGoals() ?: [];

        if ($clear) {
            $this->set([]);
        }

        return $goals;
    }

    /**
     * @return $this
     */
    public function reload(): Goals
    {
        $this->session->setPlausibleReload(true);

        return $this;
    }

    /**
     * @param bool $clear
     * @return bool
     */
    public function needReload(bool $clear = false): bool
    {
        $needReload = (bool)$this->session->getPlausibleReload();

        if ($clear) {
            $this->session->setPlausibleReload(false);
        }

        return $needReload;
    }
}
