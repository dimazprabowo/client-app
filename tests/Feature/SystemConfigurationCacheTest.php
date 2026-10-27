<?php

namespace Tests\Feature;

use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SystemConfigurationCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'cache.stores.array.serialize' => true,
            'cache.serializable_classes' => false,
        ]);
        Cache::forgetDriver('array');
    }

    public function test_nilai_datetime_tetap_carbon_saat_dibaca_dari_cache(): void
    {
        SystemConfiguration::set('registration.deadline', '2030-01-31 10:00:00', 'general', 'datetime');

        $first = SystemConfiguration::get('registration.deadline');
        $cached = SystemConfiguration::get('registration.deadline');

        $this->assertInstanceOf(Carbon::class, $first);
        $this->assertInstanceOf(Carbon::class, $cached);
        $this->assertSame('2030-01-31 10:00:00', $cached->format('Y-m-d H:i:s'));
    }

    public function test_tipe_skalar_dan_json_ter_cast_konsisten_dari_cache(): void
    {
        SystemConfiguration::set('app.max_items', 25);
        SystemConfiguration::set('app.feature_on', true);
        SystemConfiguration::set('app.options', ['a' => 1]);

        foreach (range(1, 2) as $_) {
            $this->assertSame(25, SystemConfiguration::get('app.max_items'));
            $this->assertTrue(SystemConfiguration::get('app.feature_on'));
            $this->assertSame(['a' => 1], SystemConfiguration::get('app.options'));
        }
    }

    public function test_default_milik_pemanggil_dipakai_untuk_key_tidak_ada(): void
    {
        $this->assertSame('pertama', SystemConfiguration::get('tidak.ada', 'pertama'));
        $this->assertSame('kedua', SystemConfiguration::get('tidak.ada', 'kedua'));
    }

    public function test_cache_dibersihkan_saat_nilai_diubah(): void
    {
        SystemConfiguration::set('app.name', 'Lama');
        $this->assertSame('Lama', SystemConfiguration::get('app.name'));

        SystemConfiguration::set('app.name', 'Baru');
        $this->assertSame('Baru', SystemConfiguration::get('app.name'));
    }
}
