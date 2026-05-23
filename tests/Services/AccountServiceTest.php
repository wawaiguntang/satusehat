<?php

namespace Wawaiguntang\Satusehat\Tests\Services;

use Wawaiguntang\Satusehat\Responses\Resources\AccountResponse;
use Wawaiguntang\Satusehat\Services\AccountService;
use Wawaiguntang\Satusehat\Tests\Support\ServiceTestCase;

class AccountServiceTest extends ServiceTestCase
{
    private function makeService(): AccountService
    {
        return new AccountService($this->client);
    }

    public function test_create_sends_post(): void
    {
        $this->respondResource('Account', 'acc-001');
        $dto = $this->createMock(\Wawaiguntang\Satusehat\DTOs\Account\AccountDTO::class);
        $dto->method('toArray')->willReturn(['resourceType' => 'Account']);

        $response = $this->makeService()->create($dto);
        $this->assertInstanceOf(AccountResponse::class, $response);
        $this->assertSame('POST', $this->lastMethod());
    }

    public function test_get_by_id(): void
    {
        $this->respondResource('Account', 'acc-001');
        $response = $this->makeService()->getById('acc-001');
        $this->assertSame('acc-001', $response->id);
    }

    public function test_search_by_patient(): void
    {
        $this->respondBundle('Account');
        $this->makeService()->searchByPatient('P001');
        $this->assertStringContainsString('subject=P001', $this->lastUri());
    }

    public function test_patch_sends_patch(): void
    {
        $this->respondResource('Account', 'acc-001');
        $this->makeService()->patch('acc-001', [['op' => 'add', 'path' => '/coverage/-', 'value' => ['coverage' => ['reference' => 'Coverage/cov-002']]]]);
        $this->assertSame('PATCH', $this->lastMethod());
        $this->assertStringContainsString('/Account/acc-001', $this->lastUri());
    }
}
