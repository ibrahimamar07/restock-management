<?php

namespace Tests\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait CreatesDatabaseSchema
{
    protected function refreshDatabaseSchema(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON;');
        }

        Schema::disableForeignKeyConstraints();

        foreach ([
            'payments',
            'user_payment_types',
            'payment_types',
            'invoices',
            'cart_items',
            'carts',
            'items',
            'stores',
            'users',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();

        $this->createDatabaseSchema();
    }

    protected function createDatabaseSchema(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idUser');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nickname')->nullable();
            $table->text('description')->nullable();
            $table->string('profilepic')->nullable();
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->id('idStore');
            $table->unsignedBigInteger('idUser');
            $table->string('storeName');
            $table->text('storeAddress');
            $table->text('storePic')->nullable();
            $table->timestamps();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id('idItem');
            $table->unsignedBigInteger('idStore');
            $table->string('itemName');
            $table->decimal('itemPrice', 15, 2);
            $table->timestamps();
            $table->foreign('idStore')->references('idStore')->on('stores')->onDelete('cascade');
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->id('idCart');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idStore');
            $table->timestamp('cartDate')->useCurrent();
            $table->string('status')->default('pending');
            $table->string('restockProof')->nullable();
            $table->timestamps();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            $table->foreign('idStore')->references('idStore')->on('stores')->onDelete('cascade');
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('idCartItem');
            $table->unsignedBigInteger('idCart');
            $table->unsignedBigInteger('idItem');
            $table->integer('quantity')->default(1);
            $table->decimal('subTotal', 15, 2);
            $table->timestamps();
            $table->foreign('idCart')->references('idCart')->on('carts')->onDelete('cascade');
            $table->foreign('idItem')->references('idItem')->on('items')->onDelete('cascade');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id('idInvoice');
            $table->unsignedBigInteger('idCart');
            $table->unsignedBigInteger('idRestocker');
            $table->unsignedBigInteger('idStoreOwner');
            $table->timestamp('invoiceDate')->useCurrent();
            $table->decimal('totalAmount', 15, 2);
            $table->string('status')->default('unpaid');
            $table->timestamps();
            $table->foreign('idCart')->references('idCart')->on('carts')->onDelete('cascade');
            $table->foreign('idRestocker')->references('idUser')->on('users')->onDelete('cascade');
            $table->foreign('idStoreOwner')->references('idUser')->on('users')->onDelete('cascade');
        });

        Schema::create('payment_types', function (Blueprint $table) {
            $table->id('idPaymentType');
            $table->string('paymentName');
            $table->timestamps();
        });

        Schema::create('user_payment_types', function (Blueprint $table) {
            $table->id('idUserPaymentType');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idPaymentType');
            $table->text('paymentDetails')->nullable();
            $table->timestamps();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            $table->foreign('idPaymentType')->references('idPaymentType')->on('payment_types')->onDelete('cascade');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id('idPayment');
            $table->unsignedBigInteger('idInvoice');
            $table->unsignedBigInteger('idUserPaymentType');
            $table->decimal('amount', 15, 2);
            $table->timestamp('paymentDate')->useCurrent();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->foreign('idInvoice')->references('idInvoice')->on('invoices')->onDelete('cascade');
            $table->foreign('idUserPaymentType')->references('idUserPaymentType')->on('user_payment_types')->onDelete('cascade');
        });
    }
}
