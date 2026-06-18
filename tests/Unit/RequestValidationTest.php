<?php

namespace Tests\Unit;

use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Requests\Store\UpdateRequest;
use Tests\TestCase;

class RequestValidationTest extends TestCase
{
    public function test_item_store_request_rules_and_messages()
    {
        $request = new ItemStoreRequest();

        $rules = $request->rules();
        $this->assertArrayHasKey('itemName', $rules);
        $this->assertStringContainsString('required', $rules['itemName']);
        $this->assertArrayHasKey('itemPrice', $rules);
        $this->assertStringContainsString('integer', $rules['itemPrice']);
    }

    public function test_item_update_request_rules_and_messages()
    {
        $request = new ItemUpdateRequest();

        $rules = $request->rules();
        $this->assertSame('required|string|max:255', $rules['itemName']);
        $this->assertStringContainsString('numeric', $rules['itemPrice']);
    }

    public function test_store_request_requires_store_pic()
    {
        $request = new StoreRequest();

        $rules = $request->rules();
        $this->assertStringContainsString('required', $rules['storePic']);
        $this->assertStringContainsString('image', $rules['storePic']);
    }

    public function test_store_update_request_allows_optional_store_pic()
    {
        $request = new UpdateRequest();

        $rules = $request->rules();
        $this->assertStringContainsString('nullable', $rules['storePic']);
        $this->assertStringContainsString('image', $rules['storePic']);
    }
}
