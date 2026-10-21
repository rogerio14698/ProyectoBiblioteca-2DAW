<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Cobro realizado mediante Stripe Checkout.
 *
 * @property int $importe Importe en céntimos.
 */
class Pago extends Model
{
    public const CONCEPTOS = [
        'compra_libro' => 'Compra de libro',
        'entrada_evento' => 'Entrada de evento',
        'multa' => 'Multa por retraso',
        'cuota_socio' => 'Cuota de socio',
    ];

    protected $table = 'pagos';

    protected $fillable = [
        'usuario_id',
        'concepto',
        'pagable_type',
        'pagable_id',
        'descripcion',
        'importe',
        'moneda',
        'estado',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'pagado_at',
    ];

    protected $casts = [
        'importe' => 'integer',
        'pagado_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function pagable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getImporteEurosAttribute(): string
    {
        return number_format($this->importe / 100, 2, ',', '.') . ' €';
    }

    public function getConceptoTextoAttribute(): string
    {
        return self::CONCEPTOS[$this->concepto] ?? $this->concepto;
    }
}