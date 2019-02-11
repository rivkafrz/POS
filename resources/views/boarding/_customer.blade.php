<div class="col-md-4">
    <p class="lead">Customer Information</p>
    <hr>
    <div class="form-group {{ $errors->has('phone') ? 'has-error' : null }} row">
        <label for="name" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-10">
            <input name="phone" id="phone" type="text" class="form-control" onchange="ajaxCallCustomer()" value="{{ old('phone') }}">
            <input type="hidden" id="tickets">
            @if ($errors->has('phone'))
                <span class="help-block">
                    <span>Phone number is invalid</span>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('customer') ? 'has-error' : null }} row">
        <label for="customer" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input name="customer" type="text" class="form-control" id="name" value="{{ old('customer') }}">
            @if ($errors->has('customer'))
                <span class="help-block">
                    <span>{{ $errors->first('customer') }}</span>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 control-label">Code Baggage</label>
        <div class="col-sm-10" id="baggages">
            <input name="baggages[]" type="text" class="form-control" maxlength="3">
            <a onclick="addBaggage()" class="btn btn-primary pull-right" style="border-radius: 100px; margin-top: 10pt"><i class="fa fa-plus"></i></a>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="name" class="control-label">Charge</label>
            <input disabled id="charge" type="text" class="form-control">
        </div>
    </div>
    <div id="refunded">
    </div>
    <div class="form-group" id="button-group">
        <a data-toggle="modal" data-target="#paymentModal" class="btn btn-success col-md-4 col-md-offset-1" id="submit">Ok</a>
    </div>
</div>