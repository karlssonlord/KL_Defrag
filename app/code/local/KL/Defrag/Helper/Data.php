<?php

/**
 * Class KL_Defrag_Helper_Data
 */
class KL_Defrag_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Save data to the log
     *
     * @param $data
     *
     * @return $this
     */
    public function log($data)
    {
        Mage::log($data, null, 'kl_defrag.log', true);

        return $this;
    }
}