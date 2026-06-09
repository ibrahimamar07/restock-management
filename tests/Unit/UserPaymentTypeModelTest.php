<?php

// namespace Tests\Unit;

// use Tests\TestCase;
// use App\Models\UserPaymentType;
// use Illuminate\Database\Eloquent\Relations\Relation;

// class UserPaymentTypeModelTest extends TestCase
// {
//     public function testUserPaymentTypeHasCorrectTableAndPrimaryKey(): void
//     {
//         $model = new UserPaymentType();

//         $this->assertEquals('user_payment_types', $model->getTable());
//         $this->assertEquals('idUserPaymentType', $model->getKeyName());
//     }

//     public function testUserPaymentTypeHasExpectedFillableAttributes(): void
//     {
//         $model = new UserPaymentType();
//         $fillable = $model->getFillable();

//         $this->assertContains('idUser', $fillable);
//         $this->assertContains('idPaymentType', $fillable);
//         $this->assertContains('paymentDetails', $fillable);
//     }

//     public function testUserPaymentTypeRelationshipsReturnRelationInstances(): void
//     {
//         $model = new UserPaymentType();

//         $this->assertInstanceOf(Relation::class, $model->user());
//         $this->assertInstanceOf(Relation::class, $model->paymentType());
//         $this->assertInstanceOf(Relation::class, $model->payments());
//     }
// }
