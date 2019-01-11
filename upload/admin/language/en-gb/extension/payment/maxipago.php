<?php
// Heading
$_['heading_title']       		= 'maxiPago!';

// Text
$_['text_maxipago'] = '<a target="_BLANK" href="https://www.maxipago.com.br"><img src="view/image/payment/maxipago.jpg" alt="maxiPago!" title="maxiPago!" style="border: 1px solid #EEEEEE;height:25px;" /></a>';

$_['text_payment']        		= 'Pagamento';
$_['text_success']        		= 'Sucesso: Você modificou os detalhes da sua conta da maxiPago!!';
$_['text_success_no_sync'] 		= 'Consulta finalizada, nenhum pedido foi atualizado';
$_['text_success_sync']    		= 'Sucesso: um total de %s pedidos foram atualizados';
$_['text_success_order_sync']   = 'Pedido: %s';
$_['text_error_sync']    		= 'Erro: Ocorreu um erro com a integração, tente novamente mais tarde ou entre <a href="https://www.maxipago.com.br/fale-conosco/" target="_blank">em contato conosco </a>';
$_['text_error_reverse']    	= 'Erro: Ocorreu um erro com a integração e o pedido não foi estornado na maxiPago!. Entre em contato para fazer o procedimento manual <a href="https://www.maxipago.com.br/fale-conosco/" target="_blank">em contato conosco </a>';
$_['text_edit']                 = 'Editar a maxiPago!';
$_['text_sync']                 = 'Sincronizar Pedidos';
$_['text_select']               = 'Selecione';
$_['text_cron']                 = 'É possível fazer a consulta de todos os pedidos que estão pendentes na loja utilizando o botão "Sincronizar Pedidos", porém, caso queira que a consulta seja feita automaticamente, pode-se criar uma cron no seu servidor com o seguinte comando:';
$_['comment_updated_order']    	= 'O pedido foi atualizado pelo maxiPago! com o status:';
$_['comment_overpaid_order']    = 'O pedido foi atualizado pela maxiPago mas o Boleto foi pago com valor acima.';
$_['comment_underpaid_order']   = 'O pedido foi atualizado pela maxiPago mas o Boleto foi pago com valor abaixo.';

$_['text_kount']    	= 'Kount';
$_['text_clearsale']    = 'Clear Sale';
$_['text_test']    	    = 'Teste';
$_['text_production']   = 'Produção';
$_['text_decline']    	= 'Recusar';
$_['text_continue']    	= 'Continuar';

//Tabs
$_['tab_general']               = 'Configurações Gerais';
$_['tab_order_cc']              = 'Cartão de Crédito';
$_['tab_order_dc']              = 'Debit Card';
$_['tab_order_redepay']         = 'Redepay';
$_['tab_order_ticket']          = 'Boleto';
$_['tab_order_eft']             = 'TEF';
$_['tab_order_status']          = 'Status';

//Order Messages
$_['order_message_processing']  = 'O pedido está em Análise pela maxiPago!';
$_['order_message_complete']    = 'O pedido foi aprovado pela maxiPago!';
$_['order_message_cancelled']   = 'O pedido foi cancelado pela maxiPago!';
$_['order_message_reverse']     = 'O pedido foi estornado para a maxiPago!';

// Entry
$_['entry_store_id']            = 'maxiPago! ID da Loja';
$_['help_store_id']			    = 'ID da Loja fornecido pela maxiPago!';

$_['entry_consumer_key']        = 'maxiPago! Chave da Loja';
$_['help_consumer_key']			= 'Chave de acesso da loja fornecido pela maxiPago!';

$_['entry_secret_key']          = 'maxiPago! Chave Secreta';
$_['help_secret_key']			= 'Chave secreta de acesso fornecida pela maxiPago!';

$_['entry_method_title']        = 'Título do método de pagamento';
$_['help_method_title']			= 'Nome que será exibido para essa forma de pagamento na finalização';

$_['entry_minimum_amount']      = 'Valor mínimo do Pedido';
$_['help_minimum_amount']		= 'Total mínimo que o pedido deve alcançar para que este método de pagamento seja habilitado.';

$_['entry_maximum_amount']      = 'Valor máximo do Pedido';
$_['help_maximum_amount']		= 'Total máximo que o pedido deve ter para que este método de pagamento esteja habilitado.';

$_['entry_order_processing'] 	= 'Status em andamento';
$_['help_order_processing']		= 'O maxiPago! recebeu a transação e o pedido está em análise';

$_['entry_order_authorized'] 	= 'Status para pedidos autorizados';
$_['help_order_authorized']		= 'A transação foi finalizada e o pagamento autorizado';

$_['entry_order_refunded'] 	    = 'Status para pedidos estornados';
$_['help_order_refunded']		= 'Quando mudar para esse status, irá gerar um estorno para a maxiPago!';

$_['entry_order_approved'] 	    = 'Status pedidos aprovados';
$_['help_order_approved']		= 'A transação foi finalizada e o pagamento aprovado';

$_['entry_order_cancelled'] 	= 'Status cancelado';
$_['help_order_cancelled']		= 'A transação foi cancelada, pagamento foi negado, estornado, ocorreu um chargeback';

$_['entry_cc_order_reverse'] 	= 'Estornar ao Cancelar';
$_['help_cc_order_reverse']		= 'Quando o pedido for cancelado ou excluído, será enviado um estorno automático para a maxiPago!';

