# Qase\APIClientV2\ResultsApi

All URIs are relative to https://api.qase.io/v2, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createResultV2()**](ResultsApi.md#createResultV2) | **POST** /{project_code}/run/{run_id}/result | Create test run result |
| [**createResultsV2()**](ResultsApi.md#createResultsV2) | **POST** /{project_code}/run/{run_id}/results | Bulk create test run result |


## `createResultV2()`

```php
createResultV2($projectCode, $runId, $resultCreate)
```

Create test run result

This method allows to create single test run result.  If there is no free space left in your team account, when attempting to upload an attachment, e.g., through reporters, you will receive an error with code 507 - Insufficient Storage.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV2\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV2\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV2\Api\ResultsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$projectCode = 'projectCode_example'; // string
$runId = 56; // int
$resultCreate = new \Qase\APIClientV2\Model\ResultCreate(); // \Qase\APIClientV2\Model\ResultCreate

try {
    $apiInstance->createResultV2($projectCode, $runId, $resultCreate);
} catch (Exception $e) {
    echo 'Exception when calling ResultsApi->createResultV2: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **projectCode** | **string**|  | |
| **runId** | **int**|  | |
| **resultCreate** | [**\Qase\APIClientV2\Model\ResultCreate**](../Model/ResultCreate.md)|  | |

### Return type

void (empty response body)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createResultsV2()`

```php
createResultsV2($projectCode, $runId, $createResultsRequestV2)
```

Bulk create test run result

This method allows to create several test run results at once.  If there is no free space left in your team account, when attempting to upload an attachment, e.g., through reporters, you will receive an error with code 507 - Insufficient Storage.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV2\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV2\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV2\Api\ResultsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$projectCode = 'projectCode_example'; // string
$runId = 56; // int
$createResultsRequestV2 = new \Qase\APIClientV2\Model\CreateResultsRequestV2(); // \Qase\APIClientV2\Model\CreateResultsRequestV2

try {
    $apiInstance->createResultsV2($projectCode, $runId, $createResultsRequestV2);
} catch (Exception $e) {
    echo 'Exception when calling ResultsApi->createResultsV2: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **projectCode** | **string**|  | |
| **runId** | **int**|  | |
| **createResultsRequestV2** | [**\Qase\APIClientV2\Model\CreateResultsRequestV2**](../Model/CreateResultsRequestV2.md)|  | |

### Return type

void (empty response body)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
