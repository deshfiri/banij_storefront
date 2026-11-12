<?php

use Tests\Support\FakeErp;

/**
 * @return array{data: list<array{id: string, type: string, name: array{en: string, bn: string}, has_children: bool}>}
 */
function storefrontAreaBody(string $id, string $type): array
{
    return ['data' => [['id' => $id, 'type' => $type, 'name' => ['en' => 'Dhaka', 'bn' => 'ঢাকা'], 'has_children' => true]]];
}

it('hands the ERP a division id, whose parent is written as a dash, to list its districts', function () {
    $erp = FakeErp::shop()
        ->on('GET /delivery/areas', fn () => [200, storefrontAreaBody('district:3:26', 'district')]);

    $this->getJson('/api/areas?parent='.urlencode('division:-:3'))
        ->assertOk()
        ->assertJsonPath('data.0.id', 'district:3:26');

    expect($erp->calls('GET', '/delivery/areas')[0]['query'])->toContain('parent=division%3A-%3A3');
});

it('lists the districts, upazilas and divisions, one level at a time', function (string $parent) {
    FakeErp::shop()
        ->on('GET /delivery/areas', fn () => [200, storefrontAreaBody('upazila:26:301', 'upazila')]);

    $this->getJson('/api/areas'.($parent === '' ? '' : '?parent='.urlencode($parent)))->assertOk()->assertJsonCount(1, 'data');
})->with(['', 'division:-:3', 'district:3:26']);

it('refuses a parent that is not an area id, without asking the ERP', function (string $parent) {
    $erp = FakeErp::shop();

    $this->getJson('/api/areas?parent='.urlencode($parent))->assertStatus(422)->assertJson(['data' => []]);

    expect($erp->calls('GET', '/delivery/areas'))->toBe([]);
})->with(['../etc', 'division:-', 'division:-:3:9', 'DIVISION:-:3', "district:3:26'--"]);

it('draws the checkout page with its order summary and all three area selects', function () {
    FakeErp::shop();

    $html = storefrontGet($this, '/checkout', [], [\App\Services\Basket::COOKIE => storefrontBasket()])->getContent();

    expect($html)
        ->toContain('id="area-division"')
        ->toContain('id="area-district"')
        ->toContain('id="area-upazila"')
        ->toContain('checkout-summary')
        ->toContain('Cotton Panjabi');
});
