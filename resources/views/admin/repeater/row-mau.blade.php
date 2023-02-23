<?php $key  = isset($key) ? $key : (int) round(microtime(true) * 1000); ?>
<tr>
    <td>
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div style="text-align: center;">
                    <label for="">Hình ảnh</label>
                    <div class="image">
                        <div class="image__thumbnail mb-0">
                            <img src="{{ !empty(@$value->url) ? @$value->url : __NO_IMAGE_DEFAULT__ }}"
                                    data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                            <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                <i class="fa fa-times"></i></a>
                            <input type="hidden" value="{{ @$value->url }}" name="content[list][{{$key}}][url]"/>
                            <div class="image__button" onclick="fileSelect(this)">
                                <i class="fa fa-upload"></i>
                                Upload
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Màu sản phẩm</label>
                    <input type="text" class="form-control" value="{{@$value->text}}" name="content[list][{{$key}}][text]">
                </div>
                <div class="form-group">
                    <label>Mã màu <small>(nếu có)</small></label>
                    <div id="cp1" class="input-group" title="Using input value">
                        <input type="text" class="form-control input-lg" id="backgroundColor" value="#F79922" />
                        <span class="input-group-append">
                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                    </div>
                </div>
                <script>
                    $(function () {
                        $('#cp1, #cp2, #cp3').colorpicker();
                    });
                </script>
            </div>
        </div>
        
    </td>
	<td class="remove-td-item" style="width: 0px;">
        <a href="javascript:void(0);" onclick="$(this).closest('tr').remove()" class="text-danger buttonremovetable" title="Xóa">
            <i class="fas fa-times"></i>
        </a>
    </td>
</tr>