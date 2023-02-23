<?php $key  = isset($key) ? $key : (int) round(microtime(true) * 1000); ?>
<tr>
    <td>
        <div class="row">
            <div class="col-md-1 col-sm-1">
                <div class="form-group">
                    <label for="">Number</label>
                    <input type="number" class="form-control" min="1" max="15" value="{{@$value->num}}" name="content[about2][{{$key}}][num]">
                </div>
            </div>
            <div class="col-md-11 col-sm-11">
                <div class="form-group">
                      <label for="">Text</label>
                      <textarea class="form-control" name="content[about2][{{$key}}][text]" id="" rows="4">{!! @$value->text !!}</textarea>
                </div>
            </div>
        </div>
        
    </td>
	<td class="remove-td-item" style="width: 0px;">
        <a href="javascript:void(0);" onclick="$(this).closest('tr').remove()" class="text-danger buttonremovetable" title="Xóa">
            <i class="fas fa-times"></i>
        </a>
    </td>
</tr>