<div class="col-md-4">
    <p class="lead">Customer Information</p>
    <hr>
    <div class="form-group row">
        <label for="name" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-10">
            <input name="phone" id="phone" type="text" class="form-control" onchange="ajaxCallCustomer()">
            <input type="hidden" id="tickets">
        </div>
    </div>

    <div class="form-group row">
        <label for="customer" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input name="customer" type="text" class="form-control" id="name">
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 control-label">Baggage</label>
        <div class="col-sm-10" id="baggages">
            <input name="baggages[]" type="text" class="form-control">
            <a onclick="addBaggage()" class="btn btn-primary pull-right" style="border-radius: 100px; margin-top: 10pt"><i class="fa fa-plus"></i></a>
        </div>
    </div>
    <div class="form-group" id="button-group">
        <button type="submit" class="btn btn-success col-md-4 col-md-offset-1" id="submit">Ok</button>
    </div>
</div>