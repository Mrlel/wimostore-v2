<?php
// app/Models/CabinePage.php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class CabinePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabine_id',
        'logo',
        'nom_site',
        'titre',
        'sous_titre',
        'description',
        'banniere',
        'telephone',
        'whatsapp',
        'email',
        'facebook',
        'instagram',
        'latitude',
        'longitude',
        'est_publiee',
    ];

    protected $casts = [
        'est_publiee' => 'boolean',
    ];

    public function cabine()
    {
        return $this->belongsTo(Cabine::class);
    }
    
    public function getBanniereUrlAttribute(): string
    {
        if (!empty($this->banniere) && Storage::disk('public')->exists($this->banniere)) {
            return Storage::disk('public')->url($this->banniere);
        }
        return asset('flyers.jpg'); // fallback
    }
}
