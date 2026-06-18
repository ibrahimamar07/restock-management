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

    public function test_supabase_service_public_url_and_client_wrappers_return_values()
    {
        putenv('SUPABASE_URL=https://example.supabase.co');
        putenv('SUPABASE_ANON_KEY=testkey');
        putenv('SUPABASE_PROJECT_REF=testref');
        putenv('SUPABASE_SERVICE_KEY=testservicekey');

        $service = new SupabaseService();

        $publicUrl = $service->getPublicUrl('my-bucket', 'images/example.jpg');

        $this->assertStringContainsString('/storage/v1/object/public/my-bucket/images/example.jpg', $publicUrl);
        $this->assertNotNull($service->auth());
        $this->assertNotNull($service->from('items'));
        $this->assertNotNull($service->rpc('my_function', ['hello' => 'world']));
    }
}
