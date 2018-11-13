<select name="bank_name" class="form-control" id="card_bank">
    <option value="0">-- Select -- </option>
    @foreach ($banks as $bank)
        <option value="{{ $bank->name }}">{{ $bank->name }}</option>
    @endforeach
</select>