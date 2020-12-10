<?php

namespace W4PLEGO\BaseIntegration\Ui\Component\Listing\Column;

use Magento\Backend\Block\Widget\Button;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\LayoutInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use W4PLEGO\BaseIntegration\Model\Integration;

class RunIntegration extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param LayoutInterface $layout
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        LayoutInterface $layout,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->layout = $layout;
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
            $name = $this->getData('name');
            $btnLabel = __('Run');
            $btnVisible = true;

            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    if (isset($item['status']) && $item['status'] == Integration::STATUS_DISABLED) {
                        $btnVisible = false;
                        continue;
                    }

                    if (isset($item['status']) && $item['status'] == Integration::STATUS_PROCESSING) {
                        // @todo Implement current process visualization
                        //$btnLabel = __('View Process');
                    }

                    $item['view_url'] = $this->getViewUrl();
                    $item['run_url'] = $this->getRunUrl();

                    $item[$name] = $this->layout->createBlock(
                        Button::class,
                        '',
                        [
                            'data' => [
                                'label' => $btnLabel,
                                'type' => 'button',
                                'disabled' => false,
                                'visible' => $btnVisible,
                                'class' => 'integration-grid-view',
                            ]
                        ]
                    )->toHtml();
                }
            }
        }

        return $dataSource;
    }

    /**
     * @return string
     */
    protected function getViewUrl()
    {
        return $this->urlBuilder->getUrl($this->getData('config/viewUrlPath'));
    }

    /**
     * @return string
     */
    protected function getRunUrl()
    {
        return $this->urlBuilder->getUrl($this->getData('config/runUrlPath'));
    }
}
