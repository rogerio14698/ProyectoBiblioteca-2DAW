<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Método de pago guardado en Stripe. Solo almacena la referencia pm_... y datos visibles.
 */
class MetodosPago extends Model
{
    protected $table = 'metodos_pago';

    protected $fillable = [
        'usuario_id',
        'stripe_payment_method_id',
        'tipo',
        'marca',
        'last_four',
        'exp_mes',
        'exp_anio',
        'predeterminado',
    ];

    protected $casts = [
        'predeterminado' => 'boolean',
        'exp_mes' => 'integer',
        'exp_anio' => 'integer',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function getEtiquetaAttribute(): string
    {
        $marca = $this->marca ? ucfirst($this->marca) : 'Tarjeta';

        return trim($marca . ' ···· ' . $this->last_four);
    }

    public function getCaducidadAttribute(): ?string
    {
        if (! $this->exp_mes || ! $this->exp_anio) {
            return null;
        }

        return sprintf('%02d/%02d', $this->exp_mes, $this->exp_anio % 100);
    }
}