<?php
/**
 * maxiPago!
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 */

/**
 * maxiPago! Payment Method
 *
 * @package    maxiPago!
 * @author     Bizcommerce
 * @copyright  Copyright (c) 2016 BizCommerce
 *
 * @property ModelCheckoutOrder model_checkout_order
 */

require_once(DIR_SYSTEM . 'library/maxipago/maxipago.php');
class ModelExtensionPaymentMaxipago extends Model
{
    protected $_maxipago;

    const DEFAULT_IP = '127.0.0.1';
    const MAXIPAGO_CODE = 'maxipago';

    protected $_countryCodes = array(
        'AD' => '376',
        'AE' => '971',
        'AF' => '93',
        'AG' => '1268',
        'AI' => '1264',
        'AL' => '355',
        'AM' => '374',
        'AN' => '599',
        'AO' => '244',
        'AQ' => '672',
        'AR' => '54',
        'AS' => '1684',
        'AT' => '43',
        'AU' => '61',
        'AW' => '297',
        'AZ' => '994',
        'BA' => '387',
        'BB' => '1246',
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BL' => '590',
        'BM' => '1441',
        'BN' => '673',
        'BO' => '591',
        'BR' => '55',
        'BS' => '1242',
        'BT' => '975',
        'BW' => '267',
        'BY' => '375',
        'BZ' => '501',
        'CA' => '1',
        'CC' => '61',
        'CD' => '243',
        'CF' => '236',
        'CG' => '242',
        'CH' => '41',
        'CI' => '225',
        'CK' => '682',
        'CL' => '56',
        'CM' => '237',
        'CN' => '86',
        'CO' => '57',
        'CR' => '506',
        'CU' => '53',
        'CV' => '238',
        'CX' => '61',
        'CY' => '357',
        'CZ' => '420',
        'DE' => '49',
        'DJ' => '253',
        'DK' => '45',
        'DM' => '1767',
        'DO' => '1809',
        'DZ' => '213',
        'EC' => '593',
        'EE' => '372',
        'EG' => '20',
        'ER' => '291',
        'ES' => '34',
        'ET' => '251',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'FR' => '33',
        'GA' => '241',
        'GB' => '44',
        'GD' => '1473',
        'GE' => '995',
        'GH' => '233',
        'GI' => '350',
        'GL' => '299',
        'GM' => '220',
        'GN' => '224',
        'GQ' => '240',
        'GR' => '30',
        'GT' => '502',
        'GU' => '1671',
        'GW' => '245',
        'GY' => '592',
        'HK' => '852',
        'HN' => '504',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'ID' => '62',
        'IE' => '353',
        'IL' => '972',
        'IM' => '44',
        'IN' => '91',
        'IQ' => '964',
        'IR' => '98',
        'IS' => '354',
        'IT' => '39',
        'JM' => '1876',
        'JO' => '962',
        'JP' => '81',
        'KE' => '254',
        'KG' => '996',
        'KH' => '855',
        'KI' => '686',
        'KM' => '269',
        'KN' => '1869',
        'KP' => '850',
        'KR' => '82',
        'KW' => '965',
        'KY' => '1345',
        'KZ' => '7',
        'LA' => '856',
        'LB' => '961',
        'LC' => '1758',
        'LI' => '423',
        'LK' => '94',
        'LR' => '231',
        'LS' => '266',
        'LT' => '370',
        'LU' => '352',
        'LV' => '371',
        'LY' => '218',
        'MA' => '212',
        'MC' => '377',
        'MD' => '373',
        'ME' => '382',
        'MF' => '1599',
        'MG' => '261',
        'MH' => '692',
        'MK' => '389',
        'ML' => '223',
        'MM' => '95',
        'MN' => '976',
        'MO' => '853',
        'MP' => '1670',
        'MR' => '222',
        'MS' => '1664',
        'MT' => '356',
        'MU' => '230',
        'MV' => '960',
        'MW' => '265',
        'MX' => '52',
        'MY' => '60',
        'MZ' => '258',
        'NA' => '264',
        'NC' => '687',
        'NE' => '227',
        'NG' => '234',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'NZ' => '64',
        'OM' => '968',
        'PA' => '507',
        'PE' => '51',
        'PF' => '689',
        'PG' => '675',
        'PH' => '63',
        'PK' => '92',
        'PL' => '48',
        'PM' => '508',
        'PN' => '870',
        'PR' => '1',
        'PT' => '351',
        'PW' => '680',
        'PY' => '595',
        'QA' => '974',
        'RO' => '40',
        'RS' => '381',
        'RU' => '7',
        'RW' => '250',
        'SA' => '966',
        'SB' => '677',
        'SC' => '248',
        'SD' => '249',
        'SE' => '46',
        'SG' => '65',
        'SH' => '290',
        'SI' => '386',
        'SK' => '421',
        'SL' => '232',
        'SM' => '378',
        'SN' => '221',
        'SO' => '252',
        'SR' => '597',
        'ST' => '239',
        'SV' => '503',
        'SY' => '963',
        'SZ' => '268',
        'TC' => '1649',
        'TD' => '235',
        'TG' => '228',
        'TH' => '66',
        'TJ' => '992',
        'TK' => '690',
        'TL' => '670',
        'TM' => '993',
        'TN' => '216',
        'TO' => '676',
        'TR' => '90',
        'TT' => '1868',
        'TV' => '688',
        'TW' => '886',
        'TZ' => '255',
        'UA' => '380',
        'UG' => '256',
        'US' => '1',
        'UY' => '598',
        'UZ' => '998',
        'VA' => '39',
        'VC' => '1784',
        'VE' => '58',
        'VG' => '1284',
        'VI' => '1340',
        'VN' => '84',
        'VU' => '678',
        'WF' => '681',
        'WS' => '685',
        'XK' => '381',
        'YE' => '967',
        'YT' => '262',
        'ZA' => '27',
        'ZM' => '260',
        'ZW' => '263'
    );

    protected $_responseCodes = array(
        '0' => 'Pagamento Aprovado',
        '1' => 'Pagamento Reprovado',
        '2' => 'Pagamento Reprovado',
        '5' => 'Pagamento em análise',
        '1022' => 'Ocorreu um erro com a finalizadora, entre em contato com nossa equipe',
        '1024' => 'Erros, dados enviados inválidos, entre em contato com nossa equipe',
        '1025' => 'Erro nas credenciais de envio, entre em contato com nossa equipe',
        '2048' => 'Erro interno, entre em contato com nossa equipe',
        '4097' => 'Erro de tempo de execução, entre em contato com nossa equipe'
    );

    protected $_transactionStates = array(
        '1' => 'In Progress',
        '3' => 'Captured',
        '6' => 'Authorized',
        '7' => 'Declined',
        '9' => 'Voided',
        '10' => 'Paid',
        '22' => 'Boleto Issued',
        '34' => 'Boleto Viewed',
        '35' => 'Boleto Underpaid',
        '36' => 'Boleto Overpaid',

        '4' => 'Pending Capture',
        '5' => 'Pending Authorization',
        '8' => 'Reversed',
        '11' => 'Pending Confirmation',
        '12' => 'Pending Review (check with Support)',
        '13' => 'Pending Reversion',
        '14' => 'Pending Capture (retrial)',
        '16' => 'Pending Reversal',
        '18' => 'Pending Void',
        '19' => 'Pending Void (retrial)',
        '29' => 'Pending Authentication',
        '30' => 'Authenticated',
        '31' => 'Pending Reversal (retrial)',
        '32' => 'Authentication in progress',
        '33' => 'Submitted Authentication',
        '38' => 'File submission pending Reversal',
        '44' => 'Fraud Approved',
        '45' => 'Fraud Declined',
        '46' => 'Fraud Review'
    );

    /**
     * maxiPago! lib Object
     * @return MaxiPago
     */
    public function getMaxipago()
    {
        if (!$this->_maxipago) {
            $merchantId = $this->config->get('maxipago_store_id');
            $sellerKey = $this->config->get('maxipago_consumer_key');
            if ($merchantId && $sellerKey) {
                $environment = ($this->config->get('maxipago_environment') == 'test') ? 'TEST' : 'LIVE';
                $this->_maxipago = new maxiPagoPayment();
                $this->_maxipago->setCredentials($merchantId, $sellerKey);
                $this->_maxipago->setEnvironment($environment);
            }
        }

        return $this->_maxipago;

    }

    public function recurringPayments() {
        $recurring_products = $this->cart->getRecurringProducts();

        foreach($recurring_products as $recurring_product)
        {
            $has_trial = $recurring_product['recurring']['trial'] == "1";
            $trial_is_paid = ((float) $recurring_product['recurring']['trial_price']) > 0;


            /*
             * maxiPago! doesn't support recurring payments with paid trials
             */
            if($has_trial && $trial_is_paid)
                return false;
        }

        return true;
    }

