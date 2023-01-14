<?php

namespace App\Service;

class ShortCutService
{
    private $takeIn;
    private $lend;
    private $pay;
    private $shortCuts = [];

    /**
     * ShortCutService constructor.
     */
    public function __construct()
    {
        $this->takeIn = setting('short_cut_take_in', null);
        $this->lend = setting('short_cut_lend', null);
        $this->pay = setting('short_cut_pay', null);

        $this->shortCuts = [
            $this->takeIn => 'take-in.member',
            $this->lend => 'lend.member',
            $this->pay => 'pay.member',
        ];
    }

    /**
     * @param string $shortcut
     * @return bool
     */
    public function hasShortCut(string $shortcut)
    {
        return isset($this->shortCuts[$shortcut]) && !empty($this->shortCuts[$shortcut]);
    }

    /**
     * @param string $shortcut
     * @param array $parameters
     * @return string|null
     */
    public function getShortCutRedirect(string $shortcut, $parameters = [])
    {
        if ($this->hasShortCut($shortcut)) {
            switch (strtolower($shortcut)) {
                case $this->takeIn;
                    return route($this->shortCuts[$shortcut]);
                case $this->lend;
                    if (isset($parameters['member_id']) && !empty($parameters['member_id'])) {
                        return route($this->shortCuts[$shortcut], ['member' => $parameters['member_id'] ?? '']);
                    }
                    return route('lend');
                case $this->pay;
                    if (isset($parameters['member_id']) && !empty($parameters['member_id'])) {
                        return route($this->shortCuts[$shortcut], ['member' => $parameters['member_id'] ?? '']);
                    }
                    return null;
                default:
                    return null;
            }
        }

        return null;
    }
}
