<?php
$_['text_title'] 		    = 'maxiPago!';
$_['button_confirm'] 	    = 'Finalizar pedido com';
$_['button_sending_text']   = 'Processando...';
$_['debit_link_text']       = 'Pay in Bank';
$_['ticket_link_text']      = 'Gerar Boleto Bancário';
$_['eft_link_text']         = 'Finalizar o Pedido na instituição bancária';
$_['redepay_link_text']     = 'Pay in RedePay';
$_['text_error_reverse']    = 'Erro (%s): Ocorreu um erro com a integração e o pedido não foi estornado. Entre em contato para fazer o procedimento manual <a href="https://www.maxipago.com.br/" target="_blank">em contato conosco </a>';

//Errors
$_['error_transaction']       = 'Ocorreu um erro ao finalizar o pedido, tente novamente ou com outra forma de pagamento.';
$_['error_already_processed'] = 'Pedido já foi processado pela maxiPago!';
$_['error_save_card'] = 'maxiPago! Não foi possível salvar o cartão de crédito.';

$_['error_cc_brand']    = 'Selecione a bandeira do cartão de crédito';
$_['error_cc_number']   = 'Número de cartão inválido';
$_['error_cc_owner']    = 'Preencha o nome no cartão';
$_['error_cc_cvv2']     = 'CVV inválido';
$_['error_eft_bank']    = 'Selecione o banco ';
$_['error_cpf']         = 'CPF inválido';

$_['dc_error_brand']                    = 'Select a card brand';
$_['dc_error_number']                   = 'Invalid card number';
$_['dc_error_number_mismatch_brand']    = 'Inputed card do not match the selected brand';
$_['dc_error_owner']                    = 'Invalid name, please, type the name according to the card';
$_['dc_error_cvv']                      = 'Invalid CVV';
$_['dc_error_document']                 = 'Invalid Document';

$_['ticket_text']   = 'Boleto Bancário';
$_['cc_text']       = 'Cartão de Crédito';
$_['dc_text']       = 'Cartão de Débito';
$_['eft_text']      = 'Transferência Eletrônica';
$_['redepay_text']  = 'Redepay';

$_['entry_cpf_number'] = 'CPF / CNPJ';

//CC
$_['entry_select']          = 'Selecione';
$_['entry_cc_owner']        = 'Nome no Cartão';
$_['entry_cc_type']         = 'Bandeira';
$_['entry_cc_number']       = 'Número no Cartão';
$_['entry_cc_expire_date']  = 'Data de Expiração';
$_['entry_cc_cvv']          = 'CVV';
$_['entry_cc_cvv2']         = 'Código de Segurança';
$_['entry_installments']    = 'Parcelas';
$_['entry_per_month']       = 'a.m.';
$_['entry_without_interest']= 'sem juros';
$_['entry_total']           = 'Total';
$_['entry_save_card']       = 'Salvar Cartão';
$_['entry_use_saved_card']  = 'Usar Cartão Salvo';
$_['entry_remove_card']     = 'Remover Cartão';

//DC
$_['entry_dc_type']         = 'Bandeira';
$_['entry_dc_owner']        = 'Nome no Cartão';
$_['entry_dc_number']       = 'Número do Cartão';
$_['entry_dc_expiry_date']  = 'Data de Validade';
$_['entry_dc_cvv']          = 'CVV';
$_['entry_dc_document']     = 'CPF';

//EFT
$_['entry_eft_bank']        = 'Banco';

//Ticket
$_['entry_ticket_instructions']  = 'Ao finalizar, você receberá um link para impressão do boleto';


$_['order_message_complete']    = 'O pedido foi finalizado';
$_['order_message_processing']  = 'O pedido foi processado pela maxiPago!';
$_['order_message_cancelled']   = 'O pedido foi cancelado pela maxiPago!';
$_['order_message_reverse']     = 'O pedido foi estornado para a maxiPago!';
$_['order_error']               = 'Houve um erro com seu pedido, entre em contato conosco para maiores informações';
$_['order_cancelled']           = 'O pedido foi cancelado na administração da loja';

$_['order_cc_text']     = 'Pedido finalizado na maxiPago! por cartão de crédito, o status do seu pedido é:';
$_['order_dc_text']     = 'Order putted on maxiPago! by debit card with status: ';
$_['order_dc_pay']      = 'Finish the payment on the bank: ';
$_['order_ticket_text'] = 'Pedido finalizado na maxiPago! por Boleto Bancário.';
$_['order_eft_text']    = 'Pedido finalizado na maxiPago, faça o pagamento clicando no link a seguir: ';
$_['order_redepay_text']= 'Order putted on maxiPago! with RedePay with status: ';
$_['order_redepay_pay'] = 'Finish the payment in RedePay environment: ';

$_['common_products_transaction_message']   = '%s product(s) finnished by credit card with status %s';
$_['recurring_product_transaction_message'] = 'Product "%s" with recurring profile "%s" paid by credit card';