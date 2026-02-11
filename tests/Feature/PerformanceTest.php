<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class PerformanceTest extends TestCase
{
    /**
     * Test Homepage Response Time
     */
    public function test_homepage_response_time()
    {
        $start = microtime(true);
        $response = $this->get('/');
        $end = microtime(true);
        
        $duration = $end - $start;
        
        $response->assertStatus(200);
        $this->assertLessThan(3.0, $duration, 'Homepage response time is too slow (> 3s)');
    }

    /**
     * Test Cache Integrity
     */
    public function test_cache_functionality()
    {
        $cache = new \App\Core\Services\CacheManager();
        $cache->put('perf_test_key', 'perf_test_value', 60);
        
        $this->assertEquals('perf_test_value', cache('perf_test_key'));
    }
}
