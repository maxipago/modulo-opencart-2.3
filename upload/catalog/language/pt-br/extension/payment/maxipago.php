<?php
$_['text_title'] 		    = 'maxiPago!';
$_['button_confirm'] 	    = 'Finalizar pedido com';
$_['button_sending_text']   = 'Processando...';
$_['debit_link_text']       = 'Pagar no Banco';
$_['ticket_link_text']      = 'Gerar Boleto Bancário';
$_['eft_link_text']         = 'Finalizar o Pedido na instituição bancária';
$_['redepay_link_text']     = 'Realizar o pagamento';
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

$_['dc_error_brand']                    = 'Selecione uma Bandeira';
$_['dc_error_number']                   = 'Número de Cartão Inválido';
$_['dc_error_number_mismatch_brand']    = 'O cartão digitado não condiz com a bandeira selecionada';
$_['dc_error_owner']                    = 'Nome inválido, por favor, preencha o nome e o sobrenome';
$_['dc_error_cvv']                      = 'CVV inválido';
$_['dc_error_document']                 = 'CPF inválido';

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
$_['order_dc_text']     = 'Pedido definido na maxiPago por cartão de débito com status: ';
$_['order_dc_pay']      = 'Conclua o pagamento no banco: ';
$_['order_ticket_text'] = 'Pedido finalizado na maxiPago! por Boleto Bancário.';
$_['order_eft_text']    = 'Pedido finalizado na maxiPago, faça o pagamento clicando no link a seguir: ';
$_['order_redepay_text']= 'Pedido definido na maxiPago via RedePay com status: ';
$_['order_redepay_pay'] = 'Conclua o pagamento na RedePay: ';

$_['text_error_response_voided_on_common']      = 'Status [%s] para a compra com cartão de crédito';
$_['text_error_responses_voided_on_recurring']  = 'Status [%s] no produto "%s" com recorrência "%s"';

$_['text_error_response_voided_on_common']      = 'Status [%s] for credit card';
$_['text_error_responses_voided_on_recurring']  = 'Status [%s] for product "%s" with recurring profile "%s"';

$_['common_products_transaction_message']   = '%s produto(s) finalizado(s) com cartão de crédito com status %s';
$_['recurring_product_transaction_message'] = 'Produto "%s" com recorrência "%s" pago com cartão de crédito';