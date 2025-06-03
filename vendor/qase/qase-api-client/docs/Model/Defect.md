# # Defect

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **int** |  | [optional]
**title** | **string** |  | [optional]
**actualResult** | **string** |  | [optional]
**severity** | **string** |  | [optional]
**status** | **string** |  | [optional]
**milestoneId** | **int** |  | [optional]
**customFields** | [**\Qase\APIClientV1\Model\CustomFieldValue[]**](CustomFieldValue.md) |  | [optional]
**attachments** | [**\Qase\APIClientV1\Model\Attachment[]**](Attachment.md) |  | [optional]
**resolvedAt** | **\DateTime** |  | [optional]
**memberId** | **int** | Deprecated, use &#x60;author_id&#x60; instead. | [optional]
**authorId** | **int** |  | [optional]
**externalData** | **string** |  | [optional]
**runs** | **int[]** |  | [optional]
**results** | **string[]** |  | [optional]
**tags** | [**\Qase\APIClientV1\Model\TagValue[]**](TagValue.md) |  | [optional]
**createdAt** | **\DateTime** |  | [optional]
**updatedAt** | **\DateTime** |  | [optional]
**created** | **string** | Deprecated, use the &#x60;created_at&#x60; property instead. | [optional]
**updated** | **string** | Deprecated, use the &#x60;updated_at&#x60; property instead. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
