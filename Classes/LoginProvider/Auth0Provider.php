<?php

namespace GeorgRinger\Auth0\LoginProvider;

use GeorgRinger\GoogleSignin\Domain\Model\Dto\ExtensionConfiguration;
use GeorgRinger\GoogleSignin\Service\StatusService;
use TYPO3\CMS\Backend\Controller\LoginController;
use TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use Auth0\SDK\Auth0;

class Auth0Provider implements LoginProviderInterface
{

    /**
     * @param StandaloneView $view
     * @param PageRenderer $pageRenderer
     * @param LoginController $loginController
     */
    public function render(StandaloneView $view, PageRenderer $pageRenderer, LoginController $loginController)
    {
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:auth0/Resources/Private/Templates/Backend.html'));
        $auth0 = new Auth0([
            'domain' => 'ringer.eu.auth0.com',
            'client_id' => '-kaVkOM7s98Wj74xweXCu993sSMmKXN0',
            'client_secret' => 'UL-4rH9ZF7Pezq5OSrtPqVQc1FFmnpHL24htARwgt6dS296iksz3eCYHOr7lQpl5',
            'redirect_uri' => 'http://t3-master.vm/typo3/?loginProvider=1526966635&callback=1',
            'audience' => 'https://ringer.eu.auth0.com/userinfo',
            'scope' => 'openid profile',
            'persist_id_token' => true,
            'persist_access_token' => true,
            'persist_refresh_token' => true,
        ]);
        if (GeneralUtility::_GET('logout') == 1) {
            $auth0->logout();
        }
//        $auth0->deleteAllPersistentData();
//        $auth0->login();
//        die;

        try {
            $userInfo = $auth0->getUser();

            if (!$userInfo) {
                $auth0->login();
            } else {
                $userInfo = $auth0->getUser();
                $view->assign('userInfo', $userInfo);
            }
        } catch (\Exception $e) {
            $auth0->deleteAllPersistentData();
        }

    }
}
