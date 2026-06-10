<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;

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
}
