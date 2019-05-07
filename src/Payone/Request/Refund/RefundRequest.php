<?php

declare(strict_types=1);

namespace PayonePayment\Payone\Request\Refund;

use PayonePayment\Installer\CustomFieldInstaller;
use PayonePayment\Payone\Request\RequestInterface;
use PayonePayment\Payone\Request\System\SystemRequest;
use PayonePayment\Payone\Struct\PaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Exception\InvalidOrderException;
use Shopware\Core\Framework\Context;

class RefundRequest implements RequestInterface
{
    public function getParentRequest(): string
    {
        return SystemRequest::class;
    }

    public function getRequestParameters(PaymentTransactionStruct $transaction, Context $context): array
    {
        $order = $transaction->getOrder();

        if (null === $order) {
            throw new InvalidOrderException($transaction->getOrderTransaction()->getOrderId());
        }

        $customFields = $transaction->getOrderTransaction()->getCustomFields();

        if (empty($customFields[CustomFieldInstaller::TRANSACTION_ID])) {
            throw new InvalidOrderException($transaction->getOrderTransaction()->getOrderId());
        }

        if (empty($customFields[CustomFieldInstaller::SEQUENCE_NUMBER])) {
            throw new InvalidOrderException($transaction->getOrderTransaction()->getOrderId());
        }

        if ($customFields[CustomFieldInstaller::SEQUENCE_NUMBER] < 1) {
            throw new InvalidOrderException($transaction->getOrderTransaction()->getOrderId());
        }

        return [
            'request'        => 'refund',
            'txid'           => $customFields[CustomFieldInstaller::TRANSACTION_ID],
            'sequencenumber' => $customFields[CustomFieldInstaller::SEQUENCE_NUMBER] + 1,
            'amount'         => -1 * (int) ($order->getAmountTotal() * 100),
            'currency'       => $order->getCurrency()->getShortName(),
        ];
    }
}
