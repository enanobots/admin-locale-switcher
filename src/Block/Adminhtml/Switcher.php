<?php
/**
 * Copyright © Q-Solutions Studio: eCommerce Nanobots. All rights reserved.
 *
 * @category    Nanobots
 * @package     Nanobots_AdminLocaleSwitcher
 * @author      Jakub Winkler <jwinkler@qsolutionsstudio.com
 */

namespace Nanobots\AdminLocaleSwitcher\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Locale\OptionInterface;

class Switcher extends Template
{
    /** @var string  */
    protected $_template = 'Nanobots_AdminLocaleSwitcher::switcher.phtml';

    /** @var Session  */
    protected Session $authSession;

    /** @var OptionInterface */
    protected OptionInterface $localeOptions;

    /**
     * @param OptionInterface $localeOptions
     * @param Session $authSession
     * @param Context $context
     */
    public function __construct(
        OptionInterface $localeOptions,
        Session $authSession,
        Context $context
    ) {
        $this->localeOptions = $localeOptions;
        $this->authSession = $authSession;
        parent::__construct($context, []);
    }

    /**
     * Get Admin User Interface Locale
     *
     * @return string
     */
    public function getUserLocaleIcon(): string
    {
        $userLocal = $this->authSession->getUser()->getInterfaceLocale();
        return $this->getViewFileUrl(sprintf('Nanobots_AdminLocaleSwitcher/locale-flags/%s.svg', $userLocal));
    }

    /**
     * @return array
     */
    public function getDeployedLocales(): array
    {
        return $this->localeOptions->getTranslatedOptionLocales();
    }

    /**
     * @return string|false
     */
    public function getCountryListJSON(): ?string
    {
        $select2Countries = [];
        $locales = $this->localeOptions->getTranslatedOptionLocales();
        foreach ($locales as $locale) {
            $select2Countries[] = [
                'id' => $locale['value'],
                'text' => $locale['label'],
                'flag' => $this->getViewFileUrl(sprintf('Nanobots_AdminLocaleSwitcher/locale-flags/%s.svg', $locale['value'])),
            ];
        }

        return json_encode($select2Countries);
    }
}
