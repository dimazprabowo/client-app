<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

/**
 * Membuat route-model-binding memakai ID terenkripsi.
 *
 * Tujuan: ID pada URL tidak bisa ditebak/di-enumerate (mis. /modules/5/edit),
 * melainkan berupa ciphertext (mis. /modules/eyJpdiI6...). Mencegah IDOR &
 * kebocoran informasi jumlah/ur-utan data.
 *
 * Cara pakai pada Model:
 *   use App\Traits\HasEncryptedRouteKey;
 *   class Module extends Model { use HasEncryptedRouteKey; }
 *
 * Route tetap ditulis normal:
 *   Route::get('/{module}/edit', fn (Module $module) => view(...));
 *
 * CATATAN KEAMANAN: enkripsi ID BUKAN pengganti otorisasi. Tetap WAJIB
 * $this->authorize(...) / Policy pada model yang sudah ter-resolve.
 */
trait HasEncryptedRouteKey
{
    /**
     * Nilai key yang dipakai saat generate URL (route(), links).
     */
    public function getRouteKey(): string
    {
        return Crypt::encryptString((string) $this->getAttribute($this->getRouteKeyName()));
    }

    /**
     * Resolve model dari ciphertext pada URL. Gagal decrypt -> 404.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $decrypted = Crypt::decryptString($value);
        } catch (\Throwable $e) {
            abort(404);
        }

        return $this->where($field ?? $this->getRouteKeyName(), $decrypted)->firstOrFail();
    }

    /**
     * Dukungan binding untuk relasi child (mis. nested route).
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return parent::resolveChildRouteBinding($childType, $value, $field);
    }
}
