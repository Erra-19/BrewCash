# Qase\APIClientV1\MilestonesApi

All URIs are relative to https://api.qase.io/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createMilestone()**](MilestonesApi.md#createMilestone) | **POST** /milestone/{code} | Create a new milestone |
| [**deleteMilestone()**](MilestonesApi.md#deleteMilestone) | **DELETE** /milestone/{code}/{id} | Delete milestone |
| [**getMilestone()**](MilestonesApi.md#getMilestone) | **GET** /milestone/{code}/{id} | Get a specific milestone |
| [**getMilestones()**](MilestonesApi.md#getMilestones) | **GET** /milestone/{code} | Get all milestones |
| [**updateMilestone()**](MilestonesApi.md#updateMilestone) | **PATCH** /milestone/{code}/{id} | Update milestone |


## `createMilestone()`

```php
createMilestone($code, $milestoneCreate): \Qase\APIClientV1\Model\IdResponse
```

Create a new milestone

This method allows to create a milestone in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\MilestonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$milestoneCreate = new \Qase\APIClientV1\Model\MilestoneCreate(); // \Qase\APIClientV1\Model\MilestoneCreate

try {
    $result = $apiInstance->createMilestone($code, $milestoneCreate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MilestonesApi->createMilestone: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **milestoneCreate** | [**\Qase\APIClientV1\Model\MilestoneCreate**](../Model/MilestoneCreate.md)|  | |

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

## `deleteMilestone()`

```php
deleteMilestone($code, $id): \Qase\APIClientV1\Model\IdResponse
```

Delete milestone

This method completely deletes a milestone from repository.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\MilestonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.

try {
    $result = $apiInstance->deleteMilestone($code, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MilestonesApi->deleteMilestone: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |

### Return type

[**\Qase\APIClientV1\Model\IdResponse**](../Model/IdResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMilestone()`

```php
getMilestone($code, $id): \Qase\APIClientV1\Model\MilestoneResponse
```

Get a specific milestone

This method allows to retrieve a specific milestone.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\MilestonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.

try {
    $result = $apiInstance->getMilestone($code, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MilestonesApi->getMilestone: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |

### Return type

[**\Qase\APIClientV1\Model\MilestoneResponse**](../Model/MilestoneResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMilestones()`

```php
getMilestones($code, $search, $limit, $offset): \Qase\APIClientV1\Model\MilestoneListResponse
```

Get all milestones

This method allows to retrieve all milestones stored in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\MilestonesApi(
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
    $result = $apiInstance->getMilestones($code, $search, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MilestonesApi->getMilestones: ', $e->getMessage(), PHP_EOL;
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

[**\Qase\APIClientV1\Model\MilestoneListResponse**](../Model/MilestoneListResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateMilestone()`

```php
updateMilestone($code, $id, $milestoneUpdate): \Qase\APIClientV1\Model\IdResponse
```

Update milestone

This method updates a milestone.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\MilestonesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.
$milestoneUpdate = new \Qase\APIClientV1\Model\MilestoneUpdate(); // \Qase\APIClientV1\Model\MilestoneUpdate

try {
    $result = $apiInstance->updateMilestone($code, $id, $milestoneUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MilestonesApi->updateMilestone: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |
| **milestoneUpdate** | [**\Qase\APIClientV1\Model\MilestoneUpdate**](../Model/MilestoneUpdate.md)|  | |

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