    public function getMethod($address, $total)
    {
        $this->load->language('extension/payment/maxipago');

        $query = $this->db->query("
          SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone 
          WHERE geo_zone_id = '" . (int)$this->config->get('maxipago_geo_zone_id') . "' 
          AND country_id = '" . (int)$address['country_id'] . "' 
          AND (
            zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0'
          )"
        );

        if ($this->config->get('maxipago_maximum_amount') > 0 && $this->config->get('maxipago_maximum_amount') <= $total) {
            $status = false;
        } elseif ($this->config->get('maxipago_minimum_amount') > 0 && $this->config->get('maxipago_minimum_amount') > $total) {
            $status = false;
        } elseif (!$this->config->get('maxipago_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();
        if ($status) {
            $method_data = array(
                'code' => self::MAXIPAGO_CODE,
                'title' => ($this->config->get(self::MAXIPAGO_CODE . '_method_title')) ? $this->config->get(self::MAXIPAGO_CODE . '_method_title') : $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('maxipago_sort_order')
            );
        }

        return $method_data;
    }

    /**
     * Remove the Credit Card frm maxiPago! Account and remove from the store Account
     *
     * @param $ccSaved
     * @return bool
     */
    public function deleteCC($ccSaved)
    {
        try {
            $data = array(
                'command' => 'delete-card-onfile',
                'customerId' => $ccSaved['id_customer'],
                'token' => $ccSaved['token']
            );

            $this->getMaxipago()->deleteCreditCard($data);
            $response = $this->getMaxipago()->response;
            $this->_saveTransaction('remove_card', $data, $response, null, false);

            $sql = 'DELETE FROM `' . DB_PREFIX . 'maxipago_cc_token` WHERE `id` = \'' . $ccSaved['id'] . '\';';
            $this->db->query($sql);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Send the ticket Payment method do maxiPago!
     *
     * @param $order_info
     * @return boolean
     */
    public function ticketMethod($order_info)
    {
        //Language
        $this->language->load('extension/payment/maxipago');
        $response = null;

        //Boleto
        $methodEnabled = $this->config->get('maxipago_ticket_enabled');
        if ($methodEnabled) {

            //Order Data
            $totalOrder = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

            $shippingTotal = $this->getOrderShippingValue($order_info['order_id']);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');

            $orderId   = $this->session->data['order_id'];
            $ipAddress = $this->validateIP($order_info['ip']);
            $address = $this->_getAddress($order_info);
            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];
            $customerId = $order_info['customer_id'];

            $cpf = $this->getPost('ticket_cpf');
            $environment = $this->config->get('maxipago_environment');

            $dayToExpire = (int) $this->config->get('maxipago_ticket_days_to_expire');
            $instructions = $this->config->get('maxipago_ticket_instructions');

            $date = new DateTime();
            $date->modify('+' . $dayToExpire . ' days');
            $expirationDate = $date->format('Y-m-d');

            $boletoBank = ($environment == 'test') ? 12 : $this->config->get('maxipago_ticket_bank');

            $data = array(
                'referenceNum' => $orderId, //Order ID
                'processorID' => $boletoBank, //Bank Number
                'ipAddress' => $ipAddress,
                'chargeTotal' => $totalOrder,
                'shippingTotal' => $shippingTotal,
                'expirationDate' => $expirationDate,
                'customerIdExt' => $cpf,
                'number' => $orderId, //Our Number
                'instructions' => $instructions, //Instructions,
                'phone' => $address['telephone'],
                'billingId' => ($customerId) ? $customerId : $order_info['email'],
                'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'billingAddress' => $billingAddress['address1'],
                'billingAddress2' => $billingAddress['address2'],
                'billingCity' => $billingAddress['city'],
                'billingState' => $billingAddress['state'],
                'billingPostalCode' => $billingAddress['postcode'],
                'billingPhone' => $address['telephone'],
                'billingEmail' => $order_info['email'],
                'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                'shippingAddress' => $shippingAddress['address1'],
                'shippingAddress2' => $shippingAddress['address2'],
                'shippingCity' => $shippingAddress['city'],
                'shippingState' => $shippingAddress['state'],
                'shippingPostalCode' => $shippingAddress['postcode'],
                'shippingPhone' => $address['telephone'],
                'shippingEmail' => $order_info['email'],
                'bname' => $order_info['firstname'] . ' ' . $order_info['lastname'],
                'baddress' => $billingAddress['address1'],
                'baddress2' => $billingAddress['address2'],
                'bcity' => $billingAddress['city'],
                'bstate' => $billingAddress['state'],
                'bpostalcode' => $billingAddress['postcode'],
                'bcountry' => $billingAddress['country'],
                'bemail' => $order_info['email'],
            );


            $this->getMaxipago()->boletoSale($data);
            $response = $this->getMaxipago()->response;

            $this->log($this->getMaxipago()->xmlRequest);
            $this->log($this->getMaxipago()->xmlResponse);

            $boletoUrl = isset($response['boletoUrl']) ? $response['boletoUrl'] : null;
            $this->_saveTransaction('ticket', $data, $response, $boletoUrl);

        }
        return $response;

    }

    /**
     * Send the payment method Credit Card to maxiPago!
     *
     * @param $order_info
     * @return boolean
     */
    public function cardMethod($order_info)
    {
        $methodEnabled = $this->config->get('maxipago_cc_enabled');
        $response = null;

        if ($methodEnabled) {

            //Order Data
            $totalOrder = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $order_id = $this->session->data['order_id'];

            $softDescriptor = $this->config->get('maxipago_cc_soft_descriptor');
            $processingType = $this->config->get('maxipago_cc_processing_type'); //auth || sale

            $fraudCheck = ($this->config->get('maxipago_cc_fraud_check')) ? 'Y' : 'N';
            $fraudCheck = $processingType != 'sale' ? $fraudCheck : 'N';

            $maxWithoutInterest = (int) $this->config->get('maxipago_cc_installments_without_interest');
            $interestRate = $this->config->get('maxipago_cc_interest_rate');
            $hasInterest = 'N';

            $customerId = $order_info['customer_id'];
            $firstname = $order_info['firstname'];
            $lastname = $order_info['lastname'];

            $ccBrand = $this->getPost('cc_brand');
            $ccNumber = $this->getPost('cc_number');
            $ccOwner = $this->getPost('cc_owner');
            $ccExpMonth = $this->getPost('cc_expire_date_month');
            $ccExpYear = $this->getPost('cc_expire_date_year');
            $ccCvv2 = $this->getPost('cc_cvv2');
            $ccInstallments = $this->getPost('cc_installments');

            $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $this->validateIP($_SERVER['REMOTE_ADDR']) : self::DEFAULT_IP;
            $address = $this->_getAddress($order_info);
            $order_data = $this->getOrderData();

            if ($interestRate && $ccInstallments > $maxWithoutInterest) {
                $hasInterest = 'Y';
                $totalOrder = $this->getTotalByInstallments($totalOrder, $ccInstallments, $interestRate);
            }

            $shippingTotal = $this->getOrderShippingValue($order_id);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');

            $ccSavedCard = $this->getPost('cc_saved_card');
            $phone = $address['telephone'];

            if ($ccSavedCard) {
                $ccCvvSaved = $this->getPost('cc_cvv2_saved');

                $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_cc_token
                        WHERE `id_customer` = \'' . $customerId . '\'
                        AND `description` = \'' . $ccSavedCard . '\'
                        LIMIT 1; ';
                $maxipagoToken = $this->db->query($sql)->row;

                $processorID =  $this->config->get('maxipago_' . $maxipagoToken['brand'] . '_processor');

                $data = array(
                    'customerId' => $maxipagoToken['id_customer_maxipago'],
                    'token' => $maxipagoToken['token'],
                    'cvvNumber' => $ccCvvSaved,
                    'referenceNum' => $order_id, //Order ID
                    'processorID' => $processorID, //Processor
                    'ipAddress' => $ipAddress,
                    'fraudCheck' => 'N',
                    'currencyCode' => $order_info['currency_code'],
                    'chargeTotal' => $totalOrder,
                    'shippingTotal' => $shippingTotal,
                    'numberOfInstallments' => $ccInstallments,
                    'chargeInterest' => $hasInterest,
                    'phone' => $address['telephone']
                );

            } else {

                $processorID =  $this->config->get('maxipago_' . $ccBrand . '_processor');

                $data = array(
                    'referenceNum' => $order_id, //Order ID
                    'processorID' => $processorID, //Processor
                    'ipAddress' => $ipAddress,
                    'fraudCheck' => $fraudCheck,
                    'number' => $ccNumber,
                    'expMonth' => $ccExpMonth,
                    'expYear' => $ccExpYear,
                    'cvvNumber' => $ccCvv2,
                    'currencyCode' => $order_info['currency_code'],
                    'chargeTotal' => $totalOrder,
                    'shippingTotal' => $shippingTotal,
                    'numberOfInstallments' => $ccInstallments,
                    'chargeInterest' => $hasInterest,
                    'phone' => $address['telephone']
                );

                $ccSaveCard = $this->getPost('cc_save_card');
                if ($ccSaveCard) {
                    $this->saveCard($order_info);
                }
            }

            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];

            $address_data = array(
                'billingId' => ($customerId) ? $customerId : $order_info['email'],
                'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'billingAddress' => $billingAddress['address1'],
                'billingAddress2' => $billingAddress['address2'],
                'billingDistrict' =>  isset($order_info['district']) ? $order_info['district'] : 'N/A',
                'billingCity' => $billingAddress['city'],
                'billingState' => $billingAddress['state'],
                'billingPostalCode' => $billingAddress['postcode'],
                'billingCountry' => $billingAddress['country'],
                'billingPhone' => $phone,
                'billingEmail' => $order_info['email'],
                'billingBirthDate' => isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01',
                'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                'shippingAddress' => $shippingAddress['address1'],
                'shippingAddress2' => $shippingAddress['address2'],
                'shippingDistrict' => isset($order_info['district']) ? $order_info['district'] : 'N/A',
                'shippingCity' => $shippingAddress['city'],
                'shippingState' => $shippingAddress['state'],
                'shippingPostalCode' => $shippingAddress['postcode'],
                'shippingCountry' => $shippingAddress['country'],
                'shippingPhone' => $phone,
                'shippingEmail' => $order_info['email'],
                'shippingBirthDate' => isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01'
            );

            $documentNumber = $this->getPost('cc_cpf');
            $customerType = 'Individual';
            $documentType = 'CPF';

            $documentNumber = $this->clean_number($documentNumber);
            if (strlen($documentNumber) == '14') {
                $customerType = 'Legal entity';
                $documentType = 'CNPJ';
            }

            $data['customerIdExt'] = $documentNumber;

            $data['billingType'] = $customerType;//'Legal entity'
            $data['billingDocumentType'] = $documentType;
            $data['billingDocumentValue'] = $documentNumber;

            $data['shippingType'] = $customerType;//'Legal entity'
            $data['shippingDocumentType'] = $documentType;
            $data['shippingDocumentValue'] = $documentNumber;

            if ($phone) {
                $data['billingPhoneType'] = 'Mobile';
                $data['billingCountryCode'] = $this->getCountryCode();
                $data['billingPhoneAreaCode'] = $this->getAreaNumber($phone);
                $data['billingPhoneNumber'] = $this->getPhoneNumber($phone);

                $data['shippingPhoneType'] = 'Mobile';
                $data['shippingCountryCode'] = $this->getCountryCode();
                $data['shippingPhoneAreaCode'] = $this->getAreaNumber($phone);
                $data['shippingPhoneNumber'] = $this->getPhoneNumber($phone);
            }

            $data = array_merge($data, $order_data, $address_data);

            if ($processingType == 'auth') {

                $fraud_processor = $this->config->get('maxipago_cc_fraud_processor');
                if ($fraud_processor) {
                    $data['fraudProcessorID'] = $fraud_processor;

                    $data['captureOnLowRisk'] = $this->config->get('maxipago_cc_auto_capture');
                    $data['voidOnHighRisk'] = $this->config->get('maxipago_cc_auto_void');

                    if ($fraud_processor == '98') {
                        $sessionId = session_id();
                        $data['fraudToken'] = $sessionId;
                    } else if ($fraud_processor == '99') {
                        $merchantId = $this->config->get('maxipago_store_id');
                        $merchantSecret = $this->config->get('maxipago_secret_key');
                        $hash = hash_hmac('md5', $merchantId . '*' . $order_id, $merchantSecret);
                        $data['fraudToken'] = $hash;
                    }
                    $data['websiteId'] = 'DEFAULT';
                }

                $this->getMaxipago()->creditCardAuth($data);
            } else {
                $this->getMaxipago()->creditCardSale($data);
            }

            $response = $this->getMaxipago()->response;

            $xmlRequest = $this->getMaxipago()->xmlRequest;
            $xmlRequest = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $xmlRequest);
            $xmlRequest = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $xmlRequest);
            $xmlRequest = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $xmlRequest);
            $this->log($xmlRequest);
            $this->log($this->getMaxipago()->xmlResponse);

            $this->_saveTransaction('card', $data, $response);

        }
        return $response;

    }

    public function recurringMethod($order_data, $recurring_data)
    {
        $methodEnabled = $this->config->get('maxipago_cc_enabled');

        if(!$methodEnabled) {
            $this->load->language('extension/payment/maxipago');
            throw new Exception($this->language->get('exception_method_not_allowed'));
        }

        $recurring = $recurring_data['recurring'];

        $reference_number = $order_data['order_id'];
        $ip_address = $order_data['ip'];
        $currency_code = $order_data['currency_code'];
        $document = $this->getPost('cc_cpf');

        $charge_total = (float) $recurring['price'];
        $formated_charge_total = number_format($charge_total, 2, '.', '');

        $shippingTotal = $this->getOrderShippingValue($order_data['order_id']);
        $shippingTotal = number_format($shippingTotal, 2, '.', '');

        $request_data = array(
            'referenceNum' => $reference_number,
            'ipAddress' => $ip_address,
            'customerIdExt' => $document,
            'currencyCode' => $currency_code,
            'chargeTotal' => $formated_charge_total,
            'shippingTotal' => $shippingTotal
        );

        $using_saved_cc = $this->getPost('cc_saved_card');

        if ($using_saved_cc) {
            $request_data['customerId'] = $order_data['customer_id'];

            $saved_cvv = $this->getPost('cc_cvv2_saved');
            $request_data['cvvNumber'] = $saved_cvv;

            $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_cc_token
                        WHERE `id_customer` = \'' . $order_data['customer_id'] . '\'
                        AND `description` = \'' . $using_saved_cc . '\'
                        LIMIT 1; ';
            $maxipago_token = $this->db->query($sql)->row;
            $request_data['token'] = $maxipago_token['token'];

            $processor_id =  $this->config->get('maxipago_' . $maxipago_token['brand'] . '_processor');
            $request_data['processorID'] = $processor_id;
        } else {
            $request_data['customerId'] = $order_data['customer_id'];

            $cc_brand = $this->getPost('cc_brand');
            $processor_id =  $this->config->get('maxipago_' . $cc_brand . '_processor');
            $request_data['processorID'] = $processor_id;

            $expiration_month = $this->getPost('cc_expire_date_month');
            $request_data['expMonth'] = $expiration_month;

            $xpiration_year = $this->getPost('cc_expire_date_year');
            $request_data['expYear'] = $xpiration_year;

            $cc_number = $this->getPost('cc_number');
            $request_data['number'] = $cc_number;

            $cc_cvv = $this->getPost('cc_cvv2');
            $request_data['cvvNumber'] = $cc_cvv;

            $save_card = $this->getPost('cc_save_card');
            if ($save_card) {
                $this->saveCard($order_data);
            }
        }

        $has_trial = $recurring['trial'] == "1";
        $trial_is_paid = $has_trial ? ((float) $recurring['trial_price']) > 0 : false;

        if($has_trial && $trial_is_paid)
            throw new Exception($this->language->get('exception_recurrency_not_supported'));

        if($has_trial)
        {
            $frequencyFromMaxiPagoToOpenCart = array(
                'daily' => 'day',
                'weekly' => 'week',
                'monthly' => 'month'
            );

            $frequency = $this->getFrequencyFromCycle($recurring['cycle'], $recurring['frequency']);
            $request_data['frequency'] = $frequency;

            $period = $this->getPeriodFromFrequency($recurring['frequency']);
            $request_data['period'] = $period;

            $trial_frequency = $this->getFrequencyFromCycle($recurring['trial_cycle'], $recurring['trial_frequency']);
            $trial_period = $this->getPeriodFromFrequency($recurring['trial_frequency']);

            $start_date = new DateTime('today');
            $start_date->modify('+' . $trial_frequency . ' ' . $frequencyFromMaxiPagoToOpenCart[$trial_period]);
            $start_date = $start_date->format('Y-m-d');
            $request_data['startDate'] = $start_date;

            $installments = $this->getRecurringInstallments($recurring['duration'], $period, $frequency);
            $request_data['installments'] = $installments;

            $failure_threshold = $installments > 99 ? 99 : $installments;
            $request_data['failureThreshold'] = $failure_threshold;
        } else
        {
            $start_date = new DateTime('today');
            $start_date = $start_date->format('Y-m-d');
            $request_data['startDate'] = $start_date;

            $frequency = $this->getFrequencyFromCycle($recurring['cycle'], $recurring['frequency']);
            $request_data['frequency'] = $frequency;

            $period = $this->getPeriodFromFrequency($recurring['frequency']);
            $request_data['period'] = $period;

            $installments = $this->getRecurringInstallments($recurring['duration'], $period, $frequency);
            $request_data['installments'] = $installments;

            $failure_threshold = $installments > 99 ? 99 : $installments;
            $request_data['failureThreshold'] = $failure_threshold;
        }

        $address = $this->_getAddress($order_data);
        $billingAddress = $address['billing'];
        $shippingAddress = $address['shipping'];

        $district = isset($order_data['district']) ? $order_data['district'] : 'N/A';
        $birthdate = isset($order_data['birthdate']) ? $order_data['birthdate'] : '1990-01-01';
        $gender = isset($order_data['gender']) ? $order_data['gender'] : 'M';

        $request_data['billingId'] = $order_data['customer_id'];
        $request_data['billingName'] = $billingAddress['firstname'] . ' ' . $billingAddress['lastname'];
        $request_data['billingAddress'] = $billingAddress['address1'];
        $request_data['billingAddress1'] = $billingAddress['address1'];
        $request_data['billingAddress2'] = $billingAddress['address2'];
        $request_data['billingDistrict'] = $district;
        $request_data['billingCity'] = $billingAddress['city'];
        $request_data['billingState'] = $billingAddress['state'];
        $request_data['billingZip'] = $billingAddress['postcode'];
        $request_data['billingPostalCode'] = $billingAddress['postcode'];
        $request_data['billingCountry'] = $billingAddress['country'];
        $request_data['billingEmail'] = $order_data['email'];
        $request_data['billingBirthDate'] = $birthdate;
        $request_data['billingGender'] = $gender;
        $request_data['billingPhone'] = $address['telephone'];

        $request_data['shippingId'] = $order_data['customer_id'];
        $request_data['shippingName'] = $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'];
        $request_data['shippingAddress'] = $shippingAddress['address1'];
        $request_data['shippingAddress1'] = $shippingAddress['address1'];
        $request_data['shippingAddress2'] = $shippingAddress['address2'];
        $request_data['shippingDistrict'] = $district;
        $request_data['shippingCity'] = $shippingAddress['city'];
        $request_data['shippingState'] = $shippingAddress['state'];
        $request_data['shippingZip'] = $shippingAddress['postcode'];
        $request_data['shippingPostalCode'] = $shippingAddress['postcode'];
        $request_data['shippingCountry'] = $shippingAddress['country'];
        $request_data['shippingEmail'] = $order_data['email'];
        $request_data['shippingBirthDate'] = $birthdate;
        $request_data['shippingGender'] = $gender;
        $request_data['shippingPhone'] = $address['telephone'];

        $this->getMaxipago()->createRecurring($request_data);
        $response = $this->getMaxipago()->response;

        $xmlRequest = $this->getMaxipago()->xmlRequest;
        $xmlRequest = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $xmlRequest);
        $xmlRequest = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $xmlRequest);
        $xmlRequest = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $xmlRequest);
        $this->log($xmlRequest);
        $this->log($this->getMaxipago()->xmlResponse);

        $this->_saveRecurringTransaction($order_data['order_id'], $recurring_data['recurring']['order_recurring_id'], $request_data, $response);
        return $response;
    }

    private function getFrequencyFromCycle($cycle, $frequency)
    {
        $multiplier = 1;

        if($frequency == 'semi_month')
            $multiplier = 15;

        if($frequency == 'year')
            $multiplier = 12;

        return $cycle * $multiplier;
    }

    private function getPeriodFromFrequency($frequency)
    {
        $frequencyFromOpenCartToMaxiPago = array(
            'day' => 'daily',
            'week' => 'weekly',
            'semi_month' => 'daily',
            'month' => 'monthly',
            'year' => 'monthly'
        );

        if(isset($frequencyFromOpenCartToMaxiPago[$frequency]))
            return $frequencyFromOpenCartToMaxiPago[$frequency];

        return 'monthly';
    }

    private function getRecurringInstallments($duration, $period, $frequency)
    {
        if($duration > 0)
            return $duration;

        // 1825 days is the same as 5 years
        if($period == 'daily')
            return (int) (1825 / $frequency);

        // 260 weeks is the same as 5 years
        if($period == 'weekly')
            return (int) (260 / $frequency);

        // 60 months is the same as 5 years
        if($period == 'monthly')
            return (int) (60 / $frequency);

        return 0; // Shall thrown error for invalid
    }

    protected function _saveRecurringTransaction($order_id, $order_recurring_id, $request, $response)
    {
        $maxipago_order_id = '';
        if(isset($response['orderID']))
            $maxipago_order_id = $this->db->escape($response['orderID']);

        $maxipago_status = '';
        if(isset($response['responseMessage']))
            $maxipago_status = $this->db->escape($response['responseMessage']);

        if(isset($request['number']))
            $request['number'] = substr($request['number'], 0, 6) . 'XXXXXX' . substr($request['number'], -4, 4);

        if(isset($request['token']))
            $request['token'] = 'XXXXXXXXXXXX';

        if(isset($request['cvv']))
            $request['cvv'] = 'XXX';

        if(isset($request['cvvNumber']))
            $request['cvvNumber'] = 'XXX';

        if(isset($request['creditCardData']))
            unset($request['creditCardData']);

        $request = $this->db->escape(json_encode($request));
        $response = $this->db->escape(json_encode($response));

        $sql = 'INSERT INTO `' . DB_PREFIX . 'maxipago_recurring_transactions` 
                    (`order_id`, `order_recurring_id`, `maxipago_order_id`, `maxipago_status`, `request`, `response`, `created_at`)
                VALUES
                    ("' . $order_id . '", "' . $order_recurring_id . '",  "' . $maxipago_order_id . '", "' . $maxipago_status . '", "' . $request . '", "' . $response . '", NOW() )';

        $this->db->query($sql);
    }


    public function voidOrder($order_id)
    {
        $this->voidAllOrderPayments($order_id);
        $this->voidAllOrderRecurringPayments($order_id);
    }

    public function voidAllOrderRecurringPayments($order_id)
    {
        try
        {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_recurring_transactions
                    WHERE `order_id` = "' . $order_id . '"';

            $transactions = $this->db->query($sql)->rows;

            if(!empty($transactions))
            {
                foreach($transactions as $transaction)
                {
                    $response = json_decode($transaction['response']);

                    $data = array(
                        'transactionID' => $response->transactionID
                    );

                    $this->getMaxipago()->creditCardVoid($data);
                }

                $this->_updateRecurringTransactionsState($order_id);
            }

        } catch (Exception $e)
        {
            $this->log('Error voiding order ' . $order_id . ': ' . $e->getMessage());
        }
    }

    public function voidAllOrderPayments($order_id)
    {
        try
        {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "credit-card"';

            $transaction = $this->db->query($sql)->row;

            if(!empty($transaction))
            {
                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'transactionID' => $response->transactionID
                );

                $this->getMaxipago()->creditCardVoid($data);
                $this->_updateTransactionState($order_id);
            }

        } catch (Exception $e)
        {
            $this->log('Error voiding order ' . $order_id . ': ' . $e->getMessage());
        }
    }

    protected function _updateRecurringTransactionsState($id_order)
    {
        $this->load->language('extension/payment/maxipago');
        $this->load->model('extension/payment/maxipago');

        $sql = 'SELECT * FROM ' . DB_PREFIX . 'maxipago_recurring_transactions
            WHERE `order_id` = "' . $id_order . '"';

        $transactions = $this->db->query($sql)->rows;

        if(!empty($transactions))
        {
            foreach($transactions as $transaction)
            {
                $return = json_decode($transaction['response']);

                $search = array(
                    'orderID' => $return->orderID
                );

                $this->getMaxipago()->pullReport($search);
                $response = $this->getMaxipago()->getReportResult();

                if (! empty($response))
                {
                    $responseCode = isset($response[0]['responseCode']) ? $response[0]['responseCode'] : $return->responseCode;
                    if (! property_exists($return, 'originalResponseCode')) {
                        $return->originalResponseCode = $return->responseCode;
                    }
                    $return->responseCode = $responseCode;

                    if (! property_exists($return, 'originalResponseMessage')) {
                        $return->originalResponseMessage = $return->responseMessage;
                    }
                    $state = isset($response[0]['transactionState']) ? $response[0]['transactionState'] : null;
                    $responseMessage = (array_key_exists($state, $this->_transactionStates)) ? $this->_transactionStates[$state] : $return->responseMessage;
                    $return->responseMessage = $responseMessage;
                    $return->transactionState = $state;
                    $transaction['response_message'] = $responseMessage;

                    $sql = 'UPDATE ' . DB_PREFIX . 'maxipago_recurring_transactions
                                   SET `maxipago_status` = \'' . strtoupper($responseMessage) . '\',
                                       `response` = \'' . json_encode($response[0]) . '\'
                                 WHERE `order_id` = "' . $id_order . '"
                                 and `order_recurring_id` = "' . $transaction['order_recurring_id'] . '"
                                ';

                    $this->db->query($sql);
                }
            }
        }
    }

    public function debitCardMethod($order_info)
    {
        $methodEnabled = $this->config->get('maxipago_dc_enabled');

        if (!$methodEnabled) {
            return array(
                'error' => true,
                'errorMessage' => 'Debit card is not enabled!'
            );
        }

        $request_data = array();

        $reference_number = $order_info['order_id'];
        $request_data['referenceNum'] = $reference_number;

        $ip_address = $order_info['ip'];
        $request_data['ipAddress'] = $ip_address;

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $request_data['userAgent'] = $user_agent;

        $card = array(
            'brand' => $this->getPost('dc_brand'),
            'number' => $this->getPost('dc_number'),
            'expiry' => array(
                'month' => $this->getPost('dc_expiry_month'),
                'year' => $this->getPost('dc_expiry_year')
            ),
            'cvv' => $this->getPost('dc_cvv'),
            'document' => $this->getPost('dc_document')
        );

        $request_data['number'] = $card['number'];
        $request_data['expMonth'] = $card['expiry']['month'];
        $request_data['expYear'] = $card['expiry']['year'];
        $request_data['cvvNumber'] = $card['cvv'];

        $request_data['customerIdExt'] = $card['document'];

        $card_processor = $this->config->get('maxipago_dc_' . strtolower($card['brand']) . '_processor');
        $request_data['processorID'] = $card_processor;

        $address = $this->_getAddress($order_info);
        $billingAddress = $address['billing'];
        $shippingAddress = $address['shipping'];

        $district = isset($order_info['district']) ? $order_info['district'] : 'N/A';
        $birthdate = isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01';
        $gender = isset($order_info['gender']) ? $order_info['gender'] : 'M';

        $request_data['billingId'] = $order_info['customer_id'];
        $request_data['billingName'] = $billingAddress['firstname'] . ' ' . $billingAddress['lastname'];
        $request_data['billingAddress'] = $billingAddress['address1'];
        $request_data['billingAddress1'] = $billingAddress['address1'];
        $request_data['billingAddress2'] = $billingAddress['address2'];
        $request_data['billingDistrict'] = $district;
        $request_data['billingCity'] = $billingAddress['city'];
        $request_data['billingState'] = $billingAddress['state'];
        $request_data['billingZip'] = $billingAddress['postcode'];
        $request_data['billingPostalCode'] = $billingAddress['postcode'];
        $request_data['billingCountry'] = $billingAddress['country'];
        $request_data['billingPhone'] = $address['telephone'];
        $request_data['billingEmail'] = $order_info['email'];
        $request_data['billingBirthDate'] = $birthdate;
        $request_data['billingGender'] = $gender;

        $request_data['shippingId'] = $order_info['customer_id'];
        $request_data['shippingName'] = $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'];
        $request_data['shippingAddress'] = $shippingAddress['address1'];
        $request_data['shippingAddress1'] = $shippingAddress['address1'];
        $request_data['shippingAddress2'] = $shippingAddress['address2'];
        $request_data['shippingDistrict'] = $district;
        $request_data['shippingCity'] = $shippingAddress['city'];
        $request_data['shippingState'] = $shippingAddress['state'];
        $request_data['shippingZip'] = $shippingAddress['postcode'];
        $request_data['shippingPostalCode'] = $shippingAddress['postcode'];
        $request_data['shippingCountry'] = $shippingAddress['country'];
        $request_data['shippingPhone'] = $address['telephone'];
        $request_data['shippingEmail'] = $order_info['email'];
        $request_data['shippingBirthDate'] = $birthdate;
        $request_data['shippingGender'] = $gender;

        $charge_total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $request_data['chargeTotal'] = $charge_total;
        $request_data['currencyCode'] = $order_info['currency_code'];

        $shippingTotal = $this->getOrderShippingValue($order_info['order_id']);
        $shippingTotal = number_format($shippingTotal, 2, '.', '');
        $request_data['shippingTotal'] = $shippingTotal;

        $mpi_processor = $this->config->get('maxipago_dc_mpi_processor');
        $request_data['mpiProcessorID'] = $mpi_processor;

        $failure_action = $this->config->get('maxipago_dc_failure_action');
        $request_data['onFailure'] = $failure_action;

        $soft_descriptor = $this->config->get('maxipago_dc_soft_descriptor');
        if($soft_descriptor)
            $request_data['softDescriptor'] = $soft_descriptor;

        $this->getMaxipago()->saleDebitCard3DS($request_data);
        $response = $this->getMaxipago()->response;

        $xmlRequest = $this->getMaxipago()->xmlRequest;
        $xmlRequest = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $xmlRequest);
        $xmlRequest = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $xmlRequest);
        $xmlRequest = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $xmlRequest);
        $this->log($xmlRequest);
        $this->log($this->getMaxipago()->xmlResponse);

        $authentication_url = isset($response['authenticationURL']) ? $response['authenticationURL'] : null;
        $this->_saveTransaction('debit', $request_data, $response, $authentication_url);
        return $response;
    }

    /**
     * Send the payment method EFT to maxiPago!
     *
     * @param $order_info
     * @return boolean
     */
    public function eftMethod($order_info)
    {
        $response = null;
        $methodEnabled = $this->config->get('maxipago_eft_enabled');

        if ($methodEnabled) {

            //Order Data
            $totalOrder = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

            $shippingTotal = $this->getOrderShippingValue($order_info['order_id']);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');

            $order_id = $this->session->data['order_id'];
            $customerId = $order_info['customer_id'];
            $firstname = $order_info['firstname'];
            $lastname = $order_info['lastname'];

            $environment = $this->config->get('maxipago_environment');

            $tefBank = ($environment == 'test') ? 17 : $this->getPost('eft_bank');
            $cpf = $this->getPost('eft_cpf');
            $ipAddress = isset($_SERVER['SERVER_ADDR']) ? $this->validateIP($_SERVER['SERVER_ADDR']) : self::DEFAULT_IP;

            $address = $this->_getAddress($order_info);
            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];

            $data = array(
                'referenceNum' => $order_id, //Order ID
                'processorID' => $tefBank, //Bank Number
                'ipAddress' => $ipAddress,
                'chargeTotal' => $totalOrder,
                'shippingTotal' => $shippingTotal,
                'customerIdExt' => $cpf,
                'name' => $firstname . ' ' . $lastname,
                'address' => $billingAddress['address1'], //Address 1
                'address2' => $billingAddress['address2'], //Address 2
                'city' => $billingAddress['city'],
                'state' => $billingAddress['state'],
                'postalcode' => $billingAddress['postcode'],
                'country' => $billingAddress['country'],
                'parametersURL' => 'oid=' . $order_id,
                'phone' => $address['telephone'],

                'billingId' => ($customerId) ? $customerId : $order_info['email'],
                'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'billingAddress' => $billingAddress['address1'],
                'billingAddress2' => $billingAddress['address2'],
                'billingCity' => $billingAddress['city'],
                'billingState' => $billingAddress['state'],
                'billingPostalCode' => $billingAddress['postcode'],
                'billingPhone' => $address['telephone'],
                'billingEmail' => $order_info['email'],
                'billingCountry' => $billingAddress['country'],

                'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                'shippingAddress' => $shippingAddress['address1'],
                'shippingAddress2' => $shippingAddress['address2'],
                'shippingCity' => $shippingAddress['city'],
                'shippingState' => $shippingAddress['state'],
                'shippingPostalCode' => $shippingAddress['postcode'],
                'shippingPhone' => $address['telephone'],
                'shippingEmail' => $order_info['email'],
                'shippingCountry' => $shippingAddress['country']
            );

            $this->getMaxipago()->onlineDebitSale($data);
            $response = $this->getMaxipago()->response;

            $this->log($this->getMaxipago()->xmlRequest);
            $this->log($this->getMaxipago()->xmlResponse);

            $onlineDebitUrl = isset($response['onlineDebitUrl']) ? $response['onlineDebitUrl'] : null;
            $this->_saveTransaction('eft', $data, $response, $onlineDebitUrl);

        }

        return $response;

    }

    public function redepayMethod($order_info)
    {
        $methodEnabled = $this->config->get('maxipago_redepay_enabled');

        if (!$methodEnabled) {
            return array(
                'error' => true,
                'errorMessage' => 'Redepay is not enabled!'
            );
        }

        $request_data = array(
            'processorID' => 18,
            'parametersURL' => 'type=redepay'
        );

        $ip_address = $order_info['ip'];
        $request_data['ipAddress'] = $ip_address;

        $document = $this->getPost('redepay_document');
        $request_data['customerIdExt'] = $document;

        $reference_number = $order_info['order_id'];
        $request_data['referenceNum'] = $reference_number;

        $charge_total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $request_data['chargeTotal'] = $charge_total;

        $shipping_total = $this->getOrderShippingValue($order_info['order_id']);
        $shipping_total = $this->currency->format($shipping_total, $order_info['currency_code'], $order_info['currency_value'], false);
        $request_data['shippingTotal'] = $shipping_total;

        $address = $this->_getAddress($order_info);
        $billingAddress = $address['billing'];
        $shippingAddress = $address['shipping'];

        $district = isset($order_info['district']) ? $order_info['district'] : 'N/A';
        $birthdate = isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01';
        $gender = isset($order_info['gender']) ? $order_info['gender'] : 'M';
        $phone = $address['telephone'];

        $request_data['billingId'] = $order_info['customer_id'];
        $request_data['billingName'] = $billingAddress['firstname'] . ' ' . $billingAddress['lastname'];
        $request_data['billingAddress'] = $billingAddress['address1'];
        $request_data['billingAddress1'] = $billingAddress['address1'];
        $request_data['billingAddress2'] = $billingAddress['address2'];
        $request_data['billingDistrict'] = $district;
        $request_data['billingCity'] = $billingAddress['city'];
        $request_data['billingState'] = $billingAddress['state'];
        $request_data['billingZip'] = $billingAddress['postcode'];
        $request_data['billingPostalCode'] = $billingAddress['postcode'];
        $request_data['billingCountry'] = $billingAddress['country'];
        $request_data['billingEmail'] = $order_info['email'];
        $request_data['billingBirthDate'] = $birthdate;
        $request_data['billingGender'] = $gender;
        $request_data['billingPhone'] = $phone;

        $request_data['shippingId'] = $order_info['customer_id'];
        $request_data['shippingName'] = $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'];
        $request_data['shippingAddress'] = $address['address1'];
        $request_data['shippingAddress1'] = $address['address1'];
        $request_data['shippingAddress2'] = $address['address2'];
        $request_data['shippingDistrict'] = $district;
        $request_data['shippingCity'] = $address['city'];
        $request_data['shippingState'] = $address['state'];
        $request_data['shippingZip'] = $address['postcode'];
        $request_data['shippingPostalCode'] = $address['postcode'];
        $request_data['shippingCountry'] = $order_info['payment_iso_code_2'];
        $request_data['shippingEmail'] = $order_info['email'];
        $request_data['shippingBirthDate'] = $birthdate;
        $request_data['shippingGender'] = $gender;
        $request_data['shippingPhone'] = $phone;

        $phone_country_code = $this->getCountryCode($order_info['payment_iso_code_2']);

        if(substr($phone, 0, 2) == $phone_country_code)
            $phone = substr($phone, 2, (strlen($phone) - 2));

        $phone_area_number = $this->getAreaNumber($phone);
        $phone_clear_number = $this->getPhoneNumber($phone);

        $request_data['billingPhoneType'] = 'Mobile';
        $request_data['billingCountryCode'] = $phone_country_code;
        $request_data['billingPhoneAreaCode'] = $phone_area_number;
        $request_data['billingPhoneNumber'] = $phone_clear_number;

        $request_data['shippingPhoneType'] = 'Mobile';
        $request_data['shippingCountryCode'] = $phone_country_code;
        $request_data['shippingPhoneAreaCode'] = $phone_area_number;
        $request_data['shippingPhoneNumber'] = $phone_clear_number;

        $customer_type = 'Individual';
        $customer_document_type = 'CPF';
        $customer_document_number = $this->getPost('redepay_document');
        $customer_document_number = preg_replace('/\D/', '', $customer_document_number);

        if(strlen($customer_document_number) == 14)
        {
            $customer_type = 'Legal entity';
            $customer_document_type = 'CNPJ';
        }

        $request_data['billingType'] = $customer_type;
        $request_data['billingDocumentType'] = $customer_document_type;
        $request_data['billingDocumentValue'] = $customer_document_number;

        $request_data['shippingType'] = $customer_type;
        $request_data['shippingDocumentType'] = $customer_document_type;
        $request_data['shippingDocumentValue'] = $customer_document_number;

        $this->getMaxipago()->redepay($request_data);
        $response = $this->getMaxipago()->response;

        $this->log($this->getMaxipago()->xmlRequest);
        $this->log($this->getMaxipago()->xmlResponse);

        $authentication_url = isset($response['authenticationURL']) ? $response['authenticationURL'] : null;
        $this->_saveTransaction('redepay', $request_data, $response, $authentication_url);
        return $response;
    }

    private function getOrderShippingValue($order_id) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "order_total`
        WHERE `order_id` = " . $order_id . " AND `code` = 'shipping';";
        $query = $this->db->query($sql);
        if ($query->num_rows) {
            return $query->row['value'];
        }
    }

    /**
     * Save the credit card at the database
     * @param $order_info
     * @return null
     */
    public function saveCard($order_info)
    {
        try {
            $this->load->language('extension/payment/maxipago');

            $address = $this->_getAddress($order_info);
            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];

            $customerId = $order_info['customer_id'];
            $document = $this->getPost('cc_cpf');
            $firstname = $order_info['firstname'];
            $lastname = $order_info['lastname'];
            $mpCustomerId = null;

            $ccBrand = $this->getPost('cc_brand');
            $ccNumber = $this->getPost('cc_number');
            $ccExpMonth = $this->getPost('cc_expire_date_month');
            $ccExpYear = $this->getPost('cc_expire_date_year');

            $sql = 'SELECT *
                FROM ' . DB_PREFIX . 'maxipago_cc_token
                WHERE `id_customer` = \'' . $customerId . '\'
                LIMIT 1';
            $mpCustomer = $this->db->query($sql)->row;

            if (!$mpCustomer) {
                $customerData = array(
                    'customerIdExt' => $document,
                    'firstName' => $firstname,
                    'lastName' => $lastname
                );
                $this->getMaxipago()->addProfile($customerData);
                $response = $this->getMaxipago()->response;

                $this->_saveTransaction('add_profile', $customerData, $response, null, false);
                if (isset($response['errorCode']) && $response['errorCode'] == 1) {

                    //Search the table to see if the profile already exists
                    $sql = 'SELECT *
                            FROM ' . DB_PREFIX . 'maxipago_transactions
                            WHERE `method` = \'add_profile\';
                        ';

                    $query = $this->db->query($sql);

                    if ($query->num_rows) {
                        foreach ($query->rows as $row) {
                            $requestRow = json_decode($row['request']);
                            if (property_exists($requestRow, 'customerIdExt') && $requestRow->customerIdExt == $customerId) {
                                $responseRow = json_decode($row['return']);
                                if (property_exists($responseRow, 'result') && property_exists($responseRow->result, 'customerId')) {
                                    $mpCustomerId = $responseRow->result->customerId;
                                }
                            }
                        }
                    }
                } else {
                    $mpCustomerId = $this->getMaxipago()->getCustomerId();
                }

            } else {
                $mpCustomerId = $mpCustomer['id_customer_maxipago'];
            }

            if ($mpCustomerId) {
                $date = new DateTime($ccExpYear . '-' . $ccExpMonth . '-01');
                $date->modify('+1 month');
                $endDate = $date->format('m/d/Y');

                $ccData = array(
                    'customerId' => $mpCustomerId,
                    'creditCardNumber' => $ccNumber,
                    'expirationMonth' => $ccExpMonth,
                    'expirationYear' => $ccExpYear,
                    'billingId' => ($customerId) ? $customerId : $order_info['email'],
                    'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                    'billingAddress' => $billingAddress['address1'],
                    'billingAddress2' => $billingAddress['address2'],
                    'billingCity' => $billingAddress['city'],
                    'billingState' => $billingAddress['state'],
                    'billingPostalCode' => $billingAddress['postcode'],
                    'billingPhone' => $address['telephone'],
                    'billingEmail' => $order_info['email'],
                    'billingCountry' => $billingAddress['country'],
                    'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                    'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                    'shippingAddress' => $shippingAddress['address1'],
                    'shippingAddress2' => $shippingAddress['address2'],
                    'shippingCity' => $shippingAddress['city'],
                    'shippingState' => $shippingAddress['state'],
                    'shippingPostalCode' => $shippingAddress['postcode'],
                    'shippingPhone' => $address['telephone'],
                    'shippingEmail' => $order_info['email'],
                    'shippingCountry' => $shippingAddress['country'],
                    'onFileEndDate' => $endDate,
                    'onFilePermissions' => 'ongoing',
                );

                $this->getMaxipago()->addCreditCard($ccData);
                $token = $this->getMaxipago()->getToken();
                $this->_saveTransaction('save_card', $ccData, $this->getMaxipago()->response, null, false);

                if ($token) {
                    $ccEnc = substr($ccNumber, 0, 6) . 'XXXXXX' . substr($ccNumber, -4, 4);
                    $sql = 'INSERT INTO `' . DB_PREFIX . 'maxipago_cc_token` 
                                (`id_customer`, `id_customer_maxipago`, `brand`, `token`, `description`)
                            VALUES
                                ("' . $customerId . '", "' . $mpCustomerId . '", "' . $ccBrand . '", "' . $token . '", "' . $ccEnc . '" )
                            ';

                    $this->db->query($sql);
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function confirmRecurringPayments()
    {
        $post_data = $this->request->post;

        $this->load->model('checkout/order');

        $statuses = array(
            'processing' => $this->config->get('maxipago_order_processing'),
            'authorized' => $this->config->get('maxipago_order_authorized'),
            'approved' => $this->config->get('maxipago_order_approved')
        );

        $statuses_aux = array(
            $statuses['processing'] => 'PENDING',
            $statuses['authorized'] => 'AUTHORIZED',
            $statuses['approved'] => 'CAPTURED'
        );

        $message = '';
        $status = $statuses['processing'];
        $order_id = $this->session->data['order_id'];

        if(count($post_data) <= 2)
            return array(
                'error' => true,
                'message' => 'Missing information for confirmation'
            );

        for($index = 0; $index < (count($post_data) - 2); $index++)
        {
            // The transactions have already been analyzed, and in this step, every transaction is a success!
            $transaction = $post_data[$index];

            if($transaction['responseMessage'] == 'AUTHORIZED')
                $status = $statuses['authorized'];

            if($transaction['responseMessage'] == 'CAPTURED')
                if($status != $statuses['authorized'])
                    $status = $statuses['approved'];

            $transaction_message = '';
            if($transaction['product_data_type'] == 'common')
            {
                $transaction_message = $this->language->get('common_products_transaction_message');
                $transaction_message = sprintf($transaction_message, count($transaction['product_data']), $transaction['responseMessage']);
            } else if($transaction['product_data_type'] == 'recurring')
            {
                $transaction_message = $this->language->get('recurring_product_transaction_message');
                $transaction_message = sprintf($transaction_message, $transaction['product_data']['name'], $transaction['product_data']['recurring']['name']);
            }
            $message .= '<p>' . $transaction_message . '</p>';

            $mp_order_id = $transaction['orderID'];
            $mp_transaction_id = $transaction['transactionID'];
            $mp_auth_code = $transaction['authCode'];

            $has_aditional_information = $mp_order_id || $mp_transaction_id || $mp_auth_code;

            if($has_aditional_information)
                $message .= '<ul>';

            if ($mp_order_id)
                $message .= '<li>orderID: ' . $mp_order_id . '</li>';

            if ($mp_transaction_id)
                $message .= '<li>transactionID: ' . $mp_transaction_id . '</li>';

            if ($mp_auth_code)
                $message .= '<li>authCode: ' . $mp_auth_code . '</li>';

            if($has_aditional_information)
                $message.= '</ul>';

            if(($index + 1) < (count($post_data) - 2))
                $message .= '<hr />';
        }

        if($status == $statuses['approved'] || $status == $statuses['authorized'])
            $message = $this->language->get('order_cc_text') . ' ' . $statuses_aux[$status] . $message;

        $this->model_checkout_order->addOrderHistory($order_id, $status, $message, true);

        return array(
            'url' => $this->url->link('checkout/success', '', true)
        );
    }

    /**
     * Controller that confirms the payment
     */
    public function confirmPayment()
    {
        $this->load->model('checkout/order');

        $paymentType = $this->getPost('type');
        $responseCode = $this->getPost('responseCode');
        $responseMessage = $this->getPost('responseMessage');
        $message = '';

        $order_id = $this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($order_id);
        $status = isset($order_info['order_status_id']) ? $order_info['order_status_id'] : 1;

        $response = array(
            'error' => true,
            'message' => 'Payment type ' . $paymentType . ' not found'
        );

        $continueUrl = $this->url->link('checkout/success', '', true);

        switch ($responseCode) {
            //Aprovada
            case '0':

                $status = $this->config->get('maxipago_order_processing');
                if ($paymentType == 'eft') {

                    $url = $this->getPost('onlineDebitUrl');
                    $link = '<p><a href="' . $url . '" target="_blank">' . $this->language->get('eft_link_text') . '</a></p>';
                    $message = $this->language->get('order_eft_text') . $link;

                    $orderInfoUrl = $this->url->link('account/order/info') . '&order_id=' . $order_id;

                    $response = array(
                        'error' => false,
                        'url' => $orderInfoUrl
                    );

                } else if ($paymentType == 'ticket') {

                    //Gera o link do boleto da maxiPago! e coloca nos comentários do pedido
                    $url = $this->getPost('boletoUrl');
                    $link = '<p><a href="' . $url . '" target="_blank">' . $this->language->get('ticket_link_text') . '</a></p>';
                    $message = $this->language->get('order_ticket_text') . $link;

                    $orderInfoUrl = $this->url->link('account/order/info') . '&order_id=' . $order_id;

                    $response = array(
                        'error' => false,
                        'url' => $orderInfoUrl
                    );

                } else if ($paymentType == 'dc') {
                    $message = '<p>' . $this->language->get('order_dc_text') . ' ' . $responseMessage . '</p>';

                    if($responseMessage == 'ENROLLED') {
                        $url = $this->getPost('authenticationURL');
                        $link = '<a href="' . $url . '" target="_blank">' . $this->language->get('debit_link_text') . '</a>';
                        $message .= '<p>' . $this->language->get('order_dc_pay') . $link . '</p>';

                        $response = array(
                            'error' => false,
                            'url' => $url
                        );
                    }

                } else if ($paymentType == 'redepay') {
                    $message = '<p>' . $this->language->get('order_redepay_text') . ' ' . $responseMessage . '</p>';

                    $url = $this->getPost('authenticationURL');
                    $link = '<p><a href="' . $url . '" target="_blank">' . $this->language->get('redepay_link_text') . '</a></p>';
                    $message = $this->language->get('order_redepay_pay') . $link;

                    $response = array(
                        'error' => false,
                        'url' => $url
                    );

                } else {

                    $message = '<p>' . $this->language->get('order_cc_text') . ' ' . $responseMessage . '</p>';

                    if ($responseMessage == 'CAPTURED') {
                        $status = $this->config->get('maxipago_order_approved');
                    } else if ($responseMessage == 'AUTHORIZED') {
                        $status = $this->config->get('maxipago_order_authorized');
                    }

                    if ($this->getPost('installments')) {
                        $installments = $this->getPost('installments');
                        $total = $this->getPost('total');
                        $totalFormatted =  $this->currency->format($total, $this->session->data['currency']);
                        $installmentsValue = $this->currency->format(($total / $installments), $this->session->data['currency']);
                        $message .= '<p>Total: ' . $totalFormatted . ' - ' . $installments . 'x de ' . $installmentsValue . '</p>';
                    }

                    $response = array(
                        'error' => false,
                        'url' => $continueUrl
                    );

                }

                if ($this->getPost('orderID')) {
                    $message .= '<p>orderID: ' . $this->getPost('orderID') . '</p>';
                }

                if ($this->getPost('transactionID')) {
                    $message .= '<p>transactionID: ' . $this->getPost('transactionID') . '</p>';
                }

                if ($this->getPost('authCode')) {
                    $message .= '<p>authCode: ' . $this->getPost('authCode') . '</p>';
                }

                break;

            //Cancelado
            case '1':
            case '2':
                $status = $this->config->get('maxipago_order_cancelled');
                $message = $this->language->get('maxipago_order_cancelled');
                $response['message'] = $message;
                break;
            //Erro na transação
            default:
                $message = ($responseCode && isset($this->_responseCodes[$responseCode])) ? $this->_responseCodes[$responseCode] : $this->language->get('order_error');

                if ($this->getPost('errorMessage')) {
                    $message .= '<p>transactionID: ' . $this->getPost('errorMessage') . '</p>';
                    $response['message'] = $this->getPost('errorMessage');
                }
        }

        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $status, $message, true);
        return $response;
    }

    /**
     * @param $order_info
     */
    public function capturePayment($order_info, $order_status_id = null)
    {
        try {
            $order_id = $order_info['order_id'];
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card";';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction) && $transaction['response_message'] != 'CAPTURED') {

                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'orderID' => $response->orderID,
                    'referenceNum' => $response->referenceNum,
                    'chargeTotal' => $request->chargeTotal,
                );
                $this->getMaxipago()->creditCardCapture($data);
                $this->_saveTransaction('capture', $data, $this->getMaxipago()->response, null, false);
                $this->_updateTransactionState($order_id, 'capture');

                return true;
            }

        } catch (Exception $e) {
            $this->log('Error capturing order ' . $order_id . ': ' . $e->getMessage());
        }
        return false;
    }

    public function reverse($order_info)
    {
        try {
            $order_id = $order_info['order_id'];
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card";';

            $date = date('Ymd', strtotime($order_info['date_added']));
            $transaction = $this->db->query($sql)->row;
            $transactionAlreadyCanceled = in_array($transaction['response_message'], array(
                'VOIDED', 'CANCELLED', 'CANCELED', 'FRAUD'
            ));

            if (!empty($transaction) && !$transactionAlreadyCanceled) {
                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'orderID' => $response->orderID,
                    'referenceNum' => $response->referenceNum,
                    'chargeTotal' => $request->chargeTotal,
                );

                if($date == date('Ymd'))
                {
                    $transaction_type = 'voided';
                    $data = array(
                        'transactionID' => $response->transactionID
                    );
                    $this->getMaxipago()->creditCardVoid($data);
                    $this->_updateTransactionState($order_id, array(), array(), 'VOIDED');
                } else
                {
                    $transaction_type = 'refunded';
                    $this->getMaxipago()->creditCardRefund($data);
                    $this->_updateTransactionState($order_id, array(), array(), 'REFUNDED');
                }

                $this->log($this->getMaxipago()->xmlRequest);
                $this->log($this->getMaxipago()->xmlResponse);

                $this->_saveTransaction($transaction_type, $data, $this->getMaxipago()->response, null, false);
                return true;
            }

        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * Refund an order
     * @param $order_info
     * @return bool
     */
    public function reversePayment($order_info)
    {
        try {
            $order_id = $order_info['order_id'];
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card";';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction)) {

                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'orderID' => $response->orderID,
                    'referenceNum' => $response->referenceNum,
                    'chargeTotal' => $request->chargeTotal,
                );

                $this->getMaxipago()->creditCardRefund($data);

                $this->log($this->getMaxipago()->xmlRequest);
                $this->log($this->getMaxipago()->xmlResponse);

                $this->_saveTransaction('refund', $data, $this->getMaxipago()->response, null, false);
                $this->_updateTransactionState($order_id, 'refund');

                return true;
            }

        } catch (Exception $e) {
            $this->log('Error refunding order ' . $order_id . ': ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Refund an order
     * @param $order_info
     * @return bool
     */
    public function voidPayment($order_info)
    {
        try {
            $order_id = $order_info['order_id'];
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card";';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction)) {

                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'transactionID' => $response->transactionID
                );

                $this->getMaxipago()->creditCardVoid($data);
                $this->_saveTransaction('void', $data, $this->getMaxipago()->response, null, false);
                $this->_updateTransactionState($order_id, 'void');

                return true;
            }

        } catch (Exception $e) {
            $this->log('Error refunding order ' . $order_id . ': ' . $e->getMessage());
        }

        return false;
    }

    /**
     * @param $order_info
     * @return array
     * Customer Address
     */
    protected function _getAddress($order_info)
    {
        $billing = array();
        $shipping = array();

        $billing['firstname'] = $order_info['payment_firstname'];
        $billing['lastname'] = $order_info['payment_lastname'];
        $billing['country'] = isset($order_info['payment_iso_code_2']) ? $order_info['payment_iso_code_2'] : 'BR';
        $billing['state'] = $order_info['payment_zone_code'];
        $billing['city'] = $order_info['payment_city'];
        $billing['address1'] = $order_info['payment_address_1'];
        $billing['address2'] = $order_info['payment_address_2'];
        $billing['postcode'] = $this->formatPostCode($order_info['payment_postcode']);

        $shipping['firstname'] = $order_info['shipping_firstname'];
        $shipping['lastname'] = $order_info['shipping_lastname'];
        $shipping['country'] = isset($order_info['shipping_iso_code_2']) ? $order_info['shipping_iso_code_2'] : 'BR';
        $shipping['state'] = $order_info['shipping_zone_code'];
        $shipping['city'] = $order_info['shipping_city'];
        $shipping['address1'] = $order_info['shipping_address_1'];
        $shipping['address2'] = $order_info['shipping_address_2'];
        $shipping['postcode'] = $this->formatPostCode($order_info['shipping_postcode']);

        if(!$this->model_account_custom_field)
            $this->load->model('account/custom_field');

        $customFields = $this->model_account_custom_field->getCustomFields();

        if($customFields) {
            if (isset($order_info['payment_custom_field'])) {
                $billingCustomFields = $order_info['payment_custom_field'];
                $billingAddress2 = $billing['address2'];

                foreach ($customFields as $customField) {
                    if(isset($billingCustomFields[$customField['custom_field_id']])) {
                        $billingAddress2 .= ', ' . $customField['name'] . ' ' . $billingCustomFields[$customField['custom_field_id']];
                    }
                }

                $billing['address2'] = $billingAddress2;
            }

            if (isset($order_info['shipping_custom_field'])) {
                $shippingCustomFields = $order_info['shipping_custom_field'];
                $shippingAddress2 = $shipping['address2'];

                foreach ($customFields as $customField) {
                    if(isset($shippingCustomFields[$customField['custom_field_id']])) {
                        $shippingAddress2 .= ', ' . $customField['name'] . ' ' . $shippingCustomFields[$customField['custom_field_id']];
                    }
                }

                $shipping['address2'] = $shippingAddress2;
            }
        }

        $anyProductRequiresShipping = false;

        foreach($this->cart->getProducts() as $product)
        {
            if($product['shipping'])
            {
                $anyProductRequiresShipping = true;
                break;
            }
        }

        if(!$anyProductRequiresShipping)
            $shipping = $billing;

        return array(
            'billing' => $billing,
            'shipping' => $shipping,
            'telephone' => $this->getFormatedTelephone($order_info['telephone'])
        );
    }

    protected function formatPostCode($postCode)
    {
        $postCode = preg_replace('/[^0-9]/', '', $postCode);
        $postCode = substr($postCode, 0, 5) . '-' . substr($postCode, 5, 3);
        return $postCode;
    }

    protected function getFormatedTelephone($telephone)
    {
        return preg_replace('/[^0-9]/', '', $telephone);
    }

    /**
     * Update Transaction State to maxipago tables
     * @param $id_order
     * @param array $return
     * @param array $response
     * @return void
     */
    protected function _updateTransactionState($id_order, $return = array(), $response = array(), $responseMessage = null)
    {
        $this->load->language('extension/payment/maxipago');
        $this->load->model('extension/payment/maxipago');

        $return = array();
        $response = array();

        if($responseMessage)
        {
            $sql = 'UPDATE ' . DB_PREFIX . 'maxipago_transactions
                    SET `response_message` = \'' . strtoupper($responseMessage) . '\'
                    WHERE `id_order` = "' . $id_order . '";';

            $this->db->query($sql);
        } else
        {
            if (empty($return) ) {
                $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_transactions
                        WHERE `id_order` = "' . $id_order . '" 
                        ';
                $transaction = $this->db->query($sql)->row;
                if (!empty($transaction)) {

                    $return = json_decode($transaction['return']);

                    $search = array(
                        'orderID' => $return->orderID
                    );

                    $this->getMaxipago()->pullReport($search);
                    $response = $this->getMaxipago()->getReportResult();

                    if (! empty($response) ) {
                        $responseCode = isset($response[0]['responseCode']) ? $response[0]['responseCode'] : $return->responseCode;
                        if (! property_exists($return, 'originalResponseCode')) {
                            $return->originalResponseCode = $return->responseCode;
                        }
                        $return->responseCode = $responseCode;

                        if (! property_exists($return, 'originalResponseMessage')) {
                            $return->originalResponseMessage = $return->responseMessage;
                        }
                        $state = isset($response[0]['transactionState']) ? $response[0]['transactionState'] : null;
                        $responseMessage = (array_key_exists($state, $this->_transactionStates)) ? $this->_transactionStates[$state] : $return->responseMessage;
                        $return->responseMessage = $responseMessage;
                        $return->transactionState = $state;
                        $transaction['response_message'] = $responseMessage;

                        $sql = 'UPDATE ' . DB_PREFIX . 'maxipago_transactions 
                               SET `response_message` = \'' . strtoupper($responseMessage) . '\',
                                   `return` = \'' . json_encode($return) . '\',
                             WHERE `id_order` = "' . $id_order . '";
                            ';

                        $this->db->query($sql);

                    }

                }
            }
        }
    }

    /**
     * Save at the DB the data of the transaction and the Boleto URL when the payment is made with boleto
     *
     * @param $method
     * @param $request
     * @param $return
     * @param null $transactionUrl
     * @param boolean $hasOrder
     */
    protected function _saveTransaction($method, $request, $return, $transactionUrl = null, $hasOrder = true)
    {
        $authenticationUrl = null;
        $onlineDebitUrl = null;
        $boletoUrl = null;

        if ($transactionUrl) {
            if (in_array($method, array('dc', 'redepay'))) {
                $authenticationUrl = $transactionUrl;
            } else if ($method == 'eft') {
                $onlineDebitUrl = $transactionUrl;
            } else if ($method == 'ticket') {
                $boletoUrl = $transactionUrl;
            }
        }

        if (is_object($request) || is_array($request)) {

            if (isset($request['number'])) {
                $request['number'] = substr($request['number'], 0, 6) . 'XXXXXX' . substr($request['number'], -4, 4);
            }

            if (isset($request['token'])) {
                $request['token'] = 'XXX';
            }

            if (isset($request['cvvNumber'])) {
                $request['cvvNumber'] = 'XXX';
            }

            if ($this->getPost('cc_brand')) {
                $request['brand'] = $this->getPost('cc_brand');
            }

            $request = json_encode($request);
        }

        $responseMessage = null;
        if (is_object($return) || is_array($return)) {
            $responseMessage = isset($return['responseMessage']) ? $return['responseMessage'] : null;
            $return = json_encode($return);
        }

        $order_id = isset($this->session->data['order_id']) ? $this->session->data['order_id'] : 0;
        if (! $hasOrder) {
            $order_id = 0;
        }

        $request = $this->db->escape($request);
        $return = $this->db->escape($return);
        $responseMessage = $this->db->escape($responseMessage);

        $sql = 'INSERT INTO `' . DB_PREFIX . 'maxipago_transactions` 
                    (`id_order`, `boleto_url`, `online_debit_url`, `authentication_url`, `method`, `request`, `return`, `response_message`, `created_at`)
                VALUES
                    ("' . $order_id . '", "' . $boletoUrl . '",  "' . $onlineDebitUrl . '", "' . $authenticationUrl . '", "' . $method . '" ,"' . $request . '", "' . $return . '", "' . $responseMessage . '", NOW())';

        $this->db->query($sql);
    }

    /**
     * Calculate the installments price for maxiPago!
     * @param $price
     * @param $installments
     * @param $interestRate
     * @return float
     */
    public function getInstallmentPrice($price, $installments, $interestRate)
    {
        $price = (float) $price;
        if ($interestRate) {
            $interestRate = (float)(str_replace(',', '.', $interestRate)) / 100;
            $type = $this->config->get('maxipago_cc_interest_type');
            $valorParcela = 0;
            switch ($type) {
                case 'price':
                    $value = round($price * (($interestRate * pow((1 + $interestRate), $installments)) / (pow((1 + $interestRate), $installments) - 1)), 2);
                    break;
                case 'compound':
                    //M = C * (1 + i)^n
                    $value = ($price * pow(1 + $interestRate, $installments)) / $installments;
                    break;
                case 'simple':
                    //M = C * ( 1 + ( i * n ) )
                    $value = ($price * (1 + ($installments * $interestRate))) / $installments;
            }
        } else {
            if ($installments)
                $value = $price / $installments;
        }
        return $value;
    }

    /**
     * Calculate the total of the order based on interest rate and installmentes
     * @param $price
     * @param $installments
     * @param $interestRate
     * @return float
     */
    public function getTotalByInstallments($price, $installments, $interestRate)
    {
        $installmentPrice = $this->getInstallmentPrice($price, $installments, $interestRate);
        return $installmentPrice * $installments;
    }

    /**
     * Get MAX installments for a price
     * @param null $price
     * @return array|bool
     */
    public function getInstallment($price = null)
    {
        $price = (float) $price;

        $maxInstallments = $this->config->get('maxipago_cc_max_installments');//
        $installmentsWithoutInterest = $this->config->get('maxipago_cc_installments_without_interest');
        $minimumPerInstallment = $this->config->get('maxipago_cc_min_per_installments');
        $minimumPerInstallment = (float)$minimumPerInstallment;

        if ($minimumPerInstallment > 0) {
            if ($minimumPerInstallment > $price / 2)
                return false;

            while ($maxInstallments > ($price / $minimumPerInstallment))
                $maxInstallments--;

            while ($installmentsWithoutInterest > ($price / $minimumPerInstallment))
                $installmentsWithoutInterest--;
        }

        $interestRate = str_replace(',', '.', $this->config->get('maxipago_cc_interest_rate'));
        $interestRate = ($maxInstallments <= $installmentsWithoutInterest) ? '' : $interestRate;

        $installmentValue = $this->getInstallmentPrice($price, $maxInstallments, $interestRate);
        $totalWithoutInterest = $installmentValue;

        if ($installmentsWithoutInterest)
            $totalWithoutInterest = $price / $installmentsWithoutInterest;

        $total = $installmentValue * $maxInstallments;

        return array(
            'total' => $total,
            'installments_without_interest' => $installmentsWithoutInterest,
            'total_without_interest' => $totalWithoutInterest,
            'max_installments' => $maxInstallments,
            'installment_value' => $installmentValue,
            'interest_rate' => $interestRate,
        );
    }

    /**
     * Get ALL POSSIBLE instalments for a price
     * @param null $price
     * @return array
     */
    public function getInstallments($order_info = array())
    {
        if (! is_array($order_info))
            return false;

        $price = (float) $order_info['total'];

        $maxInstallments = $this->config->get('maxipago_cc_max_installments');//
        $installmentsWithoutInterest = $this->config->get('maxipago_cc_installments_without_interest');
        $minimumPerInstallment = $this->config->get('maxipago_cc_min_per_installments');
        $interestRate = str_replace(',', '.', $this->config->get('maxipago_cc_interest_rate'));

        if ($minimumPerInstallment > 0) {
            while ($maxInstallments > ($price / $minimumPerInstallment)) $maxInstallments--;
        }
        $installments = array();
        if ($price > 0) {
            $maxInstallments = ($maxInstallments == 0) ? 1 : $maxInstallments;
            for ($i = 1; $i <= $maxInstallments; $i++) {
                $interestRateInstallment = ($i <= $installmentsWithoutInterest) ? '' : $interestRate;
                $value = ($i <= $installmentsWithoutInterest) ? ($price / $i) : $this->getInstallmentPrice($price, $i, $interestRate);
                $total = $value * $i;

                $installments[] = array(
                    'total' => $total,
                    'total_formated' => $this->currency->format($total, $order_info['currency_code']),
                    'installments' => $i,
                    'installment_value' => $value,
                    'installment_value_formated' => $this->currency->format($value, $order_info['currency_code']),
                    'interest_rate' => $interestRateInstallment
                );
            }
        }
        return $installments;
    }

    /**
     * Get post data validating if exists
     * @param $data
     * @return null
     */
    public function getPost($data)
    {
        return isset($this->request->post[$data]) ? $this->request->post[$data] : null;
    }

    /**
     * Get post data validating if exists
     * @param $data
     * @return null
     */
    public function getRequest($data)
    {
        $data = isset($this->request->get[$data]) ? $this->request->get[$data] : null;
        if (! $data) {
            $data = isset($this->request->post[$data]) ? $this->request->post[$data] : null;
        }
        return $data;
    }

    /**
     * @param $canSave
     * @param null $customerId
     * @return array
     */
    public function getSavedCards($canSave, $customerId = null)
    {
        $saved_cards = array();
        if ($canSave && $customerId) {
            //Saved Cards
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_cc_token
                    WHERE `id_customer` = \'' . $customerId . '\'';
            $saved_cards = $this->db->query($sql);
        }

        return $saved_cards;
    }

    /**
     * @param $data
     * @param int $step
     */
    public function log($data, $step = 6)
    {
        if ($this->config->get('maxipago_logging')) {
            $backtrace = debug_backtrace();
            $log = new Log('maxipago.log');
            $log->write('(' . $backtrace[$step]['class'] . '::' . $backtrace[$step]['function'] . ') - ' . $data);
        }
    }

    public function validateIP($ipAddress)
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $ipAddress;
        }

        return self::DEFAULT_IP;
    }


    public function clean_number($number)
    {
        return preg_replace('/\D/', '', $number);
    }


    public function getPhoneNumber($telefone)
    {
        if (strlen($telefone) >= 10) {
            $telefone = preg_replace('/^D/', '', $telefone);
            $telefone = substr($telefone, 2, strlen($telefone) - 2);
        }
        return $telefone;
    }

    public function getAreaNumber($telefone)
    {
        $telefone = preg_replace('/^D/', '', $telefone);
        $telefone = substr($telefone, 0, 2);
        return $telefone;
    }

    public function getOrderData()
    {
        //Cart Items
        $orderData = array();

        $i = 0;
        foreach($this->cart->getProducts() as $product) {
            if ($product['price'] > 0) {
                $i++;

                $orderData['itemIndex' . $i] = $i;
                $orderData['itemProductCode' . $i] = $product['product_id'];
                $orderData['itemDescription' . $i] = $product['name'];
                $orderData['itemQuantity' . $i] = $product['quantity'];
                $orderData['itemUnitCost' . $i] = number_format(number_format($product['price'], 2, '.', ''), 2, '.', '');
                $orderData['itemTotalAmount' . $i] = number_format($product['price'] * $product['quantity'], 2, '.', '');
            }
        }

        $orderData['itemCount'] = $i;
        $orderData['userAgent'] = $_SERVER['HTTP_USER_AGENT'];

        return $orderData;

    }

    public function getCountryCode($country = 'BR')
    {
        return isset($this->_countryCodes[$country]) ? $this->_countryCodes[$country] : 'BR';
    }

    public function isOrderCapturable($order_id)
    {
        try {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card"
                    AND `response_message` = "AUTHORIZED"';

            if (!empty($this->db->query($sql)->row))
                return true;

            return false;
        } catch (Exception $e) {
            $this->log('Error retrieving transaction status for order `' . $order_id . '`: ' . $e->getMessage());
            return false;
        }
    }

    public function isOrderVoidable($order_id)
    {
        try {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card"
                    AND `response_message` = "CAPTURED"';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction))
            {
                $response = json_decode($transaction['return']);

                $transaction_date = date('d/m/Y', $response->transactionTimestamp);
                $today_date = date('d/m/Y');

                return $transaction_date == $today_date;
            }

            return false;
        } catch (Exception $e) {
            $this->log('Error retrieving transaction status for order `' . $order_id . '`: ' . $e->getMessage());
            return false;
        }
    }

    public function isOrderRefundable($order_id)
    {
        try {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card"
                    AND `response_message` = "CAPTURED"';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction))
            {
                $response = json_decode($transaction['return']);

                $transaction_date = date('m/d/Y', $response->transactionTimestamp);
                $today_date = date('m/d/Y');

                if($transaction_date != $today_date)
                    return strtotime($today_date) > $response->transactionTimestamp;
            }

            return false;
        } catch (Exception $e) {
            $this->log('Error retrieving transaction status for order `' . $order_id . '`: ' . $e->getMessage());
            return false;
        }
    }

    public function sync($transaction)
    {
        $updated = false;
        $return = json_decode($transaction['return']);
        $search = array(
            'orderID' => $return->orderID
        );

        $this->getMaxipago()->pullReport($search);
        $response = $this->getMaxipago()->getReportResult();

        $state = isset($response[0]['transactionState']) ? $response[0]['transactionState'] : null;

        $storeOrderId = $transaction['id_order'];
        if ($state && $storeOrderId) {
            $comment = $this->language->get('comment_updated_order') . ' ' . $state;

            if ($state == '10' || $state == '3' || $state == '44') {
                $updated = $storeOrderId;
                $this->_addOrderHistory($storeOrderId, $this->config->get('maxipago_order_approved'), $comment);
            } else if ($state == '45' || $state == '7' || $state == '9') {
                $updated = $storeOrderId;
                $this->_addOrderHistory($storeOrderId, $this->config->get('maxipago_order_cancelled'), $comment);
            }

            $this->_updateTransactionState($storeOrderId, $return, $response);

        }

        return $updated;
    }

    /**
     * Update order status
     *
     * @param $order_id
     * @param $order_status_id
     * @param $comment
     * @param int $notify
     *
     * @return void
     */
    protected function _addOrderHistory($order_id, $order_status_id, $comment, $notify = 1)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `order_status_id` = '" . (int)$order_status_id . "', `date_modified` = NOW() WHERE `order_id` = '" . (int)$order_id . "'");
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_history` SET `order_id` = '" . (int)$order_id . "', `order_status_id` = '" . (int)$order_status_id . "', `notify` = '" . $notify . "', `comment` = '" . $this->db->escape($comment) . "', `date_added` = NOW()");
    }

    public function captureTransaction($order, $transaction)
    {
        try {
            $request = json_decode($transaction['request']);
            $return = json_decode($transaction['return']);

            if (property_exists($request, 'chargeTotal') && property_exists($return, 'orderID') && property_exists($return, 'referenceNum')) {
                $data = array(
                    'orderID' => $return->orderID,
                    'referenceNum' => $return->referenceNum,
                    'chargeTotal' => $request->chargeTotal
                );

                $this->getMaxipago()->creditCardCapture($data);

                $this->log($this->getMaxipago()->xmlRequest);
                $this->log($this->getMaxipago()->xmlResponse);

                $this->_updateTransactionState($order['order_id'], $return, $this->getMaxipago()->xmlResponse);
            }
        } catch (Exception $e)
        {
            $this->log('[catalog/captureTransaction] ' . $e->getMessage());
            throw $e;
        }
    }

    public function reverseTransaction($order, $transaction)
    {
        try {
            $request = json_decode($transaction['request']);
            $return = json_decode($transaction['return']);

            if(isset($order['date_added'])) {
                $canVoid = date('Ymd') == date('Ymd', strtotime($order['date_added']));

                if($canVoid) {
                    if(property_exists($return, 'transactionID'))
                    {
                        $data = array(
                            'transactionID' => $return->transactionID,
                        );

                        $this->getMaxipago()->creditCardVoid($data);
                    }
                } else {
                    if(property_exists($request, 'chargeTotal') && property_exists($return, 'orderID') && property_exists($return, 'referenceNum'))
                    {
                        $data = array(
                            'orderID' => $return->orderID,
                            'referenceNum' => $return->referenceNum,
                            'chargeTotal' => $request->chargeTotal,
                        );

                        $this->getMaxipago()->creditCardRefund($data);
                    }
                }
            }

            $this->log($this->getMaxipago()->xmlRequest);
            $this->log($this->getMaxipago()->xmlResponse);

            $this->_updateTransactionState($order['order_id'], $return, $this->getMaxipago()->xmlResponse);

        } catch (Exception $e)
        {
            $this->log('[catalog/reverseTransaction] ' . $e->getMessage());
            throw $e;
        }
    }

    public function syncTransaction($order, $transaction)
    {
        $this->load->language('extension/payment/maxipago');
        $this->load->model('sale/order');

        try {
            $request = json_decode($transaction['request']);
            $return = json_decode($transaction['return']);

            if(property_exists($return, 'orderID') && isset($order['order_id']))
            {
                $data = array(
                    'orderID' => $return->orderID
                );

                $this->getMaxipago()->pullReport($data);

                $this->log($this->getMaxipago()->xmlRequest);
                $this->log($this->getMaxipago()->xmlResponse);

                $response = $this->getMaxipago()->getReportResult();

                $state = isset($response[0]['transactionState']) ? $response[0]['transactionState'] : null;

                if($state && (property_exists($return, 'transactionState') || $return->transactionState != $state)) {
                    $storeOrderId = $order['order_id'];
                    $orderStatusId = $order['order_status_id'];
                    $comment = $this->language->get('comment_updated_order') . ' - ' . $state;

                    if ($state == '10' || $state == '3' || $state == '44') {
                        $updated = $storeOrderId;
                        $this->_addOrderHistory($storeOrderId, $this->config->get('maxipago_order_approved'), $comment);
                    } else if ($state == '45' || $state == '7' || $state == '9') {
                        $updated = $storeOrderId;
                        $this->_addOrderHistory($storeOrderId, $this->config->get('maxipago_order_cancelled'), $comment);
                    } else if ($state == '36') {
                        $comment = $this->language->get('comment_overpaid_order') . ' - ' . $state;
                        $this->_addOrderHistory($storeOrderId, $this->config->get('maxipago_order_approved'), $comment);
                    } else if ($state == '35') {
                        $comment = $this->language->get('comment_underpaid_order') . ' - ' . $state;
                        $this->_addOrderHistory($storeOrderId, $orderStatusId, $comment);
                    }

                    $this->_updateTransactionState($storeOrderId, $return, $response);
                }
            }
        } catch (Exception $e) {
            $this->log('[catalog/syncTransaction] ' . $e->getMessage());
            throw $e;
        }
    }
}
