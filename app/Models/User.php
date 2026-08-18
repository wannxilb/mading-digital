<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nis',
        'jurusan',
        'email',
        'password',
        'role',
        'class',
        'is_active',
    ];

    public const JURUSAN = [
        'mplb' => 'Manajemen Perkantoran',
        'rpl' => 'Rekayasa Perangkat Lunak',
        'akl' => 'Akuntansi',
        'bd' => 'Bisnis Digital',
        'dkv' => 'Desain Komunikasi Visual',
        'pf' => 'Perfilman',
        'dpb' => 'Desain dan Produksi Busana',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin / Guru Pembina',
            default => 'Siswa',
        };
    }

    public function getJurusanLabelAttribute(): ?string
    {
        return self::JURUSAN[$this->jurusan] ?? $this->jurusan;
    }

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
            'is_active' => 'boolean',
        ];
    }
}
