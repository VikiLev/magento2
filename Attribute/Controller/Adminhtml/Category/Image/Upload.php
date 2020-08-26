<?php
namespace Web\Attribute\Controller\Adminhtml\Category\Image;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Upload
 */
class Upload extends Action
{
    protected $baseTmpPath;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
        parent::__construct($context);

    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute() {

        try {
            $result = $this->imageUploader->saveFileToTmpDir('custom_image');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
