<?php
declare(strict_types=1);

namespace Wrightglobal\OrderExtraImage\Controller\Adminhtml\Index;

use Wrightglobal\OrderExtraImage\Model\Post;
use Magento\Framework\Controller\ResultFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $model;
    protected $customermodel;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $storeManagerInterface;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Post $model,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManagerInterface,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->model = $model;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $query['order_id'] = $this->getRequest()->getPostValue("order_id");
        $query['order_itemid'] = $this->getRequest()->getPostValue("order_itemid");
        $files = $this->getRequest()->getFiles();
        $currentStore = $this->storeManagerInterface->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        echo "<br>";
        for ($i=0; $i < count($_FILES['order_featured_image']['name']); $i++) { 
            print_r($query['order_featured_image'] = $files['order_featured_image']['name'][$i]);
        }
        exit();
        if ($query){
            try{
                $uploaderFactory = $this->uploaderFactory->create(['fileId'=>'order_featured_image']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $imageAdapter = $this->adapterFactory->create();
                $uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
                $destinationPath = 'E:\xampp\htdocs\hofkorb\pub\media\order\images';
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
                $this->model->setData($query);
                $this->model->Save();
                $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $redirect->setUrl($this->_redirect->getRefererUrl());
                $this->messageManager->addSuccess(__('You submitted your Question successfully.'));
                return $redirect;
            }catch (\Exception $e) {
                $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $redirect->setUrl($this->_redirect->getRefererUrl());
                $this->messageManager->addError($e->getMessage());
                return $redirect;
            }
        }else{
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($this->_redirect->getRefererUrl());
            $this->messageManager->addError (__('Failed To Submit  Please Provide Valid Data.'));
            return $redirect;
        }
    }

}

