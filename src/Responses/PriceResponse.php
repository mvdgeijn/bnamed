<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class PriceResponse implements ResponseInterface
{
    public string $currency;

    public string $extend;

    public string $extendEndUser;

    public string $new;

    public string $newEndUser;

    public string $transfer;

    public string $transferEndUser;

    public string $update;

    public string $updateEndUser;

    public static function parse(SimpleXMLElement $element)
    {
        $price = new PriceResponse();

        $price->currency        = (string)$element->currency;

        $price->extend          = (string)$element->PriceExtend;
        $price->extendEndUser   = (string)$element->PriceExtendEndUser;

        $price->new             = (string)$element->PriceNew;
        $price->newEndUser      = (string)$element->PriceNewEndUser;

        $price->transfer        = (string)$element->PriceTransfer;
        $price->transferEndUser = (string)$element->PriceTransferEndUser;

        $price->update          = (string)$element->PriceUpdate;
        $price->updateEndUser   = (string)$element->PriceUpdateEndUser;

        return $price;
    }
}
