<?php

namespace App\Utility;

use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;
use Ramsey\Uuid\Uuid;
use Illuminate\Container\Container;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Http;

class MomoApi

{
    protected $clientId;
    protected $clientSecret;
    protected $clientCallbackUri;
    protected $tokenUri;
    protected $transactionStatusUri;
    protected $accountStatusUri;
    protected $accountBalanceUri;
    protected $accountHolderInfoUri;
    protected $partyIdType;
    protected $subscriptionKey;
    protected $transactionUri;
    protected $environment;
    protected $currency;
    protected $baseUri;
    protected $userId;
    protected $apiKey;


    /**
     * Constructor.
     *
     * @param array $headers
     * @param array $middleware
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @uses \Illuminate\Contracts\Config\Repository
     *
     * @throws \Exception
     */
    public function __construct($headers = [], $middleware = [], ClientInterface $client = null)
    {
        $config = Container::getInstance()->make(Repository::class);

        $this->subscriptionKey = env('MOMO_COLLECTION_SUBSCRIPTION_KEY');
        $this->userId = env('MOMO_USER_ID');
        $this->apiKey =env('MOMO_API_KEY');
        $this->clientId = env('MOMO_COLLECTION_ID');
        $this->clientSecret =env('MOMO_COLLECTION_SECRET');
        $this->clientCallbackUri = env('MOMO_COLLECTION_CALLBACK_URI');
        $this->currency = env('MOMO_CURRENCY', 'XAF');
        $this->environment = env('MOMO_ENVIRONMENT','mtncameroon');

        $this->baseUri = env('MOMO_API_BASE_URI');

        $this->tokenUri = $config->get('mtn-momo.products.collection.token_uri');
        $this->transactionUri = $config->get('mtn-momo.products.collection.transaction_uri');
        $this->transactionStatusUri = $config->get('mtn-momo.products.collection.transaction_status_uri');
        $this->accountStatusUri = $config->get('mtn-momo.products.collection.account_status_uri');
        $this->accountBalanceUri = $config->get('mtn-momo.products.collection.account_balance_uri');
        $this->accountHolderInfoUri = $config->get('mtn-momo.products.collection.account_holder_info_uri');
        $this->partyIdType = $config->get('mtn-momo.products.collection.party_id_type');

    }


    /**
     * Request payee to pay.
     *
     * @see https://momodeveloper.mtn.com/docs/services/collection/operations/requesttopay-POST Documentation
     *
     * @param  string $transactionId Your transaction reference ID, Say: order number.
     * @param  string $partyId Account holder. Usually phone number if type is MSISDN.
     * @param  int $amount How much to debit the payer.
     * @param  string $payerMessage Payer transaction history message.
     * @param  string $payeeNote Payee transaction history message.
     *
     * @throws \Bmatovu\MtnMomo\Exceptions\CollectionRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     *
     * @return string                Auto generated payment reference. Format: UUID
     */
    public function requestToPay($transactionId, $partyId, $amount, $payerMessage = '', $payeeNote = '')
    {
        $momoTransactionId = Uuid::uuid4()->toString();

        $headers = [
            'Authorization' => 'Bearer '.$this->getToken() ,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Reference-Id' => $momoTransactionId,
            'X-Target-Environment' => $this->environment,
            // 'X-Callback-Url' => route('momo.success'),
            // 'X-Reference-Id' => "https://localhostvoting.eu-1.sharedwithexpose.com/voting/momopayment/success",
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey
        ];

        try {
            $data =  [
                'amount' => $amount,
                'currency' => $this->currency,
                'externalId' => $transactionId,
                'payer' => [
                    'partyIdType' => $this->partyIdType,
                    'partyId' => $partyId,
                ],
                'payerMessage' => alphanumeric($payerMessage),
                'payeeNote' => alphanumeric($payeeNote),
            ];

            $response = Http::withHeaders($headers)->post($this->baseUri.'/'.$this->transactionUri, $data)->json();
            // return [$response, $data];
            return $momoTransactionId;
        } catch (RequestException $ex) {
            throw new CollectionRequestException('Request to pay transaction - unsuccessful.', 0, $ex);
        }
    }

    /**
     * Get transaction status.
     *
     * @see https://momodeveloper.mtn.com/docs/services/collection/operations/requesttopay-referenceId-GET Documentation
     *
     * @param  string $momoTransactionId MTN Momo transaction ID. Returned from transact (requestToPay)
     *
     * @throws \Bmatovu\MtnMomo\Exceptions\CollectionRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return array
     */
    public function getTransactionStatus($momoTransactionId)
    {
        $transactionStatusUri = str_replace('{momoTransactionId}', $momoTransactionId, $this->transactionStatusUri);
        $headers = [
            'Authorization' => 'Bearer '.$this->getToken() ,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Target-Environment' => $this->environment,
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey
        ];
        // return $this->baseUri.$transactionStatusUri;
        try {
            // $response = $this->client->request('GET', $transactionStatusUri, [
            //     'headers' => [
            //         'X-Target-Environment' => $this->environment,
            //     ],
            // ]);
            return $response = Http::withHeaders($headers)->get($this->baseUri.'/'.$transactionStatusUri)->json();

            // return json_decode($response->getBody(), true);
        } catch (RequestException $ex) {
            throw new CollectionRequestException('Unable to get transaction status.', 0, $ex);
        }
    }

    /**
     * Request collections access token.
     *
     * @see https://momodeveloper.mtn.com/docs/services/collection/operations/token-POST Documentation
     *
     * @throws \Bmatovu\MtnMomo\Exceptions\CollectionRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return array
     */
    public function getToken()
    {
        try {
            $response = Http::withBasicAuth($this->userId, $this->apiKey)->withHeaders([
                'X-Target-Environment' => $this->environment,
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey

            ])->post($this->baseUri.'/collection/token/')->json();
            // return $response;
            return $response['access_token'];
        } catch (RequestException $ex) {
            throw new CollectionRequestException('Unable to get token.', 0, $ex);
        }
    }

}
