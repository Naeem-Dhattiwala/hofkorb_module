<?php
namespace Wrightglobal\OrderExtraImage\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'order_images';

	protected $_cacheTag = 'order_images';

	protected $_eventPrefix = 'order_images';

	protected function _construct()
	{
		$this->_init('Wrightglobal\OrderExtraImage\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}