<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserDataToSend extends Model
{
    const pix = 'PIX';
    const cartao_de_credito = 'CARTAO_DE_CREDITO';
    const boleto = 'BOLETO';

    protected $table = 'user_data_to_sends';
    protected $fillable = [
        'fullname', 'email', 'zipcode', 'city', 'state', 'street', 'number', 'additional', 'district', 'payment'
    ];

    public function scopeTypeOfPayment(Builder $builder, string $typePayment): Builder{
        switch($typePayment){
            case 'pix':
                return $builder->where('payment', static::pix);
            case 'cartao_de_credito':
                return $builder->where('payment', static::cartao_de_credito);
            case 'boleto':
                return $builder->where('payment', static::boleto);
        }

        return $builder;
    }

    public function scopePaymentWithPix(Builder $builder): Builder{
        return $this->scopeTypeOfPayment($builder, static::pix);
    }

    public function scopePaymentWithCartao(Builder $builder): Builder{
        return $this->scopeTypeOfPayment($builder, static::cartao_de_credito);
    }

    public function scopePaymentWithBoleto(Builder $builder): Builder{
        return $this->scopeTypeOfPayment($builder, static::boleto);
    }
}
