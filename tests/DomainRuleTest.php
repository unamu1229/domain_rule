<?php

namespace DomainRule;

class DomainRuleTest extends \PHPUnit\Framework\TestCase
{
    public function testDomainRule()
    {
        $errorMsg = 'DomainException error success';
        $domain = new DomainRule(function () {
            new class () {
                public function __construct()
                {
                    throw new \DomainException('test');
                }
            };
        }, $errorMsg);

        $this->assertFalse($domain->passes('test', '100'));
        $this->assertSame($errorMsg, $domain->message());
    }
}
