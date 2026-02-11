<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosCreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:transferencia,pago_movil,efectivo,tarjeta,zelle',
            'status' => 'required|string|in:pendiente,pagada,enviada,cancelada',
            'coupon_code' => 'nullable|string|exists:coupons,code',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Debe seleccionar un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no existe.',
            'products.required' => 'Debe agregar al menos un producto.',
            'products.min' => 'Debe agregar al menos un producto.',
            'products.*.id.required' => 'ID de producto inválido.',
            'products.*.id.exists' => 'Uno de los productos no existe.',
            'products.*.quantity.required' => 'La cantidad es requerida.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
            'payment_method.required' => 'Debe seleccionar un método de pago.',
            'status.required' => 'Debe seleccionar un estado para la orden.',
        ];
    }
}
