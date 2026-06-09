<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class UserModelTest extends TestCase
{
    public function testUserModelHasCorrectTableAndPrimaryKey(): void
    {
        $user = new User();

        $this->assertEquals('users', $user->getTable());
        $this->assertEquals('idUser', $user->getKeyName());
    }

    public function testUserHasExpectedFillableAttributes(): void
    {
        $user = new User();
        $fillable = $user->getFillable();

        $this->assertContains('email', $fillable);
        $this->assertContains('username', $fillable);
        $this->assertContains('password', $fillable);
        $this->assertContains('nickname', $fillable);
        $this->assertContains('profilepic', $fillable);
    }

    public function testUserRelationshipsReturnRelationInstances(): void
    {
        $user = new User();

        $this->assertInstanceOf(Relation::class, $user->stores());
        $this->assertInstanceOf(Relation::class, $user->carts());
        $this->assertInstanceOf(Relation::class, $user->userPaymentTypes());
        $this->assertInstanceOf(Relation::class, $user->restockerInvoices());
        $this->assertInstanceOf(Relation::class, $user->storeOwnerInvoices());
    }
}

