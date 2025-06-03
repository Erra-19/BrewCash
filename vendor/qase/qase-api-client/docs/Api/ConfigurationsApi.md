# Qase\APIClientV1\ConfigurationsApi

All URIs are relative to https://api.qase.io/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createConfiguration()**](ConfigurationsApi.md#createConfiguration) | **POST** /configuration/{code} | Create a new configuration in a particular group. |
| [**createConfigurationGroup()**](ConfigurationsApi.md#createConfigurationGroup) | **POST** /configuration/{code}/group | Create a new configuration group. |
| [**getConfigurations()**](ConfigurationsApi.md#getConfigurations) | **GET** /configuration/{code} | Get all configuration groups with configurations. |


## `createConfiguration()`

```php
createConfiguration($code, $configurationCreate): \Qase\APIClientV1\Model\IdResponse
```

Create a new configuration in a particular group.

This method allows to create a configuration in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\ConfigurationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$configurationCreate = new \Qase\APIClientV1\Model\ConfigurationCreate(); // \Qase\APIClientV1\Model\ConfigurationCreate

try {
    $result = $apiInstance->createConfiguration($code, $configurationCreate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ConfigurationsApi->createConfiguration: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **configurationCreate** | [**\Qase\APIClientV1\Model\ConfigurationCreate**](../Model/ConfigurationCreate.md)|  | |

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

## `createConfigurationGroup()`

```php
createConfigurationGroup($code, $configurationGroupCreate): \Qase\APIClientV1\Model\IdResponse
```

Create a new configuration group.

This method allows to create a configuration group in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\ConfigurationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$configurationGroupCreate = new \Qase\APIClientV1\Model\ConfigurationGroupCreate(); // \Qase\APIClientV1\Model\ConfigurationGroupCreate

try {
    $result = $apiInstance->createConfigurationGroup($code, $configurationGroupCreate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ConfigurationsApi->createConfigurationGroup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **configurationGroupCreate** | [**\Qase\APIClientV1\Model\ConfigurationGroupCreate**](../Model/ConfigurationGroupCreate.md)|  | |

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

## `getConfigurations()`

```php
getConfigurations($code): \Qase\APIClientV1\Model\ConfigurationListResponse
```

Get all configuration groups with configurations.

This method allows to retrieve all configurations groups with configurations

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\ConfigurationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.

try {
    $result = $apiInstance->getConfigurations($code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ConfigurationsApi->getConfigurations: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |

### Return type

[**\Qase\APIClientV1\Model\ConfigurationListResponse**](../Model/ConfigurationListResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
