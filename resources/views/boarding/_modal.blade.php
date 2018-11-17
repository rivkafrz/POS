<div id="paymentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment Dialog</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="col-md-12">
              <label for="charge_modal">Charge</label>
              <input type="text" disabled id="charge_modal" class="form-control">
            </div>
          </div>
  
          <div class="form-group">
            <div class="col-md-12">
              @php
                  $payment_invalid = ($errors->has('payment_type') or $errors->has('cash_amount') or $errors->has('cash_change') or $errors->has('card_type') or $errors->has('bank_name') or $errors->has('no_card'))
              @endphp
              @if ($payment_invalid)
                <div class="alert alert-danger">
                  <p>Payment data is invalid</p>
                </div>
              @endif
              <div class="col-md-6">
                <input type="radio" name="payment_type" id="payment_type" value="1" onchange="showPaymentForm(1)"> Cash
              </div>
              <div class="col-md-6">
                <input type="radio" name="payment_type" id="payment_type" value="0" onchange="showPaymentForm(0)"> No Cash
              </div>
            </div>
          </div>

          <div id="payment">
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Oke</button>
      </div>
    </div>
  </div>
</div>