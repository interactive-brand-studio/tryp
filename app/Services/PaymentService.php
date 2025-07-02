<?php

namespace App\Services;

use App\Models\PaymentGateway;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Get the active payment gateway
     *
     * @return PaymentGateway|null
     */
    public function getActiveGateway()
    {
        return PaymentGateway::where('is_active', true)
            ->where('is_default', true)
            ->first() ?? PaymentGateway::where('is_active', true)->first();
    }

    /**
     * Process a credit card payment
     *
     * @param array $cardData Credit card data
     * @param float $amount Amount to charge
     * @param string $currency Currency code
     * @param array $customerInfo Customer information
     * @param string $description Payment description
     * @param string|null $gatewayType Override the default gateway
     * @return array
     * @throws Exception
     */
    public function processCardPayment(array $cardData, float $amount, string $currency, array $customerInfo, string $description, ?string $gatewayType = null)
    {
        // Get the payment gateway to use
        $gateway = $gatewayType 
            ? PaymentGateway::where('gateway_type', $gatewayType)->where('is_active', true)->first()
            : $this->getActiveGateway();

        if (!$gateway) {
            throw new Exception('No active payment gateway is available');
        }

        $gatewayConfig = $gateway->getConfigArray();

        // Process based on gateway type
        try {
            switch ($gateway->gateway_type) {
                case 'stripe':
                    return $this->processStripePayment($cardData, $amount, $currency, $customerInfo, $description, $gatewayConfig);
                case 'paypal':
                    return $this->processPayPalPayment($cardData, $amount, $currency, $customerInfo, $description, $gatewayConfig);
                case 'authorize_net':
                    return $this->processAuthorizeNetPayment($cardData, $amount, $currency, $customerInfo, $description, $gatewayConfig);
                default:
                    throw new Exception("Payment gateway '{$gateway->gateway_type}' is not supported");
            }
        } catch (Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage(), [
                'gateway' => $gateway->name,
                'amount' => $amount,
                'currency' => $currency,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Process payment through Stripe
     *
     * @param array $cardData
     * @param float $amount
     * @param string $currency
     * @param array $customerInfo
     * @param string $description
     * @param array $config
     * @return array
     */
    protected function processStripePayment(array $cardData, float $amount, string $currency, array $customerInfo, string $description, array $config)
    {
        // This is a placeholder. In a real implementation, you would use the Stripe SDK.
        // You would need to install the Stripe PHP library: composer require stripe/stripe-php

        // Example implementation:
        /*
        \Stripe\Stripe::setApiKey($config['api_key']);
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100, // Convert to cents
            'currency' => $currency,
            'payment_method_data' => [
                'type' => 'card',
                'card' => [
                    'number' => $cardData['card_number'],
                    'exp_month' => $cardData['exp_month'],
                    'exp_year' => $cardData['exp_year'],
                    'cvc' => $cardData['cvc'],
                ],
            ],
            'description' => $description,
            'customer_data' => [
                'email' => $customerInfo['email'],
                'name' => $customerInfo['name'],
            ],
            'confirm' => true,
        ]);
        */

        // Simulated response for demo purposes
        return [
            'success' => true,
            'transaction_id' => 'str_' . uniqid(),
            'gateway' => 'stripe',
            'amount' => $amount,
            'currency' => $currency,
            'message' => 'Payment processed successfully',
        ];
    }

    /**
     * Process payment through PayPal
     *
     * @param array $cardData
     * @param float $amount
     * @param string $currency
     * @param array $customerInfo
     * @param string $description
     * @param array $config
     * @return array
     */
    protected function processPayPalPayment(array $cardData, float $amount, string $currency, array $customerInfo, string $description, array $config)
    {
        // This is a placeholder. In a real implementation, you would use the PayPal SDK.
        // You would need to install the PayPal PHP SDK: composer require paypal/rest-api-sdk-php

        // Simulated response for demo purposes
        return [
            'success' => true,
            'transaction_id' => 'pp_' . uniqid(),
            'gateway' => 'paypal',
            'amount' => $amount,
            'currency' => $currency,
            'message' => 'Payment processed successfully',
        ];
    }

    /**
     * Process payment through Authorize.net
     *
     * @param array $cardData
     * @param float $amount
     * @param string $currency
     * @param array $customerInfo
     * @param string $description
     * @param array $config
     * @return array
     */
    protected function processAuthorizeNetPayment(array $cardData, float $amount, string $currency, array $customerInfo, string $description, array $config)
    {
        // This is a placeholder. In a real implementation, you would use the Authorize.Net SDK.
        // You would need to install the Authorize.Net PHP SDK: composer require authorizenet/authorizenet

        // Simulated response for demo purposes
        return [
            'success' => true,
            'transaction_id' => 'auth_' . uniqid(),
            'gateway' => 'authorize_net',
            'amount' => $amount,
            'currency' => $currency,
            'message' => 'Payment processed successfully',
        ];
    }

    /**
     * Validate credit card information
     *
     * @param array $cardData Credit card data including number, exp month/year, cvv
     * @return bool
     */
    public function validateCardData(array $cardData): bool
    {
        // Check required fields
        $requiredFields = ['card_number', 'exp_month', 'exp_year', 'cvc'];
        foreach ($requiredFields as $field) {
            if (!isset($cardData[$field]) || empty($cardData[$field])) {
                return false;
            }
        }

        // Validate card number (simple Luhn algorithm check)
        if (!$this->validateCardNumber($cardData['card_number'])) {
            return false;
        }

        // Validate expiration date
        $currentYear = (int) date('Y');
        $currentMonth = (int) date('m');
        $expYear = (int) $cardData['exp_year'];
        $expMonth = (int) $cardData['exp_month'];

        if ($expYear < $currentYear || ($expYear === $currentYear && $expMonth < $currentMonth)) {
            return false;
        }

        return true;
    }

    /**
     * Validate a credit card number using the Luhn algorithm
     *
     * @param string $cardNumber
     * @return bool
     */
    protected function validateCardNumber(string $cardNumber): bool
    {
        // Remove spaces and dashes
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        
        // Check if the number contains only digits
        if (!ctype_digit($cardNumber)) {
            return false;
        }
        
        // Implement the Luhn algorithm check
        $sum = 0;
        $length = strlen($cardNumber);
        
        for ($i = 0; $i < $length; $i++) {
            $digit = (int) $cardNumber[$length - $i - 1];
            if ($i % 2 == 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }
        
        return ($sum % 10) == 0;
    }
}