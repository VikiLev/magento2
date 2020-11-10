<?php

namespace W4PLEGO\SalesSequenceProfilesEditor\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\SalesSequence\Model\MetaFactory;
use Magento\SalesSequence\Model\ProfileFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Preview extends Column
{
    public $profileFactory;
    public $metaFactory;

    public function __construct(
        ContextInterface $context,
        MetaFactory $metaFactory,
        UiComponentFactory $uiComponentFactory,
        ProfileFactory $profileFactory,
        array $components = [],
        array $data = [])
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->metaFactory = $metaFactory;
        $this->profileFactory = $profileFactory;
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem(array $item)
    {
        $content = '';
        $prefix = $item['prefix'];
        $suffix = $item['suffix'];
        $content =  $prefix . '000000000' . $suffix ;
        return  $content;
    }
}
