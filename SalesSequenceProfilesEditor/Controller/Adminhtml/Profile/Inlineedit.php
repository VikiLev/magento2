<?php

namespace W4PLEGO\SalesSequenceProfilesEditor\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\SalesSequence\Model\ProfileFactory;
use Magento\SalesSequence\Model\MetaFactory;
use W4PLEGO\SalesSequenceProfilesEditor\Model\ResourceModel\Profile\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\SalesSequence\Model\ResourceModel\Profile as ProfileResourceModel;

/**
 * Class Inlineedit
 * @package W4PLEGO\SalesSequenceProfilesEditor\Controller\Adminhtml\Profile
 */
class Inlineedit extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;
    /**
     * @var ProfileFactory
     */
    protected $profileFactory;
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var ResourceConnection
     */
    protected $resource;
    /**
     * @var MetaFactory
     */
    protected $metaFactory;
    /**
     * @var ProfileResourceModel
     */
    protected $profileResourceModel;

    /**
     * Inlineedit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param ProfileFactory $profileFactory
     * @param MetaFactory $metaFactory
     * @param CollectionFactory $collection
     * @param ResourceConnection $resource
     * @param ProfileResourceModel $profileResourceModel
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        ProfileFactory $profileFactory,
        MetaFactory $metaFactory,
        CollectionFactory $collection,
        ResourceConnection $resource,
        ProfileResourceModel $profileResourceModel
    )
    {
        parent::__construct($context);
        $this->profileResourceModel = $profileResourceModel;
        $this->resource = $resource;
        $this->collection = $collection;
        $this->jsonFactory = $jsonFactory;
        $this->profileFactory = $profileFactory;
        $this->metaFactory = $metaFactory;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    $model = $this->profileFactory->create()->load($modelid);
                    try {
                        $prefix = $postItems[$modelid]['prefix'];
                        $suffix = $postItems[$modelid]['suffix'];
                        $profileId = $postItems[$modelid]['profile_id'];
                        $profile=$this->profileFactory->create()->load($profileId);
                        $prefixById = $profile->getData('prefix');
                        $suffixById = $profile->getData('suffix');
                        $metaId = $profileId;
                        $entityType = $this->metaFactory->create()->load($metaId)->getData('entity_type');
                        $second_table_name = $this->resource->getTableName('sales_sequence_meta');
                        $collection = $this->collection->create()
                            ->join([$second_table_name], "main_table.meta_id =$second_table_name.meta_id")
                            ->addFieldToFilter('entity_type', $entityType);
                        $prefixTab = [];
                        $suffixTab = [];
                        foreach ($collection as $item) {
                            if (!empty($item->getData('prefix'))) {
                                $prefixTab[] = $item->getData('prefix');
                            }
                            if (!empty($item->getData('suffix'))) {
                                $suffixTab[] = $item->getData('suffix');
                            }
                        }
                        if (in_array($prefix, $prefixTab) && !($prefixById == $prefix) || in_array($suffix, $suffixTab) && !($suffixById == $suffix)) {
                            $messages[] = __($entityType . ' with this number already exists');
                            $error = true;
                        } else {
                            $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                            $this->profileResourceModel->save($model);

                        }
                    } catch
                    (\Exception $e) {
                        $messages[] = "[File Icon ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}

