<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Policies\StorePolicy;

class StorePolicyTest extends TestCase
{
    public function test_manage_allows_owner_and_denies_others()
    {
        $owner = User::create([
            'email' => 'policy_owner@example.test',
            'username' => 'policy_owner',
            'password' => 'pw',
        ]);

        $other = User::create([
            'email' => 'policy_other@example.test',
            'username' => 'policy_other',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'Policy Store',
            'storeAddress' => 'Addr',
        ]);

        $policy = new StorePolicy();

        $this->assertTrue($policy->manage($owner, $store));
        $this->assertFalse($policy->manage($other, $store));
    }
}
