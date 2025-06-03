# # TestCase

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **int** |  | [optional]
**position** | **int** |  | [optional]
**title** | **string** |  | [optional]
**description** | **string** |  | [optional]
**preconditions** | **string** |  | [optional]
**postconditions** | **string** |  | [optional]
**severity** | **int** |  | [optional]
**priority** | **int** |  | [optional]
**type** | **int** |  | [optional]
**layer** | **int** |  | [optional]
**isFlaky** | **int** |  | [optional]
**behavior** | **int** |  | [optional]
**automation** | **int** |  | [optional]
**status** | **int** |  | [optional]
**milestoneId** | **int** |  | [optional]
**suiteId** | **int** |  | [optional]
**customFields** | [**\Qase\APIClientV1\Model\CustomFieldValue[]**](CustomFieldValue.md) |  | [optional]
**attachments** | [**\Qase\APIClientV1\Model\Attachment[]**](Attachment.md) |  | [optional]
**stepsType** | **string** |  | [optional]
**steps** | [**\Qase\APIClientV1\Model\TestStep[]**](TestStep.md) |  | [optional]
**params** | [**\Qase\APIClientV1\Model\TestCaseParams**](TestCaseParams.md) |  | [optional]
**tags** | [**\Qase\APIClientV1\Model\TagValue[]**](TagValue.md) |  | [optional]
**memberId** | **int** | Deprecated, use &#x60;author_id&#x60; instead. | [optional]
**authorId** | **int** |  | [optional]
**createdAt** | **\DateTime** |  | [optional]
**updatedAt** | **\DateTime** |  | [optional]
**deleted** | **string** |  | [optional]
**created** | **string** | Deprecated, use the &#x60;created_at&#x60; property instead. | [optional]
**updated** | **string** | Deprecated, use the &#x60;updated_at&#x60; property instead. | [optional]
**externalIssues** | [**\Qase\APIClientV1\Model\ExternalIssue[]**](ExternalIssue.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
