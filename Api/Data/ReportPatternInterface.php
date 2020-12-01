<?php
namespace Khomenko\HealthCheck\Api\Data;

/**
 * Interface ReportPatternInterface
 * @api
 */
interface ReportPatternInterface
{
    /**
     * Entity id
     *
     * @return int
     */
    public function getId();
    /**
     * @return string
     */
    public function getFilePath();
    /**
     * @return string
     */
    public function getContent();
    /**
     * @return string
     */
    public function getShortContent();
    /**
     * @return int
     */
    public function getCnt1h();
    /**
     * @return int
     */
    public function getCnt24h();
    /**
     * @return int
     */
    public function getCntTotal();
    /**
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setId($id);
    /**
     * @param string $path
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setFilePath($path);
    /**
     * @param string $content
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setContent($content);
    /**
     * @param string $content
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setShortContent($content);
    /**
     * @param int $cnt
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setCnt1h($cnt);
    /**
     * @param int $cnt
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setCnt24h($cnt);
    /**
     * @param int $cnt
     * @return \Khomenko\HealthCheck\Api\Data\ReportPatternInterface
     */
    public function setCntTotal($cnt);
}
