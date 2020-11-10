<?php


namespace W4PLEGO\SalesSequenceProfilesEditor\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\SalesSequence\Model\MetaFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Ui\Component\Listing\Columns\Column;

class Store extends Column
{
    /**
     * Escaper
     *
     * @var Escaper
     */
    protected $escaper;

    /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;

    /**
     * Store manager
     *
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var MetaFactory
     */
    private $metaFactory;

    /**
     * Store constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param MetaFactory $metaFactory
     * @param StoreManager $storeManager
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        MetaFactory $metaFactory,
        StoreManager $storeManager,
        SystemStore $systemStore,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->systemStore = $systemStore;
        $this->escaper = $escaper;
        $this->metaFactory = $metaFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
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
        $metaId = $item['meta_id'];
        /** @var \Magento\SalesSequence\Model\Meta $meta */
        $meta = $this->metaFactory->create()->load($metaId);
        if (!$meta->getId()) {
            return '';
        }
        $content = '';
        $origStore = (array) $meta->getStoreId();
        if (in_array(0, $origStore)) {
            return __('All Store Views');
        }
        $data = $this->systemStore->getStoresStructure(false, $origStore);


        foreach ($data as $website) {
//            $content .= $website['label'] . PHP_EOL;
            foreach ($website['children'] as $group) {
//                $content .= $this->escaper->escapeHtml($group['label']);

                foreach ($group['children'] as $storeId) {
                    $content .= $this->escaper->escapeHtml($storeId['value']) . ":";
                }
                foreach ($group['children'] as $store) {
                    $content .= $this->escaper->escapeHtml($store['label']);
                }

            }
        }

        return $content;
    }

    /**
     * Prepare component configuration
     *
     * @return void
     */
    public function prepare()
    {
        parent::prepare();
        if ($this->storeManager->isSingleStoreMode()) {
            $this->_data['config']['componentDisabled'] = true;
        }
    }
}
