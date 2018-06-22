<?php
defined('TYPO3_MODE') || die();

$subTypes = [];
$subTypes[] = 'getUserBE,authUserBE';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1526966635] = [
    'provider' => \GeorgRinger\Auth0\LoginProvider\Auth0Provider::class,
    'sorting' => 25,
    'icon-class' => 'fa-google',
    'label' => 'LLL:EXT:auth0/Resources/Private/Language/locallang.xlf:backendLogin.switch.label'
];

if (!empty($subTypes)) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
        'auth0',
        'auth',
        'tx_auth0login_service',
        [
            'title' => 'Google Login Authentication',
            'description' => 'Google Login service for Frontend and Backend',
            'subtype' => implode(',', $subTypes),
            'available' => true,
            'priority' => 75,
            // Must be higher than for \TYPO3\CMS\Sv\AuthenticationService (50) or \TYPO3\CMS\Sv\AuthenticationService will log failed login attempts
            'quality' => 50,
            'os' => '',
            'exec' => '',
            'className' => \GeorgRinger\Auth0\Service\GoogleLoginService::class
        ]
    );
}

