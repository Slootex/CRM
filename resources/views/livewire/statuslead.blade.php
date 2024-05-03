
    @CSRF
    <div class="form-group row">
        <label for="status_id" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-3">
            <select id="status_id" name="status_id" class="custom-select" wire:model="status_id">
                @foreach ($statuses as $status)
                    <option value="{{$status->id}}">{{$status->name}}</option>
                @endforeach

            </select>
        </div>
        <div class="col-sm-4">
            <div class="custom-control custom-checkbox mt-2">
                <input type="checkbox" id="no_email" name="no_email" value="1" class="custom-control-input">
                <label class="custom-control-label" for="no_email">
                    Keine E-Mail senden
                </label>
            </div>
            <div class="custom-control custom-checkbox mt-2">
                <input type="checkbox" id="public" name="public" value="1" checked="checked" class="custom-control-input">
                <label class="custom-control-label" for="public">
                    öffentlich
                </label>
            </div>
        </div>
        <div class="col-sm-3">
            <input type="hidden" name="id" value="5059">
            <button type="submit" name="new_status" value="durchführen" class="btn btn-primary" wire:click="updateStatus">durchführen <i class="fa fa-level-up" aria-hidden="true"></i></button>
        </div>$this->status_id;$this->status_id;    
    </div>


@foreach ($status_historys as $st)
    <p>{{$st}}</p>
@endforeach