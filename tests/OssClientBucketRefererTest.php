<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\Model\RefererConfig;

class OSSClientBucketRefererTest extends TestOSSClientBase
{

    public function testBucket()
    {
        $refererConfig = new RefererConfig();
        $refererConfig->addReferer('http://www.aliyun.com');

        try {
            $this->ossClient->putBucketReferer($this->bucket, $refererConfig);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            $this->assertTrue(false);
        }
        try {
            sleep(5);
            $refererConfig2 = $this->ossClient->getBucketReferer($this->bucket);
            $this->assertEquals($refererConfig->serializeToXml(), $refererConfig2->serializeToXml());
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        try {
            $nullRefererConfig = new RefererConfig();
            $nullRefererConfig->setAllowEmptyReferer(false);
            $this->ossClient->putBucketReferer($this->bucket, $nullRefererConfig);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        try {
            sleep(5);
            $refererConfig3 = $this->ossClient->getBucketLogging($this->bucket);
            $this->assertNotEquals($refererConfig->serializeToXml(), $refererConfig3->serializeToXml());
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }
}
