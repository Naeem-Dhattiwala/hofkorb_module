<?php
namespace Wrightglobal\OrderExtraImage\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'wrightglobal_orderextraimage_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Wrightglobal\OrderExtraImage\Model\Post', 'Wrightglobal\OrderExtraImage\Model\ResourceModel\Post');
	}

}
