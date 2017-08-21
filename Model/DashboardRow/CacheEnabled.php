<?php

namespace MageHost\PerformanceDashboard\Model\DashboardRow;

/**
 * Class CacheEnabled
 *
 * Dashboard row to check if all caches are enabled.
 *
 * @package MageHost\PerformanceDashboard\Model\DashboardRow
 */
class CacheEnabled extends \MageHost\PerformanceDashboard\Model\DashboardRow implements
    \MageHost\PerformanceDashboard\Model\DashboardRowInterface
{
    /** @var \Magento\Framework\App\Cache\TypeListInterface */
    private $cacheTypeList;

    /**
     * Constructor.
     *
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        array $data = []
    ) {
        $this->cacheTypeList = $cacheTypeList;
        parent::__construct($data);
    }

    /**
     * Load Row, is called by DashboardRowFactory
     */
    public function load()
    {
        $this->setTitle('Cache Enabled');
        $info = [];
        $action = [];
        foreach ($this->cacheTypeList->getTypes() as $type) {
            if (! $type->getStatus()) {
                $info[] = sprintf(__('Cache is disabled: %s'), $type->getCacheType());
                $action[] = sprintf(__("Enable %s cache"), $type->getCacheType());
            }
        }
        if (empty($action)) {
            $this->setInfo(__('All cache is enabled'));
            $this->setStatus(self::STATUS_OK);
        } else {
            $this->setInfo(implode("\n", $info));
            $this->setAction(implode("\n", $action));
            $this->setStatus(self::STATUS_PROBLEM);
        }
    }
}
