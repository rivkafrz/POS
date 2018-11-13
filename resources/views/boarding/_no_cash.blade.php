<div class="form-group row">
    <label for="card_type" class="col-md-2">Card Type</label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-6">
                <input type="radio" name="card_type" value="1" checked> Debit
            </div>
            <div class="col-md-6">
                <input type="radio" name="card_type" value="0"> Credit
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="card_bank" class="col-md-2">Bank</label>
    <div class="col-md-10" id="select_bank">
        @include('boarding._select_bank')
        <input type="checkbox" id="bank_not_exist" onchange="selectBank()"> Bank is not listed
    </div>
</div>

<div class="form-group row">
    <label for="no_card" class="col-md-2">Card Number</label>
    <div class="col-md-10">
        <input type="number" class="form-control" name="no_card">
    </div>
</div>