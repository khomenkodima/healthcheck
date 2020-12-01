<?php

namespace Khomenko\HealthCheck\Helper;

class Reports
{
    /**
     * Init period days
     */
    const INIT_PERIOD = 10;
    /**
     * Similarity percent limit
     */
    const SIMILARITY_PERCENT_LIMIT = 50;
    /**
     * Cron bunch amount
     */
    const CRON_BUNCH_AMOUNT = 100;

    public function getInitPeriod()
    {
        return self::INIT_PERIOD;
    }
    public function getSimilarityPercentLimit()
    {
        return self::SIMILARITY_PERCENT_LIMIT;
    }
    public function getCronBunchAmount()
    {
        return self::CRON_BUNCH_AMOUNT;
    }
}
