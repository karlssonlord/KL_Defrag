<?php

/**
 * Class KL_Defrag_Model_Cron
 */
class KL_Defrag_Model_Cron
{
    /**
     * Defrag tables
     */
    public function defrag()
    {
        /**
         * Fetch database name
         */
        $databaseName = Mage::getConfig()
            ->getResourceConnectionConfig('default_setup')->dbname;

        /**
         * Get our helper
         */
        $helper = Mage::helper('kldefrag');

        /**
         * Get the resource model
         */
        $resource = Mage::getSingleton('core/resource');

        /**
         * Retrieve the read connection
         */
        $readConnection = $resource->getConnection('core_read');

        /**
         * Retrieve the write connection
         */
        $writeConnection = $resource->getConnection('core_write');

        /**
         * Setup our magic query to fetch table fragmentation
         */
        $sqlQuery = <<<EOT
SELECT
  ENGINE, TABLE_SCHEMA, TABLE_NAME,
  round(DATA_LENGTH/1024/1024) AS data_length,
  round(INDEX_LENGTH/1024/1024) AS index_length,
  round(DATA_FREE/ 1024/1024) AS data_free,
  round((data_free/(data_length+index_length))/100) AS fragmentation
FROM
  information_schema.tables
WHERE
  DATA_FREE > 0 AND TABLE_SCHEMA='" . $databaseName . "'
ORDER BY
  fragmentation DESC
EOT;

        /**
         * Fetch fragmentation status
         */
        foreach ($readConnection->fetchAll($sqlQuery) as $dbRow) {
            /**
             * Act only if fragmentation is above 5
             */
            if ($dbRow['fragmentation'] >= 5) {
                /**
                 * Save a notice to the log
                 */
                $helper->log(
                    sprintf(
                        'Table "%s" has a fragmentation value of %s
                        (%s mb free) and will be optimized',
                        $dbRow['TABLE_NAME'],
                        $dbRow['fragmentation'],
                        $dbRow['data_free']
                    )
                );

                /**
                 * @todo act on table to optimize
                 */
                switch (strtolower($dbRow['ENGINE'])) {
                    case 'innodb':
                        break;
                    case 'myisam':
                        break;
                }
            }
        }
    }
}