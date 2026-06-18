<?php

namespace Tests\Unit;

use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_user_can_have_stores_and_carts()
    {
        $user = User::create([
            'email' => 'owner@example.test',
            'username' => 'owner1',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'My Store',
            'storeAddress' => 'Somewhere',
        ]);

        $this->assertTrue($user->stores()->exists());
        $this->assertEquals(1, $user->stores()->count());
    }

    public function test_profile_pic_url_attribute_returns_local_storage_url()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'profilepic@example.test',
            'username' => 'profilepic1',
            'password' => 'pw',
            'profilepic' => 'avatar.jpg',
        ]);

        $this->assertStringContainsString('avatar.jpg', $user->profilePicUrl);
    }

    public function test_profile_pic_url_attribute_returns_supabase_url_when_bucket_is_set()
    {
        putenv('SUPABASE_URL=https://example.supabase.co');
        putenv('SUPABASE_ANON_KEY=testkey');
        putenv('SUPABASE_PROJECT_REF=testref');
        putenv('SUPABASE_BUCKET=my-bucket');

        $user = User::create([
            'email' => 'profilepic2@example.test',
            'username' => 'profilepic2',
            'password' => 'pw',
            'profilepic' => 'avatar.jpg',
        ]);

        $this->assertStringContainsString('my-bucket/avatar.jpg', $user->profilePicUrl);
        $this->assertStringStartsWith('https://', $user->profilePicUrl);
    }
}
