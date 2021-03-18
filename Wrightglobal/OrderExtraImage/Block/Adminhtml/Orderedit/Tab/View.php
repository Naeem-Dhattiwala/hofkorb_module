<?php
namespace Wrightglobal\OrderExtraImage\Block\Adminhtml\Orderedit\Tab;

use Wrightglobal\OrderExtraImage\Model\Post;
use Magento\Store\Model\StoreManagerInterface;

class View extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $orderFactory;

    protected $orderimagecollection;

    protected $storeManagerInterface;

    /*protected $_web = 'template/image-preview.html';*/
 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        Post $orderimagecollection,
        StoreManagerInterface $storeManagerInterface,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->orderFactory = $orderFactory;
        $this->orderimagecollection = $orderimagecollection;
        $this->storeManagerInterface = $storeManagerInterface;
        parent::__construct($context, $data);
    }
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }
    public function getOrderitems()
    {
        $orderId = $this->getOrder()->getEntityId();
        return $this->orderFactory->create()->load($orderId);
    }
    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }
    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }
    public function getTabLabel()
    {
        return __('Images');
    }
    public function getTabTitle()
    {
        return __('Images');
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
    public function getFormAction()
    {
        return $this->getUrl('orderextraimage/index/index', ['_secure' => true]);
    }
     public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }
    public function getOrderImageCollection()
    {
        $collection = $this->orderimagecollection->getCollection();
        return $collection;
    }
    public function getMediaUrl()
    {
        $currentStore = $this->storeManagerInterface->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}