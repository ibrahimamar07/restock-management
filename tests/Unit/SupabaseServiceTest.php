<?php

namespace Tests\Unit;

use App\Services\SupabaseService;
use Tests\TestCase;

class SupabaseServiceTest extends TestCase
{
    public function test_supabase_service_constructs_client_without_error()
    {
        putenv('SUPABASE_URL=https://example.supabase.co');
        putenv('SUPABASE_ANON_KEY=testkey');
        putenv('SUPABASE_PROJECT_REF=testref');

        $service = new SupabaseService();

        $this->assertInstanceOf(SupabaseService::class, $service);
    }
}
