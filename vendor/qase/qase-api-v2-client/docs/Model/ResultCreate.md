# # ResultCreate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**title** | **string** |  |
**execution** | [**\Qase\APIClientV2\Model\ResultExecution**](ResultExecution.md) |  |
**id** | **string** | If passed, used as an idempotency key | [optional]
**signature** | **string** |  | [optional]
**testopsId** | **int** | ID of the test case. Cannot be specified together with testopd_ids. | [optional]
**testopsIds** | **int[]** | IDs of the test cases. Cannot be specified together with testopd_id. | [optional]
**fields** | [**\Qase\APIClientV2\Model\ResultCreateFields**](ResultCreateFields.md) |  | [optional]
**attachments** | **string[]** |  | [optional]
**steps** | [**\Qase\APIClientV2\Model\ResultStep[]**](ResultStep.md) |  | [optional]
**stepsType** | [**\Qase\APIClientV2\Model\ResultStepsType**](ResultStepsType.md) |  | [optional]
**params** | **array<string,string>** |  | [optional]
**paramGroups** | **string[][]** | List parameter groups by name only. Add their values in the &#39;params&#39; field | [optional]
**relations** | [**\Qase\APIClientV2\Model\ResultRelations**](ResultRelations.md) |  | [optional]
**message** | **string** |  | [optional]
**defect** | **bool** | If true and the result is failed, the defect associated with the result will be created | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
