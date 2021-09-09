<?php

namespace CheckoutCustom\Attribute\Controller\Checkout;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Checkout\Model\Session;
use Magento\Quote\Api\CartRepositoryInterface;

class SaveInQuote extends Action
{
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * Save Quote Constructor.
     * @param Context $context
     * @param Session $checkoutSession
     * @param CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        Context $context,
        Session $checkoutSession,
        CartRepositoryInterface $quoteRepository
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;

        parent::__construct($context);
    }

    /**
     * Save quote action
     */
    public function execute()
    {
        // get info of $quote when order
       /* $checkVal = $this->getRequest()->getParam('checkVal');
        $quoteId = $this->checkoutSession->getQuoteId();
        $quote = $this->quoteRepository->get($quoteId);
        $quote->setAgree($checkVal);
        $quote->save();*/
    }
}