<?php $key  = isset($key) ? $key : (int) round(microtime(true) * 1000); ?>
<tr>
    <td style="vertical-align: middle;">
        <div style="text-align: center;">
            <div class="image">
                <div class="image__thumbnail mb-0">
                    <img src="{{ !empty(@$value->image) ? @$value->image : __NO_IMAGE_DEFAULT__ }}"
                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                    <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                        <i class="fa fa-times"></i></a>
                    <input type="hidden" value="{{ @$value->image }}" name="list[{{$key}}][image]"/>
                    <div class="image__button" onclick="fileSelect(this)">
                        <i class="fa fa-upload"></i>
                        Upload
                    </div>
                </div>
            </div>
        </div>
    </td>
    <td class="align-middle">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="">Tiêu đề ảnh</label>
                    <input type="text" class="form-control" value="{{@$value->text}}" name="list[{{$key}}][text]">
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