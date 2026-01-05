<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        'admin_id',
        'parent_admin_id',
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
            'password'          => 'hashed',
        ];
    }

    // Relationships
    public function guestUsers()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relasi untuk parent admin (admin yang membuat admin ini)
    public function parentAdmin()
    {
        return $this->belongsTo(User::class, 'parent_admin_id');
    }

    // Relasi untuk child admins (admin yang dibuat oleh admin ini)
    public function childAdmins()
    {
        return $this->hasMany(User::class, 'parent_admin_id');
    }

    public function persil()
    {
        return $this->hasMany(Persil::class, 'pemilik_warga_id');
    }
}
