<?php

namespace KL\Defrag\Helper;

/**
 * Class KL_Defrag_Helper_Data
 */
class KL_Defrag_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Save data to the log
     *
     * @param mixed $data Any type of data to log
     *
     * @return $this
     */
    public function log($data)
    {
        Mage::log($data, null, 'kl_defrag.log', true);

        return $this;
    }
}