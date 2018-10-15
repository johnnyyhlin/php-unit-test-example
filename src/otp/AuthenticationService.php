<?php

namespace App\otp;


class AuthenticationService
{
    /**
     * @var IProfile
     */
    private $profile;

    /**
     * @var IToken
     */
    private $token;

    /**
     * @var ILogger
     */
    private $logger;



    /**
     * AuthenticationService constructor.
     * @param IProfile $profile
     * @param IToken $token
     * @param ILogger $logger
     */
    public function __construct(IProfile $profile = null, IToken $token = null, ILogger $logger = null)
    {
        $this->profile = $profile ?: new ProfileDao();
        $this->token = $token ?: new RsaTokenDao();
        $this->logger = $logger ?: new Logger();

    }

    public function isValid($account, $password)
    {
        // 根據 account 取得自訂密碼
        $passwordFromDao = $this->profile->getPassword($account);
        // 根據 account 取得 RSA token 目前的亂數
        $randomCode = $this->token->getRandom($account);

        var_dump($randomCode);

        // 驗證傳入的 password 是否等於自訂密碼 + RSA token亂數
        $validPassword = $passwordFromDao . $randomCode;
        $isValid = $password === $validPassword;

        if ($isValid) {
            return true;
        } else {
            $this->logger->save(sprintf('account: %s try to login failed', $account));

            return false;
        }
    }
}