$_['entry_geo_zone']      		= 'Região geográfica';
$_['entry_status']        		= 'Situação';
$_['entry_sort_order']    		= 'Ordenação';
$_['entry_logging']        		= 'Habilitar Log';

$_['entry_environment']         = 'Ambiente da aplicação';
$_['help_environment']         	= 'Escolha se a aplicação está em ambiente de produção ou ambiente de teste';
$_['entry_test']         		= 'Teste';
$_['entry_production']         	= 'Produção';

$_['entry_street_number']       = 'Campo para Número de Endereço';
$_['help_street_number']        = 'Escolha o campo personalizado de cliente que será usado como número do endereço';

$_['entry_street_complement']   = 'Campo para Complemento de Endereço';
$_['help_street_complement']    = 'Escolha o campo personalizado de cliente que será usado como complemento de endereço';

//CC
$_['entry_cc_enabled']          = 'Habilitar Cartão de Crédito';

$_['entry_cc_soft_descriptor']  = 'Soft Descriptor (Nome na Fatura)';
$_['help_cc_soft_descriptor']   = 'Apenas para adquirente Cielo. Não use caracteres especiais e use no máximo 20 caracteres.';

$_['entry_cc_max_installments']                 = 'Quantidade máxima de parcelas';
$_['entry_cc_installments_without_interest']    = 'Quantidade de parcelas sem juros';
$_['entry_cc_interest_type']    = 'Tipo de Juros';
$_['entry_simple']              = 'Simples';
$_['entry_compound']            = 'Composto';
$_['entry_price']               = 'Price';

$_['entry_cc_interest_rate']    = 'Taxa de Juros';
$_['help_cc_interest_rate']     = 'Taxa de juros por mês, usar o ponto (.) como separador de decimal, ex: 1.99';

$_['entry_cc_min_per_installments'] = 'Valor mínimo por parcela';
$_['help_cc_min_per_installments']  = 'Valor mínimo por parcela, usar o ponto (.) como separador de decimal, ex: 19.99';

$_['entry_cc_processing_type']  = 'Tipo de Venda';
$_['entry_cc_auth']             = 'Autorização (Somente Autorizar)';
$_['entry_cc_sale']             = 'Venda Direta (Autorizar e Capturar)';

$_['entry_cc_can_save']         = 'Permitir Salvar Cartão de Crédito';
$_['entry_cc_fraud_check']      = 'Verificação de Fraude';
$_['entry_cc_fraud_processor']  = 'Responsável pela Análise de Fraude';
$_['entry_cc_auto_capture']     = 'Auto Capture';
$_['entry_cc_auto_void']        = 'Auto Void';
$_['entry_cc_fraud_processor']  = 'Fraud Processor';
$_['entry_cc_clearsale_app']    = 'ClearSale App';
$_['entry_cc_3ds']              = 'Usar 3DS';
$_['entry_cc_3ds_processor']    = 'MPI Processor';
$_['entry_cc_3ds_failure_action']  = 'Ação ao falhar';
$_['entry_cc_processors']       = 'Responsável pela Análise de Fraude';

$_['text_notification']             = 'Notification URLs';
$_['text_notification_configure']   = 'Configure those urls on your maxiPago panel';
$_['text_url_success']              = 'Success';
$_['text_url_error']                = 'Error';
$_['text_url_notification']         = 'Notification';


$_['entry_cc_processors']       = 'Adquirentes';

// DEBIT CARD
$_['entry_dc_enabled']                      = 'Enable Debit Card';
$_['entry_dc_soft_descriptor']              = 'Soft Descriptor';
$_['entry_dc_processors']                   = 'Acquirers';
$_['entry_dc_mpi_processor']                = 'MPI Processor';
$_['entry_dc_mpi_processor_test']           = 'Test Simulator';
$_['entry_dc_mpi_processor_deployment']     = 'Deployment';
$_['entry_dc_failure_action']               = 'Failure Action';
$_['entry_dc_failure_action_continue']      = 'Continue';
$_['entry_dc_failure_action_decline']       = 'Decline';

//REDEPAY
$_['entry_redepay_enabled'] = 'Habilitar Redepay';

//TICKET
$_['entry_ticket_enabled']          = 'Habilitar Boleto Bancário';
$_['entry_ticket_days_to_expire']   = 'Dias para o Vencimento';
$_['entry_ticket_instructions']     = 'Instruções do Boleto';
$_['entry_ticket_bank']             = 'Banco';

//EFT
$_['entry_eft_enabled']             = 'Habilitar Transferência Eletrônica';
$_['entry_eft_banks']               = 'Bancos';

//Buttons
$_['text_custom_field']         = 'Criar campo';
$_['button_sync']               = 'Sincronizar Pedidos';

$_['boleto_text']               = 'Gerar Boleto';
$_['order_deleted']             = 'O pedido foi excluído da administração da loja e estornado ao maxiPago!';
$_['order_cancelled']           = 'O pedido foi cancelado na administração da loja';

// Error
$_['error_permission']    		= 'Atenção: Você não possui permissão para modificar a maxiPago!!';
$_['error_consumer']            = 'Digite o CONSUMER KEY de acesso à maxiPago!';
$_['error_secret']         		= 'Digite o SECRET KEY de acesso à maxiPago!';

$_['comment_update_order'] = 'Order updated at maxiPago! to status: ';