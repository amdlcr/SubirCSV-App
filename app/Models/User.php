<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
    public function replaceRecoveryCode($code)
        {
             // 1. Desencriptamos y leemos la lista de los 8 códigos actuales de la BD
    $codigos = $this->two_factor_recovery_codes 
        ? json_decode(decrypt($this->two_factor_recovery_codes), true) 
        : [];

    // 2. Filtramos la lista eliminando únicamente el código que el usuario acaba de usar
    $codigosLimpios = array_filter($codigos, function($c) use ($code) {
        return trim($c) !== trim($code);
    });

    // 3. Volvemos a encriptar la lista ya recortada (que ahora tendrá 7, luego 6...)
    // y la guardamos de forma permanente en tu tabla MySQL
    $this->forceFill([
        'two_factor_recovery_codes' => encrypt(json_encode(array_values($codigosLimpios))),
    ])->save();
        }
}
