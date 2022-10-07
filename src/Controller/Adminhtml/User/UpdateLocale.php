<?php
/**
 * Copyright © Q-Solutions Studio: eCommerce Nanobots. All rights reserved.
 *
 * @category    Nanobots
 * @package     Nanobots_AdminLocaleSwitcher
 * @author      Jakub Winkler <jwinkler@qsolutionsstudio.com
 */

namespace Nanobots\AdminLocaleSwitcher\Controller\Adminhtml\User;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\User\Model\ResourceModel\User;

class UpdateLocale extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /** @var Session  */
    protected Session $session;

    /** @var User  */
    protected User $userResource;

    /**
     * @param Session $session
     * @param Context $context
     * @param User $userResource
     */
    public function __construct(
        Session $session,
        Context $context,
        User $userResource
    ) {
        $this->session = $session;
        $this->userResource = $userResource;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     * @throws AlreadyExistsException
     */
    public function execute(): Redirect
    {
        $user = $this->session->getUser();
        $locale = $this->_request->getParam('admin-locale');
        $user->setInterfaceLocale($locale);
        $this->userResource->save($user);
        $resultRedirect = $this->resultRedirectFactory->create();

        $url = $this->_redirect->getRefererUrl();
        $resultRedirect->setPath(
            $url
        );

        $this->messageManager->addSuccessMessage(
            __('Your locale settings have been updated')
        );

        return $resultRedirect;
    }
}
