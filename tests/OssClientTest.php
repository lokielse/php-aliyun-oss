<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\OSSClient;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Config.php';

class OSSClientTest extends \PHPUnit_Framework_TestCase
{

    public function testConstrunct()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, Config::OSS_ACCESS_KEY, Config::OSS_ENDPOINT);
            $this->assertFalse($ossClient->isUseSSL());
            $ossClient->setUseSSL(true);
            $this->assertTrue($ossClient->isUseSSL());
            $this->assertTrue(true);
            $this->assertEquals(3, $ossClient->getMaxRetries());
            $ossClient->setMaxTries(4);
            $this->assertEquals(4, $ossClient->getMaxRetries());
            $ossClient->setTimeout(10);
            $ossClient->setConnectTimeout(20);
        } catch (Exception $e) {
            assertFalse(true);
        }
    }


    public function testConstrunct2()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, "", Config::OSS_ENDPOINT);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals("access key secret is empty", $e->getMessage());
        }
    }


    public function testConstrunct3()
    {
        try {
            $ossClient = new OSSClient("", Config::OSS_ACCESS_KEY, Config::OSS_ENDPOINT);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals("access key id is empty", $e->getMessage());
        }
    }


    public function testConstrunct4()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, Config::OSS_ACCESS_KEY, "");
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals('endpoint is empty', $e->getMessage());
        }
    }


    public function testConstrunct5()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, Config::OSS_ACCESS_KEY, "123.123.123.1");
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }


    public function testConstrunct6()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, Config::OSS_ACCESS_KEY, "https://123.123.123.1");
            $this->assertTrue($ossClient->isUseSSL());
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }


    public function testConstrunct7()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, Config::OSS_ACCESS_KEY, "http://123.123.123.1");
            $this->assertFalse($ossClient->isUseSSL());
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }


    public function testConstrunct8()
    {
        try {
            $ossClient = new OSSClient(Config::OSS_ACCESS_ID, Config::OSS_ACCESS_KEY, "http://123.123.123.1", true);
            $ossClient->listBuckets();
            $this->assertFalse(true);
        } catch (Exception $e) {

        }
    }

}
