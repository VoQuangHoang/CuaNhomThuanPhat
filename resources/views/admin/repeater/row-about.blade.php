<?php $key  = isset($key) ? $key : (int) round(microtime(true) * 1000); ?>
<tr>
    <td>
        <div class="row align-items-center">
            <div class="col-sm-3">
                <div>
                    <div>
                        <label for="">Hình ảnh khối</label>
                    </div>
                    <div class="image text-center">
                        <div class="image__thumbnail mb-0 mt-2" style="height: 200px;">
                            <img src="{{ !empty(@$value->image) ? @$value->image : __NO_IMAGE_DEFAULT__ }}"
                                    data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                            <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                <i class="fa fa-times"></i></a>
                            <input type="hidden" value="{{ @$value->image }}" name="content[about][{{$key}}][image]"/>
                            <div class="image__button" onclick="fileSelect(this)">
                                <i class="fa fa-upload"></i>
                                Upload
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-info" type="radio" id="{{$key}}" value="left" name="content[about][{{$key}}][position]" @if(@$value->position == 'left') checked @endif>
                            <label for="{{$key}}" class="custom-control-label">Hiển thị ảnh bên trái</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-info" type="radio" id="{{$key}}b" value="right" name="content[about][{{$key}}][position]" @if(@$value->position == 'right') checked @endif>
                            <label for="{{$key}}b" class="custom-control-label">Hiển thị ảnh bên phải</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <label for="">Tiêu đề ảnh</label>
                    <input type="text" class="form-control" value="{{@$value->title}}" name="content[about][{{$key}}][title]">
                </div>
                <div>
                <div class="form-group">
                      <label for="">Nội dung</label>
                      <textarea class="form-control" name="content[about][{{$key}}][text]" id="" rows="8">{!! @$value->text !!}</textarea>
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