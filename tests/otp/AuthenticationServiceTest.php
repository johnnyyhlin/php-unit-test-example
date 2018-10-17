<?php

namespace Tests\otp;

use App\otp\AuthenticationService;
use App\otp\ILogger;
use App\otp\IProfile;
use App\otp\IToken;
use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AuthenticationServiceTest extends TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    private $stubProfile;

    private $stubToken;

    private $target;
    
    private $stubLogger;

    protected function setUp()
    {
        $this->stubProfile = m::mock(IProfile::class);
        $this->stubToken = m::mock(IToken::class);
        $this->stubLogger = m::spy(ILogger::class);

        $this->target = new AuthenticationService($this->stubProfile, $this->stubToken, $this->stubLogger);
    }

    public function testIsValid()
    {
        $this->givenProfile('richard', '91');
        $this->givenToken('000000');

        $this->shouldBeValid('richard', '91000000');
    }

    public function test_isInvalid()
    {
        $this->givenProfile('richard', '91');
        $this->givenToken('000000');
        $actual = $this->target->isValid('richard', 'wrong_password');

        $this->assertTrue(!$actual);
    }

    public function test_logAccountWhenInvalid()
    {
        $this->givenProfile('richard', '91');
        $this->givenToken('000000');
        $this->target->isValid('richard', 'wrong_password');

        $this->stubLogger->shouldHaveReceived('save')->with(m::on(function($message){
            return strpos($message, 'richard') !== false;
        }))->once();
    }

    private function givenProfile($account, $password): void
    {
        $this->stubProfile->shouldReceive('getPassword')
            ->with($account)
            ->andReturn($password);
    }

    private function givenToken($token): void
    {
        $this->stubToken->shouldReceive('getRandom')
            ->andReturn($token);
    }

    private function shouldBeValid($account, $password): void
    {
        $actual = $this->target->isValid($account, $password);
        $this->assertTrue($actual);
    }
}