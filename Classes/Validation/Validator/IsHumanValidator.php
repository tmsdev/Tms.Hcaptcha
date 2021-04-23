<?php
namespace Tms\Hcaptcha\Validation\Validator;

use http\Encoding\Stream;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Http\Client\Browser;
use Neos\Flow\Http\Client\CurlEngine;
use Neos\Flow\Http\ContentStream;
use Neos\Flow\Log\Utility\LogEnvironment;
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
    protected $logger;

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
        if (!is_string($value) || empty($value)) {
            $this->addError('Please solve the captcha.', 1600419197);
            return;
        }

        $requestEngine = new CurlEngine();
        $requestEngine->setOption(CURLOPT_TIMEOUT, 60);

        $browser = new Browser();
        $browser->setRequestEngine($requestEngine);

        $uri = 'https://hcaptcha.com/siteverify';
        $arguments['secret'] = $this->getOptions()['secret'];
        $arguments['response'] = $value;

        try {
            // TODO: needs testing - the third request() param "$arguments" does not work anymore since Neos 5.3
            $response = $browser->request($uri, 'POST', [], [], [], http_build_query($arguments));
            $responseContentsArray = json_decode($response->getBody()->getContents(), true);

            if (!$responseContentsArray['success']) {
                $this->logger->error(json_encode($responseContentsArray), LogEnvironment::fromMethodName(__METHOD__));
                $this->addError('Captcha failed. Please try again.', 1600419210);
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), LogEnvironment::fromMethodName(__METHOD__));
            $this->addError('Captcha verification request failed. Please try again.', 1601958019);
        }
    }
}
