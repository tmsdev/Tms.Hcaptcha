<?php
namespace Tms\Hcaptcha\Validation\Validator;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Http\Client\Browser;
use Neos\Flow\Http\Client\CurlEngine;
use Neos\Flow\Http\Uri;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Psr\Log\LoggerInterface;

/**
 * hCaptcha validator
 */
class IsHumanValidator extends AbstractValidator
{
    /**
     * @Flow\Inject
     * @var LoggerInterface
     */
    protected $systemLogger;

    /**
     * @var boolean
     */
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = [
        'secret' => ['', 'The secret key of your hCaptcha account', 'string', true]
    ];

    /**
     * @param mixed $value The value that should be validated
     *
     * @return void
     * @throws \Neos\Flow\Validation\Exception\InvalidValidationOptionsException
     */
    protected function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('Not a valid string.', 1600419197);
            return;
        }

        $browser = new Browser();
        $browser->setRequestEngine(new CurlEngine());

        $uri = 'https://hcaptcha.com/siteverify';
        $arguments['secret'] = $this->getOptions()['secret'];
        $arguments['response'] = $value;

        $response = $browser->request($uri, 'POST', $arguments);
        $responseContentsArray = json_decode($response->getBody()->getContents(), true);

        if (!$responseContentsArray['success']) {
            $this->systemLogger->error($response);
            $this->addError('Captcha failed. Please try again.', 1600419210);
        }
    }
}
