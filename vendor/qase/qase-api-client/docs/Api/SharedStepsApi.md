# Qase\APIClientV1\SharedStepsApi

All URIs are relative to https://api.qase.io/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createSharedStep()**](SharedStepsApi.md#createSharedStep) | **POST** /shared_step/{code} | Create a new shared step |
| [**deleteSharedStep()**](SharedStepsApi.md#deleteSharedStep) | **DELETE** /shared_step/{code}/{hash} | Delete shared step |
| [**getSharedStep()**](SharedStepsApi.md#getSharedStep) | **GET** /shared_step/{code}/{hash} | Get a specific shared step |
| [**getSharedSteps()**](SharedStepsApi.md#getSharedSteps) | **GET** /shared_step/{code} | Get all shared steps |
| [**updateSharedStep()**](SharedStepsApi.md#updateSharedStep) | **PATCH** /shared_step/{code}/{hash} | Update shared step |


## `createSharedStep()`

```php
createSharedStep($code, $sharedStepCreate): \Qase\APIClientV1\Model\HashResponse
```

Create a new shared step

This method allows to create a shared step in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SharedStepsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$sharedStepCreate = new \Qase\APIClientV1\Model\SharedStepCreate(); // \Qase\APIClientV1\Model\SharedStepCreate

try {
    $result = $apiInstance->createSharedStep($code, $sharedStepCreate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SharedStepsApi->createSharedStep: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **sharedStepCreate** | [**\Qase\APIClientV1\Model\SharedStepCreate**](../Model/SharedStepCreate.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\HashResponse**](../Model/HashResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteSharedStep()`

```php
deleteSharedStep($code, $hash): \Qase\APIClientV1\Model\HashResponse
```

Delete shared step

This method completely deletes a shared step from repository.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SharedStepsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$hash = 'hash_example'; // string | Hash.

try {
    $result = $apiInstance->deleteSharedStep($code, $hash);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SharedStepsApi->deleteSharedStep: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **hash** | **string**| Hash. | |

### Return type

[**\Qase\APIClientV1\Model\HashResponse**](../Model/HashResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSharedStep()`

```php
getSharedStep($code, $hash): \Qase\APIClientV1\Model\SharedStepResponse
```

Get a specific shared step

This method allows to retrieve a specific shared step.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SharedStepsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$hash = 'hash_example'; // string | Hash.

try {
    $result = $apiInstance->getSharedStep($code, $hash);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SharedStepsApi->getSharedStep: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **hash** | **string**| Hash. | |

### Return type

[**\Qase\APIClientV1\Model\SharedStepResponse**](../Model/SharedStepResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSharedSteps()`

```php
getSharedSteps($code, $search, $limit, $offset): \Qase\APIClientV1\Model\SharedStepListResponse
```

Get all shared steps

This method allows to retrieve all shared steps stored in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SharedStepsApi(
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
    $result = $apiInstance->getSharedSteps($code, $search, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SharedStepsApi->getSharedSteps: ', $e->getMessage(), PHP_EOL;
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

[**\Qase\APIClientV1\Model\SharedStepListResponse**](../Model/SharedStepListResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateSharedStep()`

```php
updateSharedStep($code, $hash, $sharedStepUpdate): \Qase\APIClientV1\Model\HashResponse
```

Update shared step

This method updates a shared step.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\SharedStepsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$hash = 'hash_example'; // string | Hash.
$sharedStepUpdate = new \Qase\APIClientV1\Model\SharedStepUpdate(); // \Qase\APIClientV1\Model\SharedStepUpdate

try {
    $result = $apiInstance->updateSharedStep($code, $hash, $sharedStepUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SharedStepsApi->updateSharedStep: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **hash** | **string**| Hash. | |
| **sharedStepUpdate** | [**\Qase\APIClientV1\Model\SharedStepUpdate**](../Model/SharedStepUpdate.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\HashResponse**](../Model/HashResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
