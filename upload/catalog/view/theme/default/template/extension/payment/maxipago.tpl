<div class="content" id="maxipago-data">

    <form id="maxipago-form">
        <div class="row-fluid">

            <div class="list-group">
                <?php if ($redepay_enabled): ?>
                    <div class="radio maxipago-redepay list-group-item">
                        <div class="panel panel-body">
                            <label>
                                <input type="radio" name="maxipago_type" value="redepay" class="maxipago-type" />
                                <img src="<?php echo $base_url;?>image/payment/maxipago/ico-cc.png"/>
                                <?php echo $redepay_text;?>
                            </label>
                        </div>

                        <div class="maxipago-tab-redepay maxipago-tab panel panel-default" style="display: none;">
                            <fieldset id="payment-maxipago-redepay" class="panel-body">

                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-redepay-cpf">
                                        <?php echo $entry_cpf_number; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="redepay_document" id="input-redepay-cpf" class="form-control cpf" />
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($ticket_enabled): ?>
                    <div class="radio maxipago-ticket list-group-item">
                        <div class="panel panel-body">
                            <label>
                                <input type="radio" name="maxipago_type" value="ticket" class="maxipago-type"/>
                                <img src="<?php echo $base_url;?>image/payment/maxipago/ico-ticket.png"/>
                                <?php echo $ticket_text;?>
                            </label>
                        </div>

                        <div class="maxipago-tab-ticket maxipago-tab panel panel-default" style="display: none;">
                            <fieldset id="payment-maxipago-ticket" class="panel-body">

                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-ticket-cpf">
                                        <?php echo $entry_cpf_number; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ticket_cpf" id="input-ticket-cpf" class="form-control cpf" />
                                    </div>
                                </div>

                                <div class="form-group"><p><?php echo $entry_ticket_instructions;?></p></div>

                            </fieldset>
                        </div>
                    </div>
                <?php endif;?>

                <?php if ($cc_enabled): ?>
                    <div class="radio maxipago-cc list-group-item">
                        <div class="panel panel-body">
                            <label>
                                <input type="radio" name="maxipago_type" value="cc" class="maxipago-type"/>
                                <img src="<?php echo $base_url;?>image/payment/maxipago/ico-cc.png"/>
                                <?php echo $cc_text;?>
                            </label>
                        </div>

                        <div class="maxipago-tab-cc maxipago-tab panel panel-default" style="display:none;">

                            <fieldset id="payment-maxipago-cc" class="panel-body">

                                <?php if ($cc_can_save && $saved_cards->num_rows): ?>
                                    <div class="form-group saved-cards">
                                        <label class="col-sm-2 control-label" for="select-cc-saved-card">
                                            <?php echo $entry_use_saved_card;?>
                                        </label>

                                        <div class="col-sm-4">
                                            <select name="cc_saved_card"
                                                    id="select-cc-saved-card"
                                                    class="form-control mp-form-select">
                                                <option value=""><?php echo $entry_select;?></option>
                                                <?php foreach ($saved_cards->rows as $card) :?>
                                                    <option value="<?php echo $card['description'];?>">
                                                        <?php echo ucwords($card['brand']);?> - <?php echo $card['description'];?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 remove" style="display:none">
                                            <label>
                                                <?php echo $entry_cc_cvv; ?>
                                                <span>
                                                    <input type="text"
                                                           name="cc_cvv2_saved"
                                                           id="input-cc-cvv2-saved"
                                                           value=""
                                                           class="mp-cvv-input"/>
                                                    <img src="<?php echo $base_url;?>image/payment/maxipago/cvv.png"/>
                                                </span>
                                            </label>
                                            <span>
                                                <a href="javascript:void(0)" id="remove-cc"><?php echo $entry_remove_card;?></a>
                                            </span>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                <?php endif;?>

                                <div class="form-group required new-card">
                                    <label class="col-sm-2 control-label" for="input-cc-type">
                                        <?php echo $entry_cc_type; ?>
                                    </label>
                                    <div class="col-sm-10">

                                        <?php foreach ($cards as $card): ?>
                                            <?php $brand = strtolower($card);?>
                                            <div class="pull-left">
                                                <label class="mp-card-brand">
                                                    <input id="input-cc-brand-<?php echo $brand;?>"
                                                           type="radio"
                                                           class="maxipago-brand hide"
                                                           name="cc_brand"
                                                           value="<?php echo $card;?>"/>
                                                    <img src="<?php echo $base_url;?>image/payment/maxipago/brands/<?php echo $brand;?>.png" alt="<?php echo $card;?>" style="max-width: 58px; max-height: 39px;"/>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>

                                <div class="form-group required new-card">
                                    <label class="col-sm-2 control-label" for="input-cc-number">
                                        <?php echo $entry_cc_number; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="number" name="cc_number" id="input-cc-number" class="form-control credit-card" />
                                    </div>
                                </div>

                                <div class="form-group required new-card">
                                    <label class="col-sm-2 control-label" for="input-cc-number">
                                        <?php echo $entry_cc_owner; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="cc_owner" placeholder="<?php echo $entry_cc_owner; ?>" id="input-cc-owner" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group required new-card">
                                    <label class="col-sm-2 control-label" for="input-cc-expire-date">
                                        <?php echo $entry_cc_expire_date; ?>
                                    </label>
                                    <div class="col-sm-5">
                                        <select name="cc_expire_date_month" id="input-cc-expire-date" class="form-control">
                                            <?php foreach ($months as $month) { ?>
                                            <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <select name="cc_expire_date_year" class="form-control">
                                            <?php foreach ($year_expire as $year) { ?>
                                            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group required new-card">
                                    <label class="col-sm-2 " for="input-cc-cvv2">
                                        <?php echo $entry_cc_cvv2; ?>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="number" name="cc_cvv2" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" class="form-control cvv" />
                                    </div>
                                    <div class="col-sm-2">
                                        <img src="<?php echo $base_url;?>image/payment/maxipago/cvv.png"/>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php if ($cc_can_save): ?>
                                            <label class="pull-left">
                                                <input type="checkbox" name="cc_save_card" value="1"/>
                                                <?php echo $entry_save_card;?>
                                            </label>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <!-- DOCUMENT -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input_cc_cpf">
                                        <?php echo $entry_cpf_number; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="cc_cpf" id="input_cc_cpf" placeholder="<?php echo $entry_cpf_number; ?>" class="form-control cpf" />
                                    </div>
                                </div>

                                <?php if ($has_recurring_products) { ?>
                                <div style="display: none;">
                                    <select id="select-installments" name="cc_installments">
                                        <option value="1"></option>
                                    </select>
                                </div>
                                <?php } else { ?>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="select-installments">
                                        <?php echo $entry_installments; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <select name="cc_installments" id="select-installments" class="form-control">
                                            <?php foreach ($installments as $installment):?>
                                            <option value="<?php echo $installment['installments'];?>" rel="<?php echo $installment['total'];?>">
                                                <?php echo $installment['installments'];?>x de <?php echo $installment['installment_value_formated'];?>
                                                <?php if (!$installment['interest_rate']): ?>
                                                (<?php echo $entry_without_interest;?>)
                                                <?php else: ?>
                                                (<?php echo $installment['interest_rate'];?>% <?php $entry_per_month;?> -
                                                <?php echo $entry_total . ': ' . $installment['total_formated'];?>)
                                                <?php endif;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>

                            </fieldset>
                        </div>
                    </div>
                <?php endif;?>

                <?php if ($dc_enabled): ?>
                    <div class="radio maxipago-dc list-group-item">
                        <div class="panel panel-body">
                            <label>
                                <input type="radio" name="maxipago_type" value="dc" class="maxipago-type"/>
                                <img src="<?php echo $base_url;?>image/payment/maxipago/ico-cc.png"/>
                                <?php echo $dc_text;?>
                            </label>
                        </div>

                        <div class="maxipago-tab-dc maxipago-tab panel panel-default" style="display:none;">
                            <fieldset id="payment-maxipago-dc" class="panel-body">

                                <!-- CARD BRAND -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-dc-type">
                                        <?php echo $entry_dc_type; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <?php foreach ($debit_cards as $card): ?>
                                        <?php $brand = strtolower($card);?>
                                        <div class="pull-left">
                                            <label class="mp-card-brand">
                                                <input id="input-dc-brand-<?php echo $brand;?>"
                                                       type="radio"
                                                       class="maxipago-brand hide"
                                                       name="dc_brand"
                                                       value="<?php echo $card;?>"/>
                                                <img src="<?php echo $base_url;?>image/payment/maxipago/brands/<?php echo $brand;?>.png" alt="<?php echo $card;?>" style="max-width: 58px; max-height: 39px;"/>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- CARD NUMBER -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input_dc_number">
                                        <?php echo $entry_dc_number; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="number" name="dc_number" id="input_dc_number" class="form-control credit-card" />
                                    </div>
                                </div>

                                <!-- CARD OWNER -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input_dc_owner">
                                        <?php echo $entry_dc_owner; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="dc_owner" placeholder="<?php echo $entry_dc_owner; ?>" id="input_dc_owner" class="form-control" />
                                    </div>
                                </div>

                                <!-- EXPIRY DATE -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input_dc_expiry_date">
                                        <?php echo $entry_dc_expiry_date; ?>
                                    </label>
                                    <div class="col-sm-5">
                                        <select name="dc_expiry_month" id="input_dc_expiry_date" class="form-control">
                                            <?php foreach ($months as $month) { ?>
                                            <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <select name="dc_expiry_year" class="form-control">
                                            <?php foreach ($year_expire as $year) { ?>
                                            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- CVV -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input_dc_cvv">
                                        <?php echo $entry_dc_cvv; ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="number" name="dc_cvv" placeholder="<?php echo $entry_dc_cvv; ?>" id="input_dc_cvv" class="form-control cvv" />
                                    </div>
                                    <div class="col-sm-2">
                                        <img src="<?php echo $base_url;?>image/payment/maxipago/cvv.png"/>
                                    </div>
                                </div>

                                <!-- DOCUMENT -->
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input_dc_document">
                                        <?php echo $entry_dc_document; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="dc_document" id="input_dc_document" placeholder="<?php echo $entry_dc_document; ?>" class="form-control cpf" />
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($eft_enabled): ?>
                    <div class="radio maxipago-eft list-group-item">
                        <div class="panel panel-body">
                            <label>
                                <input type="radio" name="maxipago_type" value="eft" class="maxipago-type"/>
                                <img src="<?php echo $base_url;?>image/payment/maxipago/ico-eft.png" />
                                <?php echo $eft_text;?>
                            </label>
                        </div>
                        <div class="maxipago-tab-eft maxipago-tab panel panel-default" style="display: none;">
                            <fieldset id="payment-maxipago-eft" class="panel-body">
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-eft-bank">
                                        <?php echo $entry_eft_bank; ?>
                                    </label>
                                    <div class="col-sm-10">

                                        <?php foreach ($eft_banks_enabled as $bank): ?>
                                        <div class="pull-left">
                                            <label class="mp-card-bank">
                                                <input id="input-cc-bank-<?php echo $bank;?>"
                                                       type="radio"
                                                       class="maxipago-bank hide"
                                                       name="eft_bank"
                                                       value="<?php echo $bank;?>"/>
                                                <img src="<?php echo $base_url;?>image/payment/maxipago/banks/<?php echo $bank;?>.png" alt="<?php echo $banks[$bank];?>" />
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-eft-cpf">
                                        <?php echo $entry_cpf_number; ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="eft_cpf" id="input-eft-cpf" class="form-control cpf" />
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                <?php endif;?>
            </div>

            <div id="maxipago-error" class="alert-danger" style="display:none;padding:10px;"></div>
            <div class="buttons">
                <div class="pull-right">
                    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary"/>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php echo $base_url;?>catalog/view/javascript/jquery/creditcardvalidator/jquery.creditCardValidator.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>catalog/view/javascript/jquery/mask/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>catalog/view/javascript/maxipago/maxipago.js"></script>
<script>
    <!--
    maxipago.validateCC = function(hasError) {
        var self = this;
        var ccOwner = $('input#input-cc-owner').val();
        var ccCvv = $('input#input-cc-cvv2').val().replace(/\D/g,'');
        var ccValidation = $('input#input-cc-number').validateCreditCard();
        var savedCard = $('select#select-cc-saved-card');

        if (
                typeof savedCard != "undefined"
                && savedCard.length > 0
                && savedCard.val() != ""
        ) {

            var ccCvvSaved = $('input#input-cc-cvv2-saved').val().replace(/\D/g,'');
            if (ccCvvSaved.length < 2 || ccCvvSaved.length > 5) {
                self.showError('<?php echo $error_cc_cvv2;?>');
                hasError = true;
            }

        } else {

            if ($('.maxipago-brand:checked').length == 0) {
                self.showError('<?php echo $error_cc_brand;?>');
                hasError = true;
            } else if (!ccValidation.valid) {
                self.showError('<?php echo $error_cc_number;?>');
                hasError = true;
            } else  if (ccOwner.split(' ').length < 2) {
                self.showError('<?php echo $error_cc_owner;?>');
                hasError = true;
            } else if (ccCvv.length < 2 || ccCvv.length > 5) {
                self.showError('<?php echo $error_cc_cvv2;?>');
                hasError = true;
            }
        }

        return hasError;
    };

    maxipago.validateDC = function() {
      var self = this;

      var hasError = false;
      var message = '';

      var debitCardBrand = $('#payment-maxipago-dc .maxipago-brand:checked');
      if(debitCardBrand.length == 0) {
          hasError = true;
          message = message + '<li><?php echo $dc_error_brand; ?></li>';
      }

      var debitCardValidation = $('#payment-maxipago-dc #input_dc_number').validateCreditCard();
      if(!debitCardValidation.valid) {
          hasError = true;
          message = message + '<li><?php echo $dc_error_number; ?></li>';
      }

      if(debitCardValidation.card_type != null) {
          if (debitCardValidation.card_type.name.toLowerCase() != debitCardBrand.val().toLowerCase()) {
              hasError = true;
              message = message + '<li><?php echo $dc_error_number_mismatch_brand; ?></li>';
          }
      }

      var debitCardOwner = $('#payment-maxipago-dc #input_dc_owner');
      if(debitCardOwner.val().split(' ').length < 2) {
          hasError = true;
          message = message + '<li><?php echo $dc_error_owner; ?></li>';
      }


      var debitCardCVV = $('#payment-maxipago-dc #input_dc_cvv');
      if(debitCardCVV.val().length < 2 || debitCardCVV.val().length > 5) {
          hasError = true;
          message = message + '<li><?php echo $dc_error_cvv; ?></li>';
      }

      var debitCardDocument = $('#payment-maxipago-dc #input_dc_document');
      if(!self.validateCPF(debitCardDocument.val())) {
          hasError = true;
          message = message + '<li><?php echo $dc_error_document; ?></li>';
      }

      if(hasError)
          self.showError('<ul>' + message + '</ul>');

      return hasError;
    };

    maxipago.validateEFT = function(hasError) {
        var self = this;
        if ($('.maxipago-bank:checked').length == 0) {
            self.showError('<?php echo $error_eft_bank;?>');
            hasError = true;
        }

        if ( ! self.validateCPF($('input#input-eft-cpf').val())) {
            self.showError('<?php echo $error_cpf;?>');
            hasError = true;
        }
        return hasError;
    };

    maxipago.validateRedepay = function() {
        var self = this;

        var hasError = false;
        var errorMessage = '';

        var redepayDocument = $('#payment-maxipago-redepay #input-redepay-cpf').val();
        if(!self.validateCPF(redepayDocument)) {
            hasError = true;
            errorMessage = '<li><?php echo $error_cpf; ?></li>';
        }

        if(hasError)
            self.showError('<ul>' + errorMessage + '</ul>');

        return hasError;
    };

    maxipago.validateTicket = function(hasError) {
        var self = this;
        if ( ! self.validateCPF($('input#input-ticket-cpf').val())) {
            self.showError('<?php echo $error_cpf;?>');
            hasError = true;
        }
        return hasError;
    };

    maxipago.maxipagoRequest = function() {
        var self = this;
        var hasError = false;

        var paymentType = $('input.maxipago-type:checked').val();

        if (paymentType == 'cc') {
            hasError = self.validateCC(hasError);
        } else if (paymentType == 'dc') {
            hasError = self.validateDC();
        }else if(paymentType == 'eft') {
            hasError = self.validateEFT(hasError);
        } else if (paymentType == 'ticket') {
            hasError = self.validateTicket(hasError);
        } else if (paymentType == 'redepay') {
            hasError = self.validateRedepay();
        }

        if (hasError)
            return false;

        var formData = $('form#maxipago-form').serialize();

        $.ajax({
            url: 'index.php?route=extension/payment/maxipago/transaction',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {
                $('#maxipago-warning').hide();
                $('#button-confirm').val('<?php echo $button_sending_text;?>').attr('disabled');
            },
            success: function(orderData){
                if(orderData.error) {
                    self.showError(orderData.message);
                    $('#button-confirm').attr('disabled');
                    return;
                }

                if(!orderData.recurring) {
                    if(typeof orderData.orderID == "undefined" || !orderData.orderID) {
                        self.showError(orderData.errorMessage);
                        $('#button-confirm').attr('disabled');
                        return;
                    }

                    if(paymentType == 'cc') {
                        orderData.installments = $('#select-installments').val();
                        orderData.total = $('#select-installments option:selected').attr('rel');
                    }
                }

                orderData.type = paymentType;

                $.ajax({
                    url: 'index.php?route=extension/payment/maxipago/confirm',
                    data: orderData,
                    type: 'POST',
                    success: function(data) {
                        if(data.error) {
                            self.showError(data.message);
                            return;
                        }

                        location.href = data.url;
                    }
                });


            },
            complete: function() {
                $('#button-confirm').val('<?php echo $button_confirm; ?>').attr('disabled', false);
            },
            error: function() {
                self.showError('<?php echo $error_transaction;?>');
                $('#button-confirm').val('<?php echo $button_confirm; ?>').attr('disabled', false);
            }
        });
    };

    maxipago.load();
    //-->
</script>
<style>
    #payment-maxipago-ticket > div,
    #payment-maxipago-cc > div,
    #payment-maxipago-dc > div,
    #payment-maxipago-eft > div{display:flex;}
    #payment-maxipago-cc .mp-card-brand img,
    #payment-maxipago-dc .mp-card-brand img,
    #payment-maxipago-eft .mp-card-bank img {
        border: none;
        -webkit-filter: grayscale(1);
        filter: grayscale(1);
        padding: 4px;
    }
    #payment-maxipago-cc .mp-card-brand img.active,
    #payment-maxipago-dc .mp-card-brand img.active,
    #payment-maxipago-eft .mp-card-bank img.active {
        border: 2px solid #db2d20;
        border-radius: 5px;
        -webkit-filter: grayscale(0);
        filter: grayscale(0);
        padding: 2px;
    }
</style>