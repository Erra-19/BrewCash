# Qase\APIClientV1\CasesApi

All URIs are relative to https://api.qase.io/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**bulk()**](CasesApi.md#bulk) | **POST** /case/{code}/bulk | Create test cases in bulk |
| [**caseAttachExternalIssue()**](CasesApi.md#caseAttachExternalIssue) | **POST** /case/{code}/external-issue/attach | Attach the external issues to the test cases |
| [**caseDetachExternalIssue()**](CasesApi.md#caseDetachExternalIssue) | **POST** /case/{code}/external-issue/detach | Detach the external issues from the test cases |
| [**createCase()**](CasesApi.md#createCase) | **POST** /case/{code} | Create a new test case |
| [**deleteCase()**](CasesApi.md#deleteCase) | **DELETE** /case/{code}/{id} | Delete test case |
| [**getCase()**](CasesApi.md#getCase) | **GET** /case/{code}/{id} | Get a specific test case |
| [**getCases()**](CasesApi.md#getCases) | **GET** /case/{code} | Get all test cases |
| [**updateCase()**](CasesApi.md#updateCase) | **PATCH** /case/{code}/{id} | Update test case |


## `bulk()`

```php
bulk($code, $testCasebulk): \Qase\APIClientV1\Model\Bulk200Response
```

Create test cases in bulk

This method allows to bulk create new test cases in a project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$testCasebulk = new \Qase\APIClientV1\Model\TestCasebulk(); // \Qase\APIClientV1\Model\TestCasebulk

try {
    $result = $apiInstance->bulk($code, $testCasebulk);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->bulk: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **testCasebulk** | [**\Qase\APIClientV1\Model\TestCasebulk**](../Model/TestCasebulk.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\Bulk200Response**](../Model/Bulk200Response.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `caseAttachExternalIssue()`

```php
caseAttachExternalIssue($code, $testCaseexternalIssues): \Qase\APIClientV1\Model\BaseResponse
```

Attach the external issues to the test cases

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$testCaseexternalIssues = new \Qase\APIClientV1\Model\TestCaseexternalIssues(); // \Qase\APIClientV1\Model\TestCaseexternalIssues

try {
    $result = $apiInstance->caseAttachExternalIssue($code, $testCaseexternalIssues);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->caseAttachExternalIssue: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **testCaseexternalIssues** | [**\Qase\APIClientV1\Model\TestCaseexternalIssues**](../Model/TestCaseexternalIssues.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\BaseResponse**](../Model/BaseResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `caseDetachExternalIssue()`

```php
caseDetachExternalIssue($code, $testCaseexternalIssues): \Qase\APIClientV1\Model\BaseResponse
```

Detach the external issues from the test cases

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$testCaseexternalIssues = new \Qase\APIClientV1\Model\TestCaseexternalIssues(); // \Qase\APIClientV1\Model\TestCaseexternalIssues

try {
    $result = $apiInstance->caseDetachExternalIssue($code, $testCaseexternalIssues);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->caseDetachExternalIssue: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **testCaseexternalIssues** | [**\Qase\APIClientV1\Model\TestCaseexternalIssues**](../Model/TestCaseexternalIssues.md)|  | |

### Return type

[**\Qase\APIClientV1\Model\BaseResponse**](../Model/BaseResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createCase()`

```php
createCase($code, $testCaseCreate): \Qase\APIClientV1\Model\IdResponse
```

Create a new test case

This method allows to create a new test case in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$testCaseCreate = new \Qase\APIClientV1\Model\TestCaseCreate(); // \Qase\APIClientV1\Model\TestCaseCreate

try {
    $result = $apiInstance->createCase($code, $testCaseCreate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->createCase: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **testCaseCreate** | [**\Qase\APIClientV1\Model\TestCaseCreate**](../Model/TestCaseCreate.md)|  | |

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

## `deleteCase()`

```php
deleteCase($code, $id): \Qase\APIClientV1\Model\IdResponse
```

Delete test case

This method completely deletes a test case from repository.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.

try {
    $result = $apiInstance->deleteCase($code, $id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->deleteCase: ', $e->getMessage(), PHP_EOL;
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

## `getCase()`

```php
getCase($code, $id, $include): \Qase\APIClientV1\Model\TestCaseResponse
```

Get a specific test case

This method allows to retrieve a specific test case.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.
$include = 'include_example'; // string | A list of entities to include in response separated by comma. Possible values: external_issues.

try {
    $result = $apiInstance->getCase($code, $id, $include);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->getCase: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |
| **include** | **string**| A list of entities to include in response separated by comma. Possible values: external_issues. | [optional] |

### Return type

[**\Qase\APIClientV1\Model\TestCaseResponse**](../Model/TestCaseResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getCases()`

```php
getCases($code, $search, $milestoneId, $suiteId, $severity, $priority, $type, $behavior, $automation, $status, $externalIssuesType, $externalIssuesIds, $include, $limit, $offset): \Qase\APIClientV1\Model\TestCaseListResponse
```

Get all test cases

This method allows to retrieve all test cases stored in selected project.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$search = 'search_example'; // string | Provide a string that will be used to search by name.
$milestoneId = 56; // int | ID of milestone.
$suiteId = 56; // int | ID of test suite.
$severity = 'severity_example'; // string | A list of severity values separated by comma. Possible values: undefined, blocker, critical, major, normal, minor, trivial
$priority = 'priority_example'; // string | A list of priority values separated by comma. Possible values: undefined, high, medium, low
$type = 'type_example'; // string | A list of type values separated by comma. Possible values: other, functional smoke, regression, security, usability, performance, acceptance
$behavior = 'behavior_example'; // string | A list of behavior values separated by comma. Possible values: undefined, positive negative, destructive
$automation = 'automation_example'; // string | A list of values separated by comma. Possible values: is-not-automated, automated to-be-automated
$status = 'status_example'; // string | A list of values separated by comma. Possible values: actual, draft deprecated
$externalIssuesType = 'externalIssuesType_example'; // string | An integration type.
$externalIssuesIds = array('externalIssuesIds_example'); // string[] | A list of issue IDs.
$include = 'include_example'; // string | A list of entities to include in response separated by comma. Possible values: external_issues.
$limit = 10; // int | A number of entities in result set.
$offset = 0; // int | How many entities should be skipped.

try {
    $result = $apiInstance->getCases($code, $search, $milestoneId, $suiteId, $severity, $priority, $type, $behavior, $automation, $status, $externalIssuesType, $externalIssuesIds, $include, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->getCases: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **search** | **string**| Provide a string that will be used to search by name. | [optional] |
| **milestoneId** | **int**| ID of milestone. | [optional] |
| **suiteId** | **int**| ID of test suite. | [optional] |
| **severity** | **string**| A list of severity values separated by comma. Possible values: undefined, blocker, critical, major, normal, minor, trivial | [optional] |
| **priority** | **string**| A list of priority values separated by comma. Possible values: undefined, high, medium, low | [optional] |
| **type** | **string**| A list of type values separated by comma. Possible values: other, functional smoke, regression, security, usability, performance, acceptance | [optional] |
| **behavior** | **string**| A list of behavior values separated by comma. Possible values: undefined, positive negative, destructive | [optional] |
| **automation** | **string**| A list of values separated by comma. Possible values: is-not-automated, automated to-be-automated | [optional] |
| **status** | **string**| A list of values separated by comma. Possible values: actual, draft deprecated | [optional] |
| **externalIssuesType** | **string**| An integration type. | [optional] |
| **externalIssuesIds** | [**string[]**](../Model/string.md)| A list of issue IDs. | [optional] |
| **include** | **string**| A list of entities to include in response separated by comma. Possible values: external_issues. | [optional] |
| **limit** | **int**| A number of entities in result set. | [optional] [default to 10] |
| **offset** | **int**| How many entities should be skipped. | [optional] [default to 0] |

### Return type

[**\Qase\APIClientV1\Model\TestCaseListResponse**](../Model/TestCaseListResponse.md)

### Authorization

[TokenAuth](../../README.md#TokenAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateCase()`

```php
updateCase($code, $id, $testCaseUpdate): \Qase\APIClientV1\Model\IdResponse
```

Update test case

This method updates a test case.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: TokenAuth
$config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKey('Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Qase\APIClientV1\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Token', 'Bearer');


$apiInstance = new Qase\APIClientV1\Api\CasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = 'code_example'; // string | Code of project, where to search entities.
$id = 56; // int | Identifier.
$testCaseUpdate = new \Qase\APIClientV1\Model\TestCaseUpdate(); // \Qase\APIClientV1\Model\TestCaseUpdate

try {
    $result = $apiInstance->updateCase($code, $id, $testCaseUpdate);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CasesApi->updateCase: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **code** | **string**| Code of project, where to search entities. | |
| **id** | **int**| Identifier. | |
| **testCaseUpdate** | [**\Qase\APIClientV1\Model\TestCaseUpdate**](../Model/TestCaseUpdate.md)|  | |

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
