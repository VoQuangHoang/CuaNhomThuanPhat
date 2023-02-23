<?php $key  = isset($key) ? $key : (int) round(microtime(true) * 1000); ?>
<tr>
    <td style="vertical-align: middle;">
          <select class="form-control" name="bonus_list[{{$key}}][product_bonus_id]" required>
            <option value="">Chọn sản phẩm</option>
            @foreach (@$bonusProduct as $item)
                <option value="{{$item->id}}" @if(@$value->product_bonus_id == $item->id) selected @endif>
                    {{$item->name}}
                </option>
            @endforeach
          </select>
    </td>
    <td class="align-middle">
        <input type="number" class="form-control" value="{{@$value->min_required}}" name="bonus_list[{{$key}}][condition]" required>
    </td>
    <td class="align-middle">
        <input type="number" class="form-control" value="{{@$value->bonus_quantity}}" name="bonus_list[{{$key}}][quantity]" required>
    </td>
	<td class="remove-td-item" style="width: 0px;">
        <a href="javascript:void(0);" onclick="$(this).closest('tr').remove()" class="text-danger buttonremovetable" title="Xóa">
            <i class="fas fa-times"></i>
        </a>
    </td>
</tr>