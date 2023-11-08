<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Frolyak\FrolyakIvanWpPlugin\Service\APIService;
use Frolyak\FrolyakIvanWpPlugin\Cache\CacheHandler;

class APIServiceTest extends TestCase
{
    private $cacheHandlerMock;

    private $apiService;
    private $apiReflection;

    protected function setUp(): void
    {
        $this->cacheHandlerMock = $this->createMock(CacheHandler::class);
        $this->apiService = new APIService($this->cacheHandlerMock);

        $this->apiReflection = new ReflectionClass(APIService::class);
    }

    public function testConstructor() : void
    {

        // Check API_URL property
        $apiUrlProperty = $this->apiReflection->getProperty('API_URL');
        $apiUrlProperty->setAccessible(true);
        $apiUrl = $apiUrlProperty->getValue($this->apiService);

        $this->assertEquals("https://jsonplaceholder.typicode.com", $apiUrl);

        // Check instance of CacheHandler
        $cacheHandlerProperty = $this->apiReflection->getProperty('cacheHandler');
        $cacheHandlerProperty->setAccessible(true);
        $cacheHandler = $cacheHandlerProperty->getValue($this->apiService);
        $this->assertSame($this->cacheHandlerMock, $cacheHandler);
    }

    public function testGenerateCacheKey() : void
    {
        $url = 'https://example.com/api/data';
        $expectedCacheKey = md5($url);

        $cacheKeyMethod = $this->apiReflection->getMethod('generateCacheKey');
        $cacheKeyMethod->setAccessible(true);

        $actualCacheKey = $cacheKeyMethod->invokeArgs(null, [$url]);

        $this->assertEquals($expectedCacheKey, $actualCacheKey);
    }

    public function testGetApiDataWithInvalidJsonFromCache()
    {
        $invalidJson = '{"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz"';
        $this->cacheHandlerMock->method('get')->willReturn($invalidJson);

        $result = $this->apiService->getApiData('/users');

        $this->assertArrayHasKey('error', $result);
    }

    public function testGetApiDataWithSuccessfulApiFetch()
    {
        $this->cacheHandlerMock->method('get')->willReturn(false);
        $apiResponse = '{"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz"}';

        WP_Mock::userFunction('wp_remote_get')
            ->once()
            ->andReturn(['body' => $apiResponse]);

        WP_Mock::userFunction('is_wp_error')
            ->once()
            ->andReturn(false);

        WP_Mock::userFunction('wp_remote_retrieve_body')
            ->once()
            ->andReturn($apiResponse);

        $result = $this->apiService->getApiData('/users');
        $this->assertIsArray($result);
    }
}
