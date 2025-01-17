<?php

declare(strict_types=1);

namespace PayonePayment\PaymentMethod;

use PayonePayment\Installer\PaymentMethodInstaller;
use PayonePayment\PaymentHandler\PayoneIDealPaymentHandler;

class PayoneIDeal extends AbstractPaymentMethod
{
    public const UUID = PaymentMethodInstaller::PAYMENT_METHOD_IDS[self::class];

    /** @var string */
    protected $id = self::UUID;

    /** @var string */
    protected $name = 'Payone iDeal';

    /** @var string */
    protected $description = 'Wire the amount instantly with your online banking credentials.';

    /** @var string */
    protected $paymentHandler = PayoneIDealPaymentHandler::class;

    /** @var null|string */
    protected $template = '@Storefront/storefront/payone/ideal/ideal-form.html.twig';

    /** @var array */
    protected $translations = [
        'de-DE' => [
            'name'        => 'PAYONE iDeal',
            'description' => 'Überweisen Sie schnell und sicher mit Ihren Online Banking Zugangsdaten.',
        ],
        'en-GB' => [
            'name'        => 'PAYONE iDeal',
            'description' => 'Wire the amount instantly with your online banking credentials.',
        ],
    ];

    /** @var int */
    protected $position = 110;
}
