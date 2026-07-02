<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model    
{
    use HasFactory;
 
    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'buku';
 
    /**
     * Kolom yang dapat diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'harga',
        'stok',
        'deskripsi',
        'bahasa',
    ];
 
    /**
     * Tipe casting untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];
 
    /**
     * Accessor untuk format harga.
     */
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
 
    /**
     * Accessor untuk status ketersediaan.
     */
    public function getTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }
 
    /**
     * Scope untuk filter buku tersedia.
     */
    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }
 
    /**
     * Scope untuk filter berdasarkan kategori.
     */
    public function scopeKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Accessor untuk status_stok_badge
     */
    public function getStatusStokBadgeAttribute(): string
    {
        $stok = $this->stok;

        if ($stok == 0) {
            return '<span class="badge bg-danger">Habis</span>';
        } elseif ($stok >= 1 && $stok <= 5) {
            return '<span class="badge bg-warning">Menipis</span>';
        } elseif ($stok >= 6 && $stok <= 15) {
            return '<span class="badge bg-info">Sedang</span>';
        } else {
            return '<span class="badge bg-success">Aman</span>';
        }
    }

    /**
     * Accessor untuk tahun_label
     */
    public function getTahunLabelAttribute(): string
    {
        // Asumsi nama kolom di database adalah 'tahun_terbit' atau 'tahun'
        $tahun = $this->tahun_terbit; 

        return $tahun >= 2024 ? 'Buku Baru' : 'Buku Lama';
    }

    /**
     * Scope stokMenipis
     */
    public function scopeStokMenipis(Builder $query): Builder
    {
        return $query->whereBetween('stok', [0, 5]);
    }

    /**
     * Scope hargaRange
     */
    public function scopeHargaRange(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('harga', [$min, $max]);
    } 

    /**
     * Scope memfilter buku dengan tahun_terbit >= 2024.
     */
    public function scopeTerbaru(Builder $query): Builder
    {
        return $query->where('tahun_terbit', '>=', 2024);   
    }

    public function transaksis()
    {
        // Sesuaikan 'Transaksi' dengan nama model transaksi Anda yang sebenarnya
        return $this->hasMany(Transaksi::class); 
    }
}