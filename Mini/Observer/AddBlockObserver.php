<?php


namespace Web\Mini\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Block\ShortcutButtons;
use Web\Mini\Block\Frontend\Mini;
Use Magento\Catalog\Block\ShortcutInterface;

/**
 * Class AddBlockObserver
 * @package Web\Mini\Observer
 */
class AddBlockObserver implements ObserverInterface

{
    /**
     * Alias for mini_cart block.
     */
    const MINICART_ALIAS = 'mini_cart';

    /**
     * @var string[]
     */
    private $buttonBlocks;

    /**
     * @param string[] $buttonBlocks
     */
    public function __construct(array $buttonBlocks = [])
    {
        $this->buttonBlocks = $buttonBlocks;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $observer->getData('is_catalog_product');

        $shortcutButtons = $observer->getEvent()->getContainer();
        $shortcut = $shortcutButtons->getLayout()->createBlock('Web\Mini\Block\Frontend\Mini')->setTemplate('Web_Mini::minicart_open.phtml');
        $shortcutButtons->addShortcut($shortcut);

    }
}

