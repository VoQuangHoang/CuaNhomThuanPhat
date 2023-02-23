<?php $key  = isset($key) ? $key : (int) round(microtime(true) * 1000); ?>
<tr>
    <td>
        <div class="row align-items-center">
            <div class="col-md-3 col-sm-3 text-center">
                <div>
                    <label for="">Hình ảnh người đánh giá</label>
                </div>
                <div class="image">
                    <div class="image__thumbnail mb-0 mt-2">
                        <img src="{{ !empty(@$value->image) ? @$value->image : __NO_IMAGE_DEFAULT__ }}"
                                data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                            <i class="fa fa-times"></i></a>
                        <input type="hidden" value="{{ @$value->image }}" name="content[review][list][{{$key}}][image]"/>
                        <div class="image__button" onclick="fileSelect(this)">
                            <i class="fa fa-upload"></i>
                            Upload
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <label for="">Tên người đánh giá</label>
                    <input type="text" class="form-control" value="{{@$value->name}}" name="content[review][list][{{$key}}][name]">
                </div>
                <div class="form-group w-25">
                    <label for="">Sao</label>
                    <input type="number" min="1" max="5" class="form-control" value="{{@$value->star}}" name="content[review][list][{{$key}}][star]">
                </div>
                <div>
                <div class="form-group">
                      <label for="">Nội dung</label>
                      <textarea class="form-control" name="content[review][list][{{$key}}][text]" id="" rows="4">{!! @$value->text !!}</textarea>
                    </div>
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