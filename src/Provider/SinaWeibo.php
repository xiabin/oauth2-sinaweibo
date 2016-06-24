<?php
/**
 * Created by PhpStorm.
 * User: xiabin
 * Date: 16/6/24
 * Time: 下午7:12
 */


namespace Xiabin\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client as HttpClient;
use Xiabin\OAuth2\Client\Provider\Exception;
use Xiabin\OAuth2\Client\Provider\Exception\SinaWeiboIdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class SinaWeibo
 * @package League\OAuth2\Client\Provider
 */
class SinaWeibo extends AbstractProvider
{

    /**
     * SinaWeibo constructor.
     * @param array $options
     * @param array $config
     */
    public function __construct($options, $config = [])
    {
        $client = (count($config) > 0 ? new HttpClient($config) : new HttpClient());

        parent::__construct($options, ['httpClient' => $client]);
    }

    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return "https://api.weibo.com/oauth2/authorize";
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://api.weibo.com/oauth2/access_token?' . http_build_query([
            'client_id' => $params['client_id'],
            'client_secret' => $params['client_secret'],
            'grant_type' => $params['grant_type'],
            'redirect_uri' => $params['redirect_uri'],
            'code' => $params['code']
        ]);

    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        // 暂不使用
    }


    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        // 暂不使用
    }

    /**
     * Checks a provider response for errors.
     * @param ResponseInterface $response
     * @param array|string $data
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw SinaWeiboIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw SinaWeiboIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array $response
     * @param  AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        // 暂不使用.
    }
}
