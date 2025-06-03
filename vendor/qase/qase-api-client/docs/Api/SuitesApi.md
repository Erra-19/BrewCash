# Qase\APIClientV1\SuitesApi

All URIs are relative to https://api.qase.io/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createSuite()**](SuitesApi.md#createSuite) | **POST** /suite/{code} | Create a new test suite |
| [**deleteSuite()**](SuitesApi.md#deleteSuite) | **DELETE** /suite/{code}/{id} | Delete test suite |
| [**getSuite()**](SuitesApi.md#getSuite) | **GET** /suite/{code}/{id} | Get a specific test suite |
| [**getSuites()**](SuitesApi.md#getSuites) | **GET** /suite/{code} | Get all test suites |
| [**updateSuite()**](SuitesApi.md#updateSuite) | **PATCH** /suite/{code}/{id} | Update test suite |


## `createSuite()`

```php
createSuite($code, $suiteCreate): \Qase\APIClientV1\Model\IdResponse
```

Create a new test suite

This method is used to create a new test suite through API.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SuitesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$suiteCreate = new \Qase\APIClientV1\Model\SuiteCreate(); // \Qase\APIClientV1\Model\SuiteCreate

try {
    $result = $apiInstance->createSuite($code, $suiteCreate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuitesApi->createSuite: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **suiteCreate** | [**\Qase\APIClientV1\Model\SuiteCreate**](../Model/SuiteCreate.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\IdResponse**](../Model/IdResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteSuite()`

```php
deleteSuite($code, $id, $suiteDelete): \Qase\APIClientV1\Model\IdResponse
```

Delete test suite

This method completely deletes a test suite with test cases from repository.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SuitesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.
$suiteDelete = new \Qase\APIClientV1\Model\SuiteDelete(); // \Qase\APIClientV1\Model\SuiteDelete

try {
    $result = $apiInstance->deleteSuite($code, $id, $suiteDelete);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuitesApi->deleteSuite: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |
| **suiteDelete** | [**\Qase\APIClientV1\Model\SuiteDelete**](../Model/SuiteDelete.md)|  | [optional] |

### Return type

[**\Qase\APIClientV1\Model\IdResponse**](../Model/IdResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSuite()`

```php
getSuite($code, $id): \Qase\APIClientV1\Model\SuiteResponse
```

Get a specific test suite

This method allows to retrieve a specific test suite.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SuitesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.

try {
    $result = $apiInstance->getSuite($code, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuitesApi->getSuite: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |

### Return type

[**\Qase\APIClientV1\Model\SuiteResponse**](../Model/SuiteResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSuites()`

```php
getSuites($code, $search, $limit, $offset): \Qase\APIClientV1\Model\SuiteListResponse
```

Get all test suites

This method allows to retrieve all test suites stored in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SuitesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$search = 'search_example'; // string | Provide a string that will be used to search by name.
$limit = 10; // int | A number of entities in result set.
$offset = 0; // int | How many entities should be skipped.

try {
    $result = $apiInstance->getSuites($code, $search, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuitesApi->getSuites: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **search** | **string**| Provide a string that will be used to search by name. | [optional] |
| **limit** | **int**| A number of entities in result set. | [optional] [default to 10] |
| **offset** | **int**| How many entities should be skipped. | [optional] [default to 0] |

### Return type

[**\Qase\APIClientV1\Model\SuiteListResponse**](../Model/SuiteListResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateSuite()`

```php
updateSuite($code, $id, $suiteUpdate): \Qase\APIClientV1\Model\IdResponse
```

Update test suite

This method is used to update a test suite through API.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SuitesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.
$suiteUpdate = new \Qase\APIClientV1\Model\SuiteUpdate(); // \Qase\APIClientV1\Model\SuiteUpdate

try {
    $result = $apiInstance->updateSuite($code, $id, $suiteUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuitesApi->updateSuite: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |
| **suiteUpdate** | [**\Qase\APIClientV1\Model\SuiteUpdate**](../Model/SuiteUpdate.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\IdResponse**](../Model/IdResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
