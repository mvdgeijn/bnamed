<?php

namespace Exonet\Powerdns\Transformers;

class AllTLDsTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform()
    {
        return (object) [
            'dnssec' => $this->data['dnssec'],
        ];
    }
}
