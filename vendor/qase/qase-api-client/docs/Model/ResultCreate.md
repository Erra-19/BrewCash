# # ResultCreate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**status** | **string** | Can have the following values &#x60;passed&#x60;, &#x60;failed&#x60;, &#x60;blocked&#x60;, &#x60;skipped&#x60;, &#x60;invalid&#x60; + custom statuses |
**caseId** | **int** |  | [optional]
**case** | [**\Qase\APIClientV1\Model\ResultCreateCase**](ResultCreateCase.md) |  | [optional]
**startTime** | **int** |  | [optional]
**time** | **int** |  | [optional]
**timeMs** | **int** |  | [optional]
**defect** | **bool** |  | [optional]
**attachments** | **string[]** |  | [optional]
**stacktrace** | **string** |  | [optional]
**comment** | **string** |  | [optional]
**param** | **array<string,string>** | A map of parameters (name &#x3D;&gt; value) | [optional]
**paramGroups** | **string[][]** | List parameter groups by name only. Add their values in the &#39;param&#39; field | [optional]
**steps** | [**\Qase\APIClientV1\Model\TestStepResultCreate[]**](TestStepResultCreate.md) |  | [optional]
**authorId** | **int** |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
