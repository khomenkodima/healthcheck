<?php
namespace Khomenko\HealthCheck\Api\Data;

/**
 * Interface ReportItemInterface
 * @api
 */
interface ReportItemInterface
{
    /**
     * Entity id
     *
     * @return int
     */
    public function getId();
    /**
     * Entity id
     *
     * @return int
     */
    public function getPatternId();
    /**
     * @return string
     */
    public function getFilePath();
    /**
     * @return string
     */
    public function getContent();
    /**
     * @return int
     */
    public function getEventTime();
    /**
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function setId($id);
    /**
     * @param int $id
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function setPatternId($id);
    /**
     * @param string $path
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function setFilePath($path);
    /**
     * @param string $content
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function setContent($content);
    /**
     * @param string $eventTime
     * @return \Khomenko\HealthCheck\Api\Data\ReportItemInterface
     */
    public function setEventTime($eventTime);
}
