<?php
namespace Khomenko\HealthCheck\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Khomenko\HealthCheck\Model\Service\ProcessReports;
use Khomenko\HealthCheck\Helper\Reports as ReportsHelper;

class InitReports extends \Symfony\Component\Console\Command\Command
{

    /**
     * ProcessReports
     */
    protected $processReports;
    /**
     * ReportsHelper
     */
    protected $helper;


    public function __construct(
        ProcessReports $processReports,
        ReportsHelper $helper
    ) {
        $this->helper = $helper;
        $this->processReports = $processReports;
        parent::__construct();
    }

    /**
     * @api
     */
    public function configure()
    {
        $this->setName('healthcheck:initreports')
            ->setDescription('Process var/reports files for latest 24h');
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->processReports->groupReports($this->helper->getInitPeriod());
        $output->write('OK');
    }
}

