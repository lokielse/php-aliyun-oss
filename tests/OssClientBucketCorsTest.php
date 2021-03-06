<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\Model\CorsConfig;
use Aliyun\OSS\Model\CorsRule;

class OSSClientBucketCorsTest extends TestOSSClientBase
{

    public function testBucket()
    {
        $corsConfig = new CorsConfig();
        $rule       = new CorsRule();
        $rule->addAllowedHeader("x-oss-test");
        $rule->addAllowedHeader("x-oss-test2");
        $rule->addAllowedHeader("x-oss-test2");
        $rule->addAllowedHeader("x-oss-test3");
        $rule->addAllowedOrigin("http://www.b.com");
        $rule->addAllowedOrigin("http://www.a.com");
        $rule->addAllowedOrigin("http://www.a.com");
        $rule->addAllowedMethod("GET");
        $rule->addAllowedMethod("PUT");
        $rule->addAllowedMethod("POST");
        $rule->addExposeHeader("x-oss-test1");
        $rule->addExposeHeader("x-oss-test1");
        $rule->addExposeHeader("x-oss-test2");
        $rule->setMaxAgeSeconds(10);
        $corsConfig->addRule($rule);
        $rule = new CorsRule();
        $rule->addAllowedHeader("x-oss-test");
        $rule->addAllowedMethod("GET");
        $rule->addAllowedOrigin("http://www.b.com");
        $rule->addExposeHeader("x-oss-test1");
        $rule->setMaxAgeSeconds(110);
        $corsConfig->addRule($rule);

        try {
            $this->ossClient->putBucketCors($this->bucket, $corsConfig);
        } catch (Exception $e) {
            $this->assertFalse(true);
        }

        try {
            $object = "cors/test.txt";
            $this->ossClient->putObject($this->bucket, $object, file_get_contents(__FILE__));
            $headers = $this->ossClient->optionsObject($this->bucket, $object, "http://www.a.com", "GET", "", null);
            $this->assertNotEmpty($headers);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        try {
            sleep(1);
            $corsConfig2 = $this->ossClient->getBucketCors($this->bucket);
            $this->assertNotNull($corsConfig2);
            $this->assertEquals($corsConfig->serializeToXml(), $corsConfig2->serializeToXml());
        } catch (Exception $e) {
            $this->assertFalse(true);
        }

        try {
            $this->ossClient->deleteBucketCors($this->bucket);
        } catch (Exception $e) {
            $this->assertFalse(true);
        }

        try {
            sleep(5);
            $corsConfig3 = $this->ossClient->getBucketCors($this->bucket);
            $this->assertNotNull($corsConfig3);
            $this->assertNotEquals($corsConfig->serializeToXml(), $corsConfig3->serializeToXml());
        } catch (Exception $e) {
            $this->assertFalse(true);
        }

    }
}
