# # SearchResponseAllOfResultEntities

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**runId** | **int** |  |
**planId** | **int** |  |
**resultHash** | **string** |  |
**requirementId** | **int** |  |
**testCaseId** | **int** |  |
**defectId** | **int** |  |
**id** | **int** |  | [optional]
**title** | **string** |  | [optional]
**description** | **string** |  | [optional]
**status** | **string** |  | [optional]
**statusText** | **string** |  | [optional]
**startTime** | **\DateTime** |  | [optional]
**endTime** | **\DateTime** |  | [optional]
**public** | **bool** |  | [optional]
**stats** | [**\Qase\APIClientV1\Model\RunStats**](RunStats.md) |  | [optional]
**timeSpent** | **int** | Time in ms. | [optional]
**elapsedTime** | **int** | Time in ms. | [optional]
**environment** | [**\Qase\APIClientV1\Model\RunEnvironment**](RunEnvironment.md) |  | [optional]
**milestone** | [**\Qase\APIClientV1\Model\RunMilestone**](RunMilestone.md) |  | [optional]
**customFields** | [**\Qase\APIClientV1\Model\CustomFieldValue[]**](CustomFieldValue.md) |  | [optional]
**tags** | [**\Qase\APIClientV1\Model\TagValue[]**](TagValue.md) |  | [optional]
**cases** | **int[]** |  | [optional]
**hash** | **string** |  | [optional]
**comment** | **string** |  | [optional]
**stacktrace** | **string** |  | [optional]
**caseId** | **int** |  | [optional]
**steps** | [**\Qase\APIClientV1\Model\TestStep[]**](TestStep.md) |  | [optional]
**isApiResult** | **bool** |  | [optional]
**timeSpentMs** | **int** |  | [optional]
**attachments** | [**\Qase\APIClientV1\Model\Attachment[]**](Attachment.md) |  | [optional]
**parentId** | **int** |  | [optional]
**memberId** | **int** | Deprecated, use &#x60;author_id&#x60; instead. | [optional]
**type** | **int** |  | [optional]
**createdAt** | **\DateTime** |  | [optional]
**updatedAt** | **\DateTime** |  | [optional]
**position** | **int** |  | [optional]
**preconditions** | **string** |  | [optional]
**postconditions** | **string** |  | [optional]
**severity** | **string** |  | [optional]
**priority** | **int** |  | [optional]
**layer** | **int** |  | [optional]
**isFlaky** | **int** |  | [optional]
**behavior** | **int** |  | [optional]
**automation** | **int** |  | [optional]
**milestoneId** | **int** |  | [optional]
**suiteId** | **int** |  | [optional]
**stepsType** | **string** |  | [optional]
**params** | [**\Qase\APIClientV1\Model\TestCaseParams**](TestCaseParams.md) |  | [optional]
**authorId** | **int** |  | [optional]
**updatedBy** | **int** | Author ID of the last update. | [optional]
**actualResult** | **string** |  | [optional]
**resolved** | **\DateTime** |  | [optional]
**externalData** | **string** |  | [optional]
**casesCount** | **int** |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
