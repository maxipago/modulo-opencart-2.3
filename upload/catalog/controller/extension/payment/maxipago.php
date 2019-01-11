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
 * @property ModelExtensionPaymentMaxipago model_extension_payment_maxipago
 * @property ModelCheckoutOrder model_checkout_order
 */
class ControllerExtensionPaymentMaxipago extends Controller
{
    const CC_BRANDS = array('VISA', 'MASTERCARD', 'AMEX', 'DINERS', 'ELO', 'DISCOVER', 'HIPERCARD', 'HIPER', 'JCB', 'AURA', 'CREDZ');
    const DC_BRANDS = array('VISA', 'MASTERCARD');
    const EFT_BANKS = array('17' => 'Bradesco', '18' => 'Itaú');

    const MAXIPAGO_CODE = 'maxipago';

    private static $maxipago_transaction_states = array(
        'In Progress' => 1,
        'Captured' => 3,
        'Pending Capture' => 4,
        'Pending Authorization' => 5,
        'Authorized' => 6,
        'Declined' => 7,
        'Reversed' => 8,
        'Voided' => 9,
        'Paid' => 10,
        'Pending Confirmation' => 11,
        'Pending Review' => 12,
        'Pending Reversion' => 13,
        'Pending Capture (retrial)' => 14,
        'Pending Reversal' => 16,
        'Pending Void' => 18,
        'Pending Void (retrial)' => 19,
        'Boleto Issued' => 22,
        'Pending Authentication' => 29,
        'Authenticated' => 30,
        'Pending Reversal (retrial)' => 31,
        'Authentication in Progress' => 32,
        'Submitted Authentication' => 33,
        'Boleto Viewed' => 34,
        'Boleto Underpaid' => 35,
        'Boleto Overpaid' => 36,
        'File Submission Pending Reversal' => 38,
        'Fraud Approved' => 44,
        'Fraud Declined' => 45,
        'Fraud Review' => 46
    );

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry = $registry;
        $this->language->load('extension/payment/maxipago');
    }

    public function index()
    {
        $data = array();

        $this->load->model('checkout/order');
        $this->load->model('extension/payment/maxipago');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data = $this->_translate($data);

        $data['text_title']     = $this->getMethodTitle();
        $data['button_confirm'] = $this->language->get('button_confirm') . ' ' . $data['text_title'];
        $data['cc_enabled']     = $this->config->get('maxipago_cc_enabled');
        $data['has_recurring_products'] = $this->cart->hasRecurringProducts();

        $data['dc_enabled']     = $data['has_recurring_products'] ? false : $this->config->get('maxipago_dc_enabled');
        $data['redepay_enabled']= $data['has_recurring_products'] ? false : $this->config->get('maxipago_redepay_enabled');
        $data['ticket_enabled'] = $data['has_recurring_products'] ? false : $this->config->get('maxipago_ticket_enabled');
        $data['eft_enabled']    = $data['has_recurring_products'] ? false : $this->config->get('maxipago_eft_enabled');


        $data['cards'] = array();
        foreach (self::CC_BRANDS as $brand) {
            if ($this->config->get('maxipago_' . strtolower($brand) . '_processor')) {
                array_push($data['cards'], $brand);
            }
        }

        $data['debit_cards'] = array();
        foreach (self::DC_BRANDS as $brand) {
            if($this->config->get('maxipago_dc_' . strtolower($brand) . '_processor')) {
                array_push($data['debit_cards'], $brand);
            }
        }

        $data['eft_banks_enabled']  = $this->config->get('maxipago_eft_banks');
        $data['banks'] = self::EFT_BANKS;
        $data['order_info'] = $order_info;
        $canSave = false;
        if (isset($order_info['customer_id']) && $order_info['customer_id'] && $this->config->get('maxipago_cc_processing_type') == 'sale') {
            $canSave = $this->config->get('maxipago_cc_can_save');
        }
        $data['cc_can_save'] = $canSave;

        $data['installments'] = $this->model_extension_payment_maxipago->getInstallments($order_info);
        $data['saved_cards'] = $this->model_extension_payment_maxipago->getSavedCards($canSave, $order_info['customer_id']);

        $base_url = $this->config->get('config_url');
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $base_url = $this->config->get('config_ssl');
        }
        $data['base_url'] = $base_url;

        /* Link */
        $data['continue'] = $this->url->link('checkout/success', '', true);

        $this->session->data['maxipago_data'] = $data;

        return $this->load->view('extension/payment/maxipago', $data);
    }

    /**
     * Method that creates a transaction
     */
    public function transaction()
    {
        $response = array();
        $response['error'] = false;

        try {
            /* ID do Pedido */
            $order_id = $this->session->data['order_id'];

            $this->load->model('checkout/order');
            $this->load->model('extension/payment/maxipago');

            /* Informações do Pedido */
            $order_info = $this->model_checkout_order->getOrder($order_id);

            $type = isset($this->request->post['maxipago_type']) ? $this->request->post['maxipago_type'] : null;

            $validationErrors = $this->validateInputs($order_info, $type);

            if(count($validationErrors) > 0)
            {
                $response['error'] = true;
                $errors = sprintf('<li>%s</li>', implode('</li><li>', $validationErrors));
                $response['message'] = sprintf('<ul>%s</ul>', $errors);
            } else
            {
                if ($type == 'cc') {
                    $response = $this->cardMethod($order_info);
                } else if ($type == 'dc') {
                    $response = $this->model_extension_payment_maxipago->debitCardMethod($order_info);
                } else if ($type == 'ticket') {
                    $response = $this->model_extension_payment_maxipago->ticketMethod($order_info);
                } else if ($type == 'eft') {
                    $eftBank = $this->request->post['eft_bank'];
                    $response = $this->model_extension_payment_maxipago->eftMethod($order_info);
                } else if ($type == 'redepay') {
                    $response = $this->model_extension_payment_maxipago->redepayMethod($order_info);
                }
            }

        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }

        if (is_array($response) || is_object($response)) {
            $response = json_encode($response);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput($response);
    }

    private function cardMethod($order_info)
    {
        if(!$this->cart->hasRecurringProducts())
            return $this->model_extension_payment_maxipago->cardMethod($order_info);

        $responses = array();
        $products = $this->getSeparatedCartProducts();

        if(count($products['common']) > 0)
        {
            $order_info['total'] = $this->getOrderTotalWithoutRecurringProducts($order_info, $products['recurring']);
            $response = $this->model_extension_payment_maxipago->cardMethod($order_info);
            $response['product_data_type'] = 'common';
            $response['product_data'] = $products['common'];
            $responses[] = $response;
        }

        if(!empty($responses))
        {
            $response = $responses[0];

            if($this->invalidResponse($response)) {
                $response['error'] = true;
                $message = sprintf($this->language->get('text_error_response_voided_on_common'), $response['responseMessage']);
                $response['message'] = $message;
                return $response;
            }
        }

        if(!$this->model_checkout_recurring)
            $this->load->model('checkout/recurring');

        foreach($products['recurring'] as $recurring_product)
        {
            $recurring_id = $this->model_checkout_recurring->create($recurring_product, $order_info['order_id'], $recurring_product['recurring']['name']);
            $recurring_product['recurring']['order_recurring_id'] = $recurring_id;

            try {
                $response = $this->model_extension_payment_maxipago->recurringMethod($order_info, $recurring_product);
                $response['product_data_type'] = 'recurring';
                $response['product_data'] = $recurring_product;
            } catch (Exception $e) {
                $this->voidAllResponses($order_info);
                return array(
                    'error' => true,
                    'message' => $e->getMessage()
                );
            }

            if($this->invalidResponse($response)) {
                $this->voidAllResponses($order_info);
                $response['error'] = true;
                $message = sprintf($this->language->get('text_error_responses_voided_on_recurring'), $response['responseMessage'], $recurring_product['name'], $recurring_product['recurring']['name']);
                $response['message'] = $message;
                return $response;
            }

            $this->model_checkout_recurring->addReference($recurring_id, $response['orderID']);
            $responses[] = $response;
        }

        $responses['recurring'] = true;
        return $responses;
    }

    private function voidAllResponses($order_data)
    {
        $this->model_extension_payment_maxipago->voidOrder($order_data['order_id']);
    }

    private function invalidResponse($response)
    {
        if(!isset($response['orderID']))
            return true;

        if(empty($response['orderID']))
            return true;

        if(!in_array($response['responseMessage'], array('AUTHORIZED', 'CAPTURED')))
            return true;

        return false;
    }

    private function getSeparatedCartProducts()
    {
        $products = $this->cart->getProducts();

        $common_products = array();
        $recurring_products = array();

        foreach($products as $product)
        {
            if($product['recurring'])
                $recurring_products[] = $product;
            else
                $common_products[] = $product;
        }

        return array(
            'common' => $common_products,
            'recurring' => $recurring_products
        );
    }

    private function getOrderTotalWithoutRecurringProducts($order_data, $recurring_products)
    {
        $total = $order_data['total'];

        foreach($recurring_products as $product)
            $total -= $product['price'];

        return $total;
    }

    /**
     * Delete saved Credit Card in maxiPago!
     */
    public function delete()
    {
        try {
            $this->load->model('checkout/order');
            $this->load->model('extension/payment/maxipago');

            $response = array('success' => false, 'message' => '');
            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
            $id_customer = $order_info['customer_id'];

            if ($id_customer) {
                $description = $this->request->post['ident'];
                $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_cc_token
                        WHERE `id_customer` = \'' . $id_customer . '\'
                        AND `description` = \'' . $description . '\'
                        LIMIT 1; ';
                $ccSaved = $this->db->query($sql)->row;

                if ($this->model_extension_payment_maxipago->deleteCC($ccSaved)) {
                    $response = array('success' => true);
                }
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        if (is_array($response) || is_object($response)) {
            $response = json_encode($response);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput($response);
    }

    /**
     * Method that confirms the payment and create a comment with the payment information
     */
    public function confirm()
    {
        $response = array(
            'error' => true,
            'message' => 'Wrong payment method code'
        );

        if ($this->session->data['payment_method']['code'] == 'maxipago') {

            $this->load->model('extension/payment/maxipago');

            $recurring = isset($this->request->post['recurring']) ? $this->request->post['recurring'] : null;

            if($recurring)
                $response = $this->model_extension_payment_maxipago->confirmRecurringPayments();
            else
                $response = $this->model_extension_payment_maxipago->confirmPayment();

            $this->finishCurrentOrder();
        }

        if (is_array($response) || is_object($response)) {
            $response = json_encode($response);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput($response);
    }

    /**
     * Fakes the checkout/success call.
     * This allows to redirect the user to other pages than checkout/success after the payment.
     */
    protected function finishCurrentOrder()
    {
        if (isset($this->session->data['order_id']))
        {
            $this->cart->clear();

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        }
    }

    public function checkForCapture($route, $data = array())
    {
        if(empty($data))
            return;

        $order_id = $data[0];
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);

        if($order && $order['payment_code'] == self::MAXIPAGO_CODE)
        {
            $status_processed = 15;
            $order_status = $data[1];

            if($order_status == $status_processed)
            {
                $this->load->model('extension/payment/maxipago');
                $can_capture = $this->model_extension_payment_maxipago->isOrderCapturable($order_id);

                if($can_capture) {
                    $this->session->data['order_id'] = $order_id;
                    $this->model_extension_payment_maxipago->capturePayment($order);
                }
            }
        }
    }

    public function checkForVoid($route, $data = array())
    {
        if(empty($data))
            return;

        $order_id = $data[0];
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);

        if($order && $order['payment_code'] == self::MAXIPAGO_CODE)
        {
            $status_cancelled = 7;
            $status_refunded = 11;
            $order_status = $data[1];

            if($order_status == $status_cancelled || $order_status == $status_refunded)
            {
                $this->load->model('extension/payment/maxipago');
                $can_void = $this->model_extension_payment_maxipago->isOrderVoidable($order_id);

                if($can_void) {
                    $this->session->data['order_id'] = $order_id;
                    $this->model_extension_payment_maxipago->voidPayment($order);
                }
            }
        }
    }

    public function checkForRefund($route, $data = array())
    {
        if(empty($data))
            return;

        $order_id = $data[0];
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);

        if($order && $order['payment_code'] == self::MAXIPAGO_CODE)
        {
            $status_cancelled = 7;
            $status_refunded = 11;
            $order_status = $data[1];

            if($order_status == $status_cancelled || $order_status == $status_refunded)
            {
                $this->load->model('extension/payment/maxipago');
                $can_refund = $this->model_extension_payment_maxipago->isOrderRefundable($order_id);

                if($can_refund) {
                    $this->session->data['order_id'] = $order_id;
                    $this->model_extension_payment_maxipago->reversePayment($order);
                }
            }
        }
    }


    /**
     * @param $route
     * @param $orders
     */
    public function change($route, $data = array())
    {
        $this->load->model('extension/payment/maxipago');
        $this->load->language('extension/payment/maxipago');
        $this->load->model('checkout/order');

        $order_id = $this->model_extension_payment_maxipago->getRequest('order_id');
        $order_status_id = $this->model_extension_payment_maxipago->getPost('order_status_id');

        if ($order_id && $order_status_id) {
            $order_info = $this->model_checkout_order->getOrder($order_id);

            //If payment method is equal to maxipago and the status is changed
            if (
                $order_info['payment_code'] == self::MAXIPAGO_CODE
                && $order_info['order_status_id'] != $order_status_id
            ) {
                if (
                    $this->config->get('maxipago_cc_order_reverse')
                    && $order_status_id == $this->config->get('maxipago_order_cancelled')
                    && $this->config->get('maxipago_order_cancelled') != $this->config->get('maxipago_order_approved')
                    && $this->config->get('maxipago_order_cancelled') != $this->config->get('maxipago_order_processing')
                ) {
                    //If the order uses maxiPago! and status equals cancelled
                    $this->model_extension_payment_maxipago->voidPayment($order_info);
                } else if (
                    $order_status_id == $this->config->get('maxipago_order_refunded')
                    && $this->config->get('maxipago_order_refunded') != $this->config->get('maxipago_order_approved')
                    && $this->config->get('maxipago_order_refunded') != $this->config->get('maxipago_order_processing')
                ) {
                    //If the order uses maxiPago! and status equals approved
                    $this->model_extension_payment_maxipago->reversePayment($order_info);
                } else if (
                    $order_status_id == $this->config->get('maxipago_order_approved')
                    && $this->config->get('maxipago_order_approved') != $this->config->get('maxipago_order_cancelled')
                    && $this->config->get('maxipago_order_approved') != $this->config->get('maxipago_order_processing')
                ) {
                    //If the order uses maxiPago! and status equals approved
                    $this->model_extension_payment_maxipago->capturePayment($order_info, $order_status_id);
                }
            }
        }
    }

    protected function getMethodTitle()
    {
        return ($this->config->get('maxipago_method_title')) ? $this->config->get('maxipago_method_title') : $this->language->get('text_title');
    }

    protected function _translate($data)
    {
        $textFields = array(
            'button_sending_text',
            'error_transaction',
            'error_already_processed',
            'error_cc_brand',
            'error_cc_number',
            'error_cc_owner',
            'error_cc_cvv2',
            'error_eft_bank',
            'error_cpf',

            'entry_select',
            'entry_cpf_number',
            'entry_cc_owner',
            'entry_cc_type',
            'entry_cc_number',
            'entry_cc_expire_date',
            'entry_cc_cvv',
            'entry_cc_cvv2',
            'entry_use_saved_card',
            'entry_save_card',
            'entry_installments',
            'entry_per_month',
            'entry_without_interest',
            'entry_total',
            'entry_remove_card',

            'dc_error_brand',
            'dc_error_number',
            'dc_error_number_mismatch_brand',
            'dc_error_owner',
            'dc_error_cvv',
            'dc_error_document',

            'entry_dc_type',
            'entry_dc_owner',
            'entry_dc_number',
            'entry_dc_expiry_date',
            'entry_dc_cvv',
            'entry_dc_document',

            'entry_ticket_instructions',
            'entry_eft_bank',

            'ticket_text',
            'cc_text',
            'dc_text',
            'redepay_text',
            'eft_text',
        );

        foreach ($textFields as $field) {
            $data[$field] = $this->language->get($field);
        }

        $data['months'] = array();

        for ($i = 1; $i <= 12; $i++) {
            $data['months'][] = array(
                'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
                'value' => sprintf('%02d', $i)
            );
        }

        $today = getdate();
        $data['year_expire'] = array();

        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][] = array(
                'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
            );
        }

        return $data;
    }

    public function synchronize()
    {
        try
        {
            $this->validateRequestKey();

            $this->loadSyncronizeDependencies();
            $transactions = $this->getSyncronizableTransactions();

            if(property_exists($transactions, 'num_rows') && $transactions->num_rows)
            {
                foreach($transactions->rows as $transaction)
                {
                    if(isset($transaction['id_order']))
                    {
                        $order = $this->db->query('SELECT * FROM `' . DB_PREFIX . 'order` WHERE `order_id` = ' . $transaction['id_order'])->row;

                        if($this->mustCapture($transaction, $order))
                            $this->model_payment_maxipago->captureTransaction($order, $transaction);

                        if($this->mustReverse($transaction, $order))
                            $this->model_payment_maxipago->reverseTransaction($order, $transaction);

                        $this->model_payment_maxipago->syncTransaction($order, $transaction);
                    }
                }
            }
        } catch (Exception $e)
        {
            $this->log('[Catalog] Error syncing orders: ' . $e->getMessage());
        }


        $this->response->redirect($this->getBaseUrl());
    }

    public function loadSyncronizeDependencies()
    {
        $this->load->model('extension/payment/maxipago');
    }

    public function getSyncronizableTransactions()
    {
        try
        {
            $sql = 'SELECT * FROM ' . DB_PREFIX . 'maxipago_transactions WHERE `created_at` > "' . $this->getSyncFromDate() . '"';

            if(isset($this->request->get['orderId']) && $this->request->get['orderId'])
            {
                $sql .= ' AND `id_order` = "' . $this->request->get['orderId'] . '"';
            }

            $sql .= " AND response_message not in ('VOIDED', 'REFUNDED', 'DECLINED', 'FRAUD DECLINED', 'INVALID REQUEST')";

            return $this->db->query($sql);
        } catch (Exception $e)
        {
            $this->log('[catalog/getSyncronizableTransactions] ' . $e->getMessage());
            throw $e;
        }
    }

    private function getSyncFromDate()
    {
        try
        {
            $date = new DateTime('-15 DAYS');
            return $date->format('Y-m-d 00:00:00');
        } catch (Exception $e)
        {
            throw $e;
        }
    }

    private function mustCapture($transaction, $order)
    {
        $approvedStatus = $this->config->get('maxipago_order_approved');

        // Only credit card, authorized orders can be captured.
        $isCreditCardMethod = $transaction['method'] == 'card';
        $isAuthorized = $transaction['response_message'] == 'AUTHORIZED';


        if($isCreditCardMethod && $isAuthorized && isset($order['order_status_id']))
            return $approvedStatus == $order['order_status_id'];

        return false;
    }

    private function mustReverse($transaction, $order)
    {
        $cancelledStatus = $this->config->get('maxipago_order_cancelled');
        $refundedStatus = $this->config->get('maxipago_order_refunded');

        $reversableStatus = array( $cancelledStatus, $refundedStatus );

        $isCreditCardMethod = $transaction['method'] == 'card';

        // Must be credit card
        if($isCreditCardMethod && isset($order['order_status_id']) )
            return in_array($order['order_status_id'], $reversableStatus);

        return false;
    }

    public function old_synchronize()
    {
        $this->validateRequestKey();

        $this->load->language('extension/payment/maxipago');

        $minimum_creation_date = (new DateTime('-15 DAYS'))->format('Y-m-d 00:00:00');
        $response_messages = '"ISSUED", "VIEWED", "BOLETO ISSUED", "BOLETO VIEWED", "PENDING", "PENDING CONFIRMATION", "AUTHORIZED", "ENROLLED"';

        $sql = 'SELECT * FROM `' . DB_PREFIX . 'maxipago_transactions`' .
            ' WHERE `created_at` > "' . $minimum_creation_date . '"' .
            ' AND `response_message` in (' . $response_messages . ')';

        $transactions = $this->db->query($sql)->rows;

        $this->synchronizeCanceledOrders();

        if($transactions && !empty($transactions))
        {
            $this->load->model('extension/payment/maxipago');

            try
            {


                foreach($transactions as $transaction)
                    $this->model_extension_payment_maxipago->sync($transaction);
            } catch(Exception $exception)
            {
                $this->response->redirect($this->getBaseUrl());
            }
        }

        $this->response->redirect($this->getBaseUrl());
    }

    public function success()
    {
        $this->checkMaxipagoResponse();
    }

    public function error()
    {
        $this->checkMaxipagoResponse();
    }

    public function notification()
    {
        $this->checkMaxipagoResponse();
    }

    private function checkMaxipagoResponse()
    {
        $this->validateRequestKey();
        $maxipago_order_id = $this->getOrderIdIfValidParameters();
        $this->load->model('extension/payment/maxipago');

        $maxipago_client = $this->model_extension_payment_maxipago->getMaxipago();
        $maxipago_client->pullReport(array(
            'orderID' => $maxipago_order_id
        ));

        $response = $maxipago_client->getReportResult();

        if(empty($response))
            return;

        $response = $response[0];

        if(isset($response['transactionState']) && isset($response['transactionStatus']))
        {
            $transaction_state = $response['transactionState'];
            $transaction_status = $response['transactionStatus'];

            $order_status = (int)$this->getOpencartStatusFromTransactionState($transaction_state);
            $order_comment = $this->language->get('comment_update_order') . ' ' . strtoupper($transaction_status);

            $redirect_url = $this->getBaseUrl();

            $ids = $this->getOrdersIdsFromOrderID($maxipago_order_id)->rows;

            foreach($ids as $id)
            {
                $id_order = (int)$id['id_order'];
                $redirect_url = $this->url->link('account/order/info', 'order_id=' . $id_order);

                $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `order_status_id` = '" . $order_status . "', `date_modified` = NOW() WHERE `order_id` = '" . $id_order . "'");
                $this->db->query("INSERT INTO `" . DB_PREFIX . "order_history` SET `order_id` = '" . $id_order . "', `order_status_id` = '" . $order_status . "', `notify` = '1', `comment` = '" . $this->db->escape($order_comment) . "', `date_added` = NOW()");
                $this->db->query("UPDATE `" . DB_PREFIX . "maxipago_transactions` SET `response_message` = '" . strtoupper($transaction_status) . "', `return` = '" . json_encode($response) . "' WHERE `id_order` = '" . $id_order . "'");

                if($transaction_state == self::$maxipago_transaction_states['Fraud Approved'])
                {
                    // Transaction must be captured
                    $this->load->model('checkout/order');
                    $order = $this->model_checkout_order->getOrder($id_order);

                    if($order)
                        $this->model_extension_payment_maxipago->capturePayment($order);
                }
            }
        }

        $redirect_url = $this->url->link('checkout/success');
        $this->response->redirect($redirect_url);
    }

    private function getBaseUrl()
    {
        if(isset($this->request->server['HTTPS']))
            if($this->request->server['HTTPS'] == 'on' || $this->request->server['HTTPS'] == '1')
                return $this->config->get('config_ssl');

        return $this->config->get('config_url');
    }

    private function getOpencartStatusFromTransactionState($transaction_state)
    {
        $states = self::$maxipago_transaction_states;

        switch($transaction_state)
        {
            case $states['In Progress']:
                return $this->config->get('maxipago_order_processing');
            case $states['Authorized']:
                return $this->config->get('maxipago_order_authorized');
            case $states['Captured']:
            case $states['Paid']:
            case $states['Fraud Approved']:
                return $this->config->get('maxipago_order_approved');
            case $states['Declined']:
            case $states['Fraud Declined']:
                return $this->config->get('maxipago_order_cancelled');
            case $states['Reversed']:
                return $this->config->get('maxipago_order_refunded');
        }
    }

    private function validateRequestKey()
    {
        if(isset($_GET['mpKey']))
        {
            $configured_key = $this->config->get('maxipago_consumer_key');

            if($configured_key == $_GET['mpKey'])
                return;
        }

        http_response_code(401);
        exit();
    }

    private function getOrderIdIfValidParameters()
    {
        $body = file_get_contents('php://input');
        $post_is_valid = isset($_POST) && !empty($_POST);

        if($post_is_valid && isset($_POST['hp_orderid']))
            return $_POST['hp_orderid'];

        if($body)
        {
            $body_xml = simplexml_load_string($body);
            if (property_exists($body_xml, 'orderID'))
                return (string) $body_xml->orderID;
        }

        http_response_code(400);
        exit();
    }

    private function getOrdersIdsFromOrderID($order_id)
    {
        $sql = 'SELECT `id_order` FROM ' . DB_PREFIX . 'maxipago_transactions
        WHERE JSON_EXTRACT(`return`, "$.orderID") = "' . $order_id . '" OR
        JSON_EXTRACT(`return`, "$.orderId") = "' . $order_id . '" GROUP BY `id_order`';

        return $this->db->query($sql);
    }

    private function validateInputs($order_info, $type)
    {
        $inputErrors = array();

        $fill_payment_field_message = 'Por favor, preencha o campo \'%s\' do endereço de cobrança';
        $fill_shipping_field_message = 'Por favor, preencha o campo \'%s\' do endereço de entrega';
        $fill_method_field_message = 'Por favor, preencha o campo \'%s\' do método de pagamento';

        // Validate Billing Details
        if(!isset($order_info['payment_firstname']) || empty($order_info['payment_firstname']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Nome');

        if(!isset($order_info['payment_lastname']) || empty($order_info['payment_lastname']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Sobrenome');

        /*if(!isset($order_info['payment_company']) || empty($order_info['payment_company']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Empresa');*/

        if(!isset($order_info['payment_address_1']) || empty($order_info['payment_address_1']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Endereço 1');

        /*if(!isset($order_info['payment_address_2']) || empty($order_info['payment_address_2']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Endereço 2');*/

        if(!isset($order_info['payment_city']) || empty($order_info['payment_city']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Cidade');

        if(!isset($order_info['payment_postcode']) || empty($order_info['payment_postcode']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'CEP');

        if(!isset($order_info['payment_country']) || empty($order_info['payment_country']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'País');

        if(!isset($order_info['payment_zone']) || empty($order_info['payment_zone']))
            $inputErrors[] = sprintf($fill_payment_field_message, 'Estado');

        if(isset($order_info['payment_custom_field']))
        {
            $this->load->model('account/custom_field');
            $custom_fields = $this->model_account_custom_field->getCustomFields();

            foreach($custom_fields as $custom_field)
            {
                if($custom_field['required'])
                {
                    if(isset($order_info['payment_custom_field'][$custom_field['custom_field_id']]))
                    {
                        if(empty($order_info['payment_custom_field'][$custom_field['custom_field_id']]))
                            $inputErrors[] = sprintf($fill_payment_field_message, $custom_field['name']);
                    } else
                    {
                        $inputErrors[] = sprintf('Campo custom \'%s\' não foi encontrado no formulário para o endereço de cobrança', $custom_field['name']);
                    }
                }
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

        if($anyProductRequiresShipping)
        {

            // Validate Delivery Details
            if(!isset($order_info['shipping_firstname']) || empty($order_info['shipping_firstname']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Nome');

            if(!isset($order_info['shipping_lastname']) || empty($order_info['shipping_lastname']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Sobrenome');

            /*if(!isset($order_info['shipping_company']) || empty($order_info['shipping_company']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Empresa');*/

            if(!isset($order_info['shipping_address_1']) || empty($order_info['shipping_address_1']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Endereço 1');

            /*if(!isset($order_info['shipping_address_2']) || empty($order_info['shipping_address_2']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Endereço 2');*/

            if(!isset($order_info['shipping_city']) || empty($order_info['shipping_city']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Cidade');

            if(!isset($order_info['shipping_postcode']) || empty($order_info['shipping_postcode']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'CEP');

            if(!isset($order_info['shipping_country']) || empty($order_info['shipping_country']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'País');

            if(!isset($order_info['shipping_zone']) || empty($order_info['shipping_zone']))
                $inputErrors[] = sprintf($fill_shipping_field_message, 'Bairro');

            if(isset($order_info['shipping_custom_field']))
            {
                $this->load->model('account/custom_field');
                $custom_fields = $this->model_account_custom_field->getCustomFields();

                foreach($custom_fields as $custom_field)
                {
                    if($custom_field['required'])
                    {
                        if(isset($order_info['shipping_custom_field'][$custom_field['custom_field_id']]))
                        {
                            if(empty($order_info['shipping_custom_field'][$custom_field['custom_field_id']]))
                                $inputErrors[] = sprintf($fill_shipping_field_message, $custom_field['name']);
                        } else
                        {
                            $inputErrors[] = sprintf('Campo custom \'%s\' não foi encontrado no formulário para o endereço de entrega', $custom_field['name']);
                        }
                    }
                }
            }
        }

        // Validate Payment Method Inputs
        if ($type == 'cc') {
            if(isset($_REQUEST['cc_saved_card']) && !empty($_REQUEST['cc_saved_card']))
            {
                if(!isset($_REQUEST['cc_cvv2_saved']) || empty($_REQUEST['cc_cvv2_saved']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Código de Segurança (CVV)');
            } else {
                if(!isset($_REQUEST['cc_brand']) || empty($_REQUEST['cc_brand']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Bandeira');

                if(!isset($_REQUEST['cc_number']) || empty($_REQUEST['cc_number']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Número do Cartão');

                if(!isset($_REQUEST['cc_owner']) || empty($_REQUEST['cc_owner']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Nome no Cartão');

                if(!isset($_REQUEST['cc_expire_date_month']) || empty($_REQUEST['cc_expire_date_month']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Mês de Expiração');

                if(!isset($_REQUEST['cc_expire_date_year']) || empty($_REQUEST['cc_expire_date_year']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Ano de Expiração');

                if(!isset($_REQUEST['cc_cvv2']) || empty($_REQUEST['cc_cvv2']))
                    $inputErrors[] = sprintf($fill_method_field_message, 'Código de Segurança (CVV)');
            }

            if(!isset($_REQUEST['cc_installments']) || empty($_REQUEST['cc_installments']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Número de Parcelas');

            if(!isset($_REQUEST['cc_cpf']) || empty($_REQUEST['cc_cpf']))
                $inputErrors[] = sprintf($fill_method_field_message, 'CPF/CNPJ');
        } else if ($type == 'dc') {
            if(!isset($_REQUEST['dc_brand']) || empty($_REQUEST['dc_brand']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Bandeira');

            if(!isset($_REQUEST['dc_number']) || empty($_REQUEST['dc_number']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Número do Cartão');

            if(!isset($_REQUEST['dc_owner']) || empty($_REQUEST['dc_owner']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Nome no Cartão');

            if(!isset($_REQUEST['dc_expiry_month']) || empty($_REQUEST['dc_expiry_month']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Mês de Expiração');

            if(!isset($_REQUEST['dc_expiry_year']) || empty($_REQUEST['dc_expiry_year']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Ano de Expiração');

            if(!isset($_REQUEST['dc_cvv']) || empty($_REQUEST['dc_cvv']))
                $inputErrors[] = sprintf($fill_method_field_message, 'Código de Segurança (CVV)');

            if(!isset($_REQUEST['dc_document']) || empty($_REQUEST['dc_document']))
                $inputErrors[] = sprintf($fill_method_field_message, 'CPF/CNPJ');
        } else if ($type == 'ticket') {
            if(!isset($this->request->post['ticket_cpf']) || empty($this->request->post['ticket_cpf']))
                $inputErrors[] = sprintf($fill_method_field_message, 'CPF/CNPJ');
        } else if ($type == 'eft') {
            if(!isset($_REQUEST['eft_cpf']) || empty($_REQUEST['eft_cpf']))
                $inputErrors[] = sprintf($fill_method_field_message, 'CPF/CNPJ');
        } else if ($type = 'redepay') {
            if(!isset($_REQUEST['redepay_document']) || empty($_REQUEST['redepay_document']))
                $inputErrors[] = sprintf($fill_method_field_message, 'CPF/CNPJ');
        } else {
            $inputErrors[] = sprintf('Método de pagamento maxiPago \'%s\' inválido', $type);
        }


        return $inputErrors;
    }

    private function synchronizeCanceledOrders()
    {
        $canceledOrders = array();

        $this->load->model('extension/payment/maxipago');

        $minimum_creation_date = (new DateTime('-15 DAYS'))->format('Y-m-d 00:00:00');
        $canceled_order_status_id = $this->config->get('maxipago_order_cancelled');

        $sql = 'SELECT * FROM `' . DB_PREFIX . 'order`' .
            'WHERE `date_added` > "' . $minimum_creation_date . '" ' .
            'AND `payment_code` = "maxipago" ' .
            'AND `order_status_id` = ' . $canceled_order_status_id;

        $possibleCancelableOrders = $this->db->query($sql)->rows;

        foreach($possibleCancelableOrders as $possibleCancelableOrder)
        {
            $orderTransactionSql = 'SELECT * FROM `' . DB_PREFIX . 'maxipago_transactions` ' .
                'WHERE `id_order` = ' . $possibleCancelableOrder['order_id'] .
                ' AND `method` = "card"';

            $transactionQuery = $this->db->query($orderTransactionSql);

            if($transactionQuery->num_rows > 0)
            {
                $transaction = $transactionQuery->row;

                // It the status of the order is refund/cancel,
                // but the transaction was already refunded/voided,
                // ignore this order
                if($transaction['response_message'] == 'REFUNDED' || $transaction['response_message'] == 'VOIDED')
                    continue;

                if($this->model_extension_payment_maxipago->reverse($possibleCancelableOrder))
                {
                    array_push($canceledOrders, $possibleCancelableOrder['order_id']);
                }
            }
        }

        return $canceledOrders;
    }

    public function log($data)
    {
        if ($this->config->get('maxipago_logging')) {
            $log = new Log('maxipago_catalog.log');

            $data = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $data);
            $data = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $data);
            $data = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $data);

            $log->write($data);
        }
    }
}
