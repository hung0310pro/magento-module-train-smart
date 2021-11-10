<?php

namespace CheckoutCustom\Attribute\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Session\SessionManagerInterface;

class PlaceOrder implements ObserverInterface
{

    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * @var CookieMetadataFactory
     */
    protected $cookieMetadataFactory;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    const COOKIE_NAME = 'agree_cookie';

    /**
     * Constructor
     *
     * @param CookieManagerInterface $cookieManager
     * @param SessionManagerInterface $sessionManager
     * @param CookieMetadataFactory $cookieMetadataFactory
     */

    public function __construct(
        CookieManagerInterface $cookieManager,
        SessionManagerInterface $sessionManager,
        CookieMetadataFactory $cookieMetadataFactory
    )
    {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Get data from cookie set in remote address
     * @param string $name
     * @return int
     */
    public function getCookie(string $name): int
    {
        return $this->cookieManager->getCookie($name);
    }

    /**
     * Save Order Action
     * @param Observer $observer
     * @return bool
     */
    public function execute(Observer $observer): bool
    {
        $agreeValue = $this->getCookie(self::COOKIE_NAME);
        $order = $observer->getOrder();
        $order->setAgree($agreeValue);
        $this->delete(self::COOKIE_NAME);

        return $order->save();
    }

    /**
     * delete cookie remote address
     *
     * @return void
     */
    public function delete($name)
    {
        $this->cookieManager->deleteCookie(
            $name,
            $this->cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->sessionManager->getCookiePath())
                ->setDomain($this->sessionManager->getCookieDomain())
        );
    }
